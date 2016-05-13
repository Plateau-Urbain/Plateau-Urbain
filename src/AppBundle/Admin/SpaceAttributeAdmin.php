<?php

namespace AppBundle\Admin;

use AppBundle\Entity\SpaceAttribute;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SpaceAttributeAdmin extends Admin
{
    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'attribute',
    );

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('attribute', null, array('label' => 'Nom'))
            ->add('availability', 'choice', array('choices' => SpaceAttribute::getAllStatus(), 'required' => false, 'label' => 'Disponibilité'))
            ->end();
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('attribute')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('attribute')
        ;
    }

    public function getNewInstance()
    {
        $instance = parent::getNewInstance();

        return $instance;
    }
}
