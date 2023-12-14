<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use AppBundle\Entity\ApplicationFile;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\Application;

class ApplicationAdmin extends AbstractAdmin
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
            ->add('status', 'choice', array('label' => 'Statut', 'choices' => Application::getStatusLabels()))
            ->add('space', null, array('label' => 'Espace'))
            ->add('projectHolder', null, array('label' => 'Porteur de projet'))
            ->add('name', null, array('label'=>"Nom du projet") )
            ->add('category', null, array('label'=>"Categorie du projet",'required'=> true))
            ->add('wishedSize', null, array('label'=> 'Surface souhaitée (m²)'))
            ->add('lengthOccupation', null, array('label'=> 'Durée d\'occupation'))
            ->add('lengthTypeOccupation', 'choice', array('choices' => Application::getAllLengthType(), 'label'=> 'Durée d\'occupation'))
            ->add('startOccupation', 'date', array('label'=>"Date d'entrée souhaitée"))
            ->add('description', null, array('label'=>"Description du projet"))
            ->add('openToGlobalProject', 'choice', array('label'=> "Ouvert à faire partie d'un projet collectif", 'choices' => ['Oui' => true, 'Non' => false]))
            ->add('contribution', null, array('label'=> "Contribution au projet global du propriétaire"))
            ->add('devenirSocietaire', 'choice', array('label'=> "Souhaite être informé(e) des modalités pour devenir sociétaire", 'choices' => ['Oui' => true, 'Non' => false]))


            ->end()
            ->with('Documents')
              ->add('files', 'sonata_type_collection',
                  array('by_reference' => false,
                    'label' => 'Documents',
                  ),
                  array(
                    'edit' => 'inline',
                    'inline' => 'table',
                  )
              )
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
            ->addIdentifier('space')
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

    public function getExportFields() {
        return array(
          'Espace' => 'space',
          'Statut' => 'statusLabel',
          'Nom' => 'name',
          'Structure' => 'projectHolder.company',
          'Nom du porteur' => 'projectHolder.fullName',
          'Téléphone' => 'projectHolder.companyPhone',
          'Email' => 'projectHolder.email',
          'Présentation' => 'projectHolder.companyDescription',
          'Facebook' => 'projectHolder.facebookUrl',
          'Twitter' => 'projectHolder.twitterUrl',
          'Instagram' => 'projectHolder.instagramUrl',
          'Google+' => 'projectHolder.googleUrl',
          'Linkedin' => 'projectHolder.linkedinUrl',
          'Autre' => 'projectHolder.otherUrl',
          'Description' => 'description',
          'Date de dépôt de la candidature' => 'created',
          'Type de projet' => 'category',
          'Surface recherchée' => 'wishedSize',
          'Durée d\'occupation souhaitée' => 'fullLengthOccupation',
          'Date d\'entrée souhaitée' => 'startOccupation',
          'Contribution au projet du propriétaire' => 'contribution'
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
