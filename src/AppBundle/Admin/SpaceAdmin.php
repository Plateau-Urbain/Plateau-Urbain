<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use AppBundle\Form\SpaceDocumentType;
use AppBundle\Form\SpaceImageType;
use AppBundle\Form\SpaceAttributeAdminType;
use AppBundle\Form\ParcelType;

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
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($space)
    {
        $this->syncSpace($space, $space->getPics());
        $this->syncSpace($space, $space->getDocuments());
    }

    protected $baseRouteName = 'property';
    protected $baseRoutePattern = 'property';

    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'name',
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
            ->add('limitAvailability', null, array('label' => 'Date de fin de candidature possible'))
            ->add('availability', null, array('label' => 'Période de disponibilité'))
            ->add('type', null, array('label' => "Type d'espace", 'required' => true))
            ->add('description', null, array('label' => "Description de l'espace", 'attr' => ['class' => 'trumbowyg']))
            ->add('activityDescription', null, array('label' => "Activités recherchées", 'attr' => ['class' => 'trumbowyg']))
            ->add('price', null, array('label' => 'Prix de la redevance au m² mensuel'))
            ->add('usageRestriction', null, array('label' => "Condition d'utilisation du lieu"))

            ->end()
            ->with('Prestations et services')

            ->add('tags', CollectionType::class, array(
                    'entry_type' => SpaceAttributeAdminType::class,
                    'allow_delete' => true,
                    'allow_add' => true,
                    'by_reference' => false,
                    'label' => 'Attributs',
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                ))

            ->end()
            ->with('Lots')

            ->add('parcels', CollectionType::class, array(
                'entry_type' => ParcelType::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
                'label' => 'Lots',
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
            ))

            ->end()
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
            ->with('Documents')

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

            ->with('Publication')
                ->add('enabled', 'choice', array('label' => 'En ligne', 'required' => false, 'choices' => ['Oui' => true, 'Non' => false]))
                ->add('closed', 'choice', array('label' => 'Clotûré', 'required' => false, 'choices' => ['Oui' => true, 'Non' => false]))
            ->end()


        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('owner', null, array('label' => 'Propriétaire'))
            ->add('enabled', null, array('label' => 'En ligne'))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
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
