<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\Application;

class ApplicationAdmin extends Admin
{
    protected $baseRouteName = 'candidature';
    protected $baseRoutePattern = 'candidature';

    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'desc',
        '_sort_by' => 'created',
    );

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('name', null, array('label'=>"Nom du projet") )
            ->add('description', null, array('label'=>"Description du projet"))
            ->add('startOccupation', 'date', array(
                    'label'=>"Date d'entrée souhaitée",

            ))
            ->add('endOccupation', 'date', array(

                    'label'=>"Date de sortie souhaitée",

            ))
            ->add('space')
            ->add('category', null, array('label'=>"Categorie du projet",'required'=> true))
            ->add('projectHolder')

            ->add('files', 'sonata_type_collection',
                array('by_reference' => false,

                    'label' => 'Photos',
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
            ->add('name')
            ->add('projectHolder')
            ->add('space')
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
