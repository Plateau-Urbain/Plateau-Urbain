<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\Category;

class CategoryAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'category';
    protected $baseRoutePattern = 'category';

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
            ->add('name', null, array('label' => "Type d'usage"))
            ->add('isActive', null, array(
                'label' => "Actif",
                'required' => false,
                'help' => "Décocher pour archiver : la valeur ne sera plus proposée dans les formulaires utilisateurs, mais reste visible pour les candidatures/profils qui l'ont déjà sélectionnée.",
            ))
            ->add('requiresErp', null, array(
                'label' => "Réservé aux lieux ERP",
                'required' => false,
                'help' => "Si coché, ce type d'usage ne sera proposé aux candidats que pour les espaces marqués comme ERP (Établissement Recevant du Public).",
            ))

            ->end()

        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('label' => "Type d'usage"))
            ->add('isActive', null, array('label' => "Actif"))
            ->add('requiresErp', null, array('label' => "Réservé ERP"))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => "Type d'usage"))
            ->add('isActive', null, array(
                'label' => "Actif",
                'editable' => true,
            ))
            ->add('requiresErp', null, array(
                'label' => "Réservé ERP",
                'editable' => true,
            ))
        ;
    }

    public function getNewInstance()
    {
        $instance = parent::getNewInstance();

        return $instance;
    }
}
