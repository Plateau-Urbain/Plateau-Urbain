<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use AppBundle\Entity\ApplicationFile;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
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

    /**
     * Configure les routes personnalisées
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('select_export_fields', 'select-export-fields');
        $collection->add('custom_export', 'custom-export');
        $collection->add('help_filters', 'help-filters-export');
    }

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
            ->add('name', null, array('label' => 'Nom du projet'))
            ->add('status', null, array('label' => 'Statut'), 'choice', array(
                'choices' => Application::getStatusLabels()
            ))
            ->add('selected', null, array('label' => 'Sélectionné'))
            ->add('category', null, array('label' => 'Catégorie'))
            ->add('projectHolder', null, array('label' => 'Porteur de projet'))
            ->add('space', null, array('label' => 'Espace'))
            ->add('created', 'doctrine_orm_date_range', array('label' => 'Date de création'))
            ->add('startOccupation', 'doctrine_orm_date_range', array('label' => 'Date d\'entrée souhaitée'))
            ->add('wishedSize', null, array('label' => 'Surface souhaitée (m²)'))
            ->add('openToGlobalProject', null, array('label' => 'Ouvert au projet collectif'))
        ;
    }
    
    // Fields to be shown on show page
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Informations générales', array('class' => 'col-md-6'))
                ->add('id', null, array('label' => 'ID'))
                ->add('name', null, array('label' => 'Nom du projet'))
                ->add('status', 'choice', array(
                    'label' => 'Statut',
                    'choices' => Application::getStatusLabels(),
                    'catalogue' => 'messages',
                    'template' => 'AppBundle:Admin:show_status.html.twig'
                ))
                ->add('selected', null, array('label' => 'Sélectionné'))
                ->add('space', null, array('label' => 'Espace'))
                ->add('category', null, array('label' => 'Catégorie'))
                ->add('created', 'datetime', array('label' => 'Date de création', 'format' => 'd/m/Y à H:i'))
                ->add('updated', 'datetime', array('label' => 'Date de mise à jour', 'format' => 'd/m/Y à H:i'))
            ->end()
            ->with('Porteur de projet', array('class' => 'col-md-6'))
                ->add('projectHolder.fullName', null, array('label' => 'Nom complet'))
                ->add('projectHolder.email', null, array('label' => 'Email'))
                ->add('projectHolder.company', null, array('label' => 'Structure'))
                ->add('projectHolder.companyPhone', null, array('label' => 'Téléphone'))
            ->end()
            ->with('Description du projet', array('class' => 'col-md-12'))
                ->add('description', 'text', array('label' => 'Description'))
                ->add('contribution', 'text', array('label' => 'Contribution au projet du propriétaire'))
                ->add('openToGlobalProject', null, array('label' => 'Ouvert au projet collectif'))
                ->add('devenirSocietaire', null, array('label' => 'Souhaite devenir sociétaire'))
            ->end()
            ->with('Informations sur l\'occupation', array('class' => 'col-md-6'))
                ->add('wishedSize', null, array('label' => 'Surface souhaitée (m²)'))
                ->add('fullLengthOccupation', null, array('label' => 'Durée d\'occupation'))
                ->add('startOccupation', 'date', array('label' => 'Date d\'entrée souhaitée', 'format' => 'd/m/Y'))
            ->end()
            ->with('Documents', array('class' => 'col-md-6'))
                ->add('files', null, array('label' => 'Fichiers joints', 'template' => 'AppBundle:Admin:show_files.html.twig'))
            ->end()
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'Nom du projet'))
            ->add('space', null, array('label' => 'Espace'))
            ->add('status', 'choice', array(
                'label' => 'Statut',
                'choices' => Application::getStatusLabels(),
                'catalogue' => 'messages',
                'template' => 'AppBundle:Admin:list_status.html.twig'
            ))
            ->add('category', null, array('label' => 'Catégorie'))
            ->add('projectHolder', null, array('label' => 'Porteur de projet'))
            ->add('created', 'datetime', array('label' => 'Date de création', 'format' => 'd/m/Y H:i'))
            ->add('_action', 'actions', array(
                'label' => 'Actions',
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }
    
    /**
     * Configuration des actions batch
     */
    protected function configureBatchActions($actions)
    {
        // Conserver l'action de suppression par défaut
        if (isset($actions['delete'])) {
            $actions['delete'] = $actions['delete'];
        }
        
        return $actions;
    }
    
    /**
     * Configure les actions disponibles sur la liste
     */
    public function configureActionButtons($action, $object = null)
    {
        $list = parent::configureActionButtons($action, $object);
        
        if ($action === 'list') {
            $list['export_custom'] = array(
                'template' => 'AppBundle:Admin:button_export_custom.html.twig',
            );
        }
        
        return $list;
    }
    
    /**
     * Définit les actions disponibles dans la vue liste
     */
    public function getDashboardActions()
    {
        $actions = parent::getDashboardActions();
        
        // Ajouter le bouton d'export personnalisé
        $actions['custom_export'] = array(
            'label'              => 'Export personnalisé',
            'translation_domain' => 'SonataAdminBundle',
            'url'                => $this->generateUrl('select_export_fields'),
            'icon'               => 'download',
        );
        
        return $actions;
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
