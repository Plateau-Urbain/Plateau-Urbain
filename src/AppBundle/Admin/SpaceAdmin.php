<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use AppBundle\Form\SpaceDocumentType;
use AppBundle\Form\SpaceImageType;
use AppBundle\Form\SpaceAttributeAdminType;
use AppBundle\Form\ParcelType;
use AppBundle\Form\SpaceVisitType;
use AppBundle\Form\SpaceDocAdminType;

class SpaceAdmin extends AbstractAdmin
{
    public function syncSpace($space, $children)
    {
        foreach ($children as $child) {
            $child->setSpace($space);
        }
    }
    public function prePersist($space)
    {
        $this->syncSpace($space, $space->getPics());
        $this->syncSpace($space, $space->getDocuments());
        $this->syncSpace($space, $space->getVisits());
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($space)
    {
        $this->syncSpace($space, $space->getPics());
        $this->syncSpace($space, $space->getDocuments());
        $this->syncSpace($space, $space->getVisits());
    }

    /**
     * {@inheritdoc}
     * Supprime les applications associées avant de supprimer l'espace
     */
    public function preRemove($space)
    {
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');

        $applications = $em->getRepository('AppBundle:Application')->findBy(['space' => $space]);

        foreach ($applications as $application) {
            $applicationFiles = $em->getRepository('AppBundle:ApplicationFile')->findBy(['application' => $application]);
            foreach ($applicationFiles as $file) {
                $em->remove($file);
            }
            $em->remove($application);
        }
        // Pas de flush() ici : Sonata commitera tout (fichiers + candidatures + espace)
        // en une seule transaction atomique via son propre flush().
    }

    protected $baseRouteName = 'property';
    protected $baseRoutePattern = 'property';

    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'limitAvailability',
    );

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('name', null, array('label' => "Nom de l'espace"))
            ->add('owner', null, array(
                'required' => true,
                'label' => "Propriétaire de l'espace",
                'query_builder' => function (UserRepository $repository) {
                    return $repository->getByTypeQueryBuilder(User::PROPRIO);
                },
            ))
            ->add('zipCode', null, array('label' => "Code postal"))
            ->add('city', null, array('label' => "Ville"))
            ->add('limitAvailability', null, array('label' => 'Date limite de candidature'))
            ->add('availability', null, array('label' => 'Période de disponibilité'))
            ->add('type', null, array('label' => 'Type de locaux', 'required' => true))
            ->add('description', null, array('label' => 'Description', 'attr' => ['class' => 'trumbowyg']))
            ->add('activityDescription', null, array('label' => 'Activités recherchées', 'attr' => ['class' => 'trumbowyg']))
            ->add('price', null, array('label' => 'Prix au m² mensuel', 'required' => false))
            ->add('priceText', null, array('label' => 'Prix personnalisé (texte libre)', 'required' => false))
            ->add('nbSpaces', null, array('label' => "Nombre d'espaces", 'required' => false))
            ->add('minSpace', null, array('label' => 'Surface minimale (m²)', 'required' => false))
            ->add('maxSpace', null, array('label' => 'Surface maximale (m²)', 'required' => false))

            ->end()
            // Section "Prestations et services" désactivée — les tags/attributs ne sont plus utilisés en front-end
            // ->with('Prestations et services')
            // ->add('tags', CollectionType::class, array(
            //         'entry_type' => SpaceAttributeAdminType::class,
            //         'allow_delete' => true,
            //         'allow_add' => true,
            //         'by_reference' => false,
            //         'label' => 'Attributs',
            //     ),
            //     array(
            //         'edit' => 'inline',
            //         'inline' => 'table',
            //     ))
            // ->end()
            // Section "Lots" désactivée — la gestion des lots a été retirée du formulaire front-end
            // ->with('Lots')
            // ->add('parcels', CollectionType::class, array(
            //     'entry_type' => ParcelType::class,
            //     'allow_delete' => true,
            //     'allow_add' => true,
            //     'by_reference' => false,
            //     'label' => 'Lots',
            // ), array(
            //     'edit' => 'inline',
            //     'inline' => 'table',
            // ))
            // ->end()
            ->with('Photos')

            ->add('pics', CollectionType::class, array(
                    'entry_type' => SpaceImageType::class,
                    'allow_delete' => true,
                    'allow_add' => true,
                    'by_reference' => false,
                    'label' => 'Photos',
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                ))

            ->end()
            ->with('Documents PDF (propriétaire)')

            ->add('docAac', SpaceDocAdminType::class, array(
                'label'     => "Appel à candidature (PDF)",
                'required'  => false,
                'file_type' => 'document_aac',
            ))
            ->add('docPlan', SpaceDocAdminType::class, array(
                'label'     => "Répartition des espaces (PDF)",
                'required'  => false,
                'file_type' => 'document_plan',
            ))
            ->add('docFaq', SpaceDocAdminType::class, array(
                'label'     => "F.A.Q (PDF)",
                'required'  => false,
                'file_type' => 'document_faq',
            ))

            ->end()
            ->with('Documents requis (candidature)')

            ->add('documents', CollectionType::class, array(
                    'entry_type' => SpaceDocumentType::class,
                    'by_reference' => false,
                    'allow_delete' => true,
                    'allow_add' => true,
                    'label' => false
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                ))

            ->end()

            ->with('Visites programmées')

            ->add('visits', CollectionType::class, array(
                    'entry_type' => SpaceVisitType::class,
                    'allow_delete' => true,
                    'allow_add' => true,
                    'by_reference' => false,
                    'label' => false,
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                ))

            ->end()

            ->with('Publication')
                ->add('enabled', 'choice', array('label' => 'En ligne', 'required' => false, 'choices' => ['Oui' => true, 'Non' => false], 'placeholder' => false))
                ->add('closed', 'choice', array('label' => 'Clôturé', 'required' => false, 'choices' => ['Oui' => true, 'Non' => false], 'placeholder' => false))
            ->end()


        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('label' => 'Nom'))
            ->add('owner', null, array('label' => 'Propriétaire'))
            ->add('city', null, array('label' => 'Ville'))
            ->add('type', null, array('label' => 'Type de locaux'))
            ->add('enabled', null, array('label' => 'En ligne'))
            ->add('submitted', null, array('label' => 'Soumis'))
            ->add('closed', null, array('label' => 'Clôturé'))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'Nom'))
            ->add('owner', null, array('label' => 'Propriétaire'))
            ->add('city', null, array('label' => 'Ville'))
            ->add('limitAvailability', null, array(
                'label' => 'Date limite de candidature',
                'format' => 'd/m/Y',
                'sortable' => true,
            ))
            ->add('enabled', null, array('label' => 'En ligne'))
            ->add('submitted', null, array('label' => 'Soumis'))
            ->add('closed', null, array('label' => 'Clôturé'))
            ->add('_action', null, array(
                'label' => 'Actions',
                'actions' => array(
                    'edit'   => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }

    public function getNewInstance()
    {
        $instance = parent::getNewInstance();
        $instance->setEnabled(true);
        $instance->setClosed(false);

        return $instance;
    }

    public function getFormTheme()
    {
        return array_merge(
            array('AppBundle:Form:custom_admin_fields.html.twig'),
            parent::getFormTheme()
        );
    }

    public function getDataSourceIterator()
    {
        $datagrid = $this->getDatagrid();
        $datagrid->buildPager();

        $datasourceit = $this->getModelManager()->getDataSourceIterator($datagrid, $this->getExportFields());
        $datasourceit->setDateTimeFormat('d/m/Y H:i');

        return $datasourceit;
    }
}
