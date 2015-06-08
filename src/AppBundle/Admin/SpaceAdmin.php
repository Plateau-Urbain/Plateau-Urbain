<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\User;

class SpaceAdmin extends Admin
{
    public function prePersist($space)
    {
        foreach ($space->getSpaceAttributes() as $spaceAttribute) {
            $spaceAttribute->setSpace($space);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate($space)
    {
        foreach ($space->getSpaceAttributes() as $spaceAttribute) {
            $spaceAttribute->setSpace($space);
        }
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
                'label' => "Propriétaire de l'espace",
                'query_builder' => function (\AppBundle\Repository\UserRepository $repository) {
                    return $repository->getByTypeQueryBuilder(User::PROPRIO);
                },
            ))
            ->add('description', null, array('label' => "Description de l'espace"))
            ->add('locationDescription', null, array('label' => 'Description de la situation du lieu'))
            ->add('usageRestriction', 'text', array('label' => "Condition d'utilisation du lieu"))
            ->add('surface', null, array('label' => 'Nombre total de m2'))
            ->add('size', null, array('label' => 'Taille des lots possibles'))
            ->add('availability', null, array('label' => 'Période de disponibilité'))
            ->add('limitAvailability', null, array('label' => 'Date de fin de candidature possible'))
            ->add('price', null, array('label' => 'Prix de la redevance au m2 mensuel'))
            ->add('spaceAttributes', 'sonata_type_collection', array(
                'label' => "Attributs de l'espace",
                'required' => false,
            ), array(
                'edit'              => 'inline',
                'inline'            => 'table',
                'sortable'          => 'position',
            ))
            ->add('pics', 'sonata_type_collection',
                array('by_reference' => false,
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                ))
            ->end()

        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('owner')
            ->add('enabled')
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

        return $instance;
    }

    public function getFormTheme()
    {
        return array_merge(
            array('AppBundle:Form:custom_admin_fields.html.twig'),
            parent::getFormTheme()
        );
    }
}
