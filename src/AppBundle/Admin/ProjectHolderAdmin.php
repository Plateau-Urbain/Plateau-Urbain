<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Application;
use AppBundle\Entity\UserDocument;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\User;

class ProjectHolderAdmin extends Admin
{
    protected $baseRouteName = 'project-holder';
    protected $baseRoutePattern = 'project-holder';

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere(
            $query->expr()->eq($query->getRootAliases()[0].'.typeUser', ':typeUser')
        );
        $query->setParameter('typeUser', User::PORTEUR);

        return $query;
    }

    // setup the default sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'lastname',
    );

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('email')
            ->add('plainPassword', 'text', array(
                'required' => (!$this->getSubject() || is_null($this->getSubject()->getId())),
                'label'     => 'Mot de passe',
            ))
            ->add('enabled', null, array('label' => 'Activé'))
            ->end()
            ->with('Profile')
            ->add('civility', 'choice', array('choices' => User::getAllCivilities(), 'required' => false, 'label' => 'Civilité'))
            ->add('firstname', null, array('required' => false, 'label' => 'Prénom'))
            ->add('lastname', null, array('required' => false, 'label' => 'Nom'))
            ->add('birthday', 'birthday', array('required' => false, 'label' => 'Date de naissance'))
            ->add('phone', null, array('required' => false, 'label' => 'Téléphone'))
            ->add('description', null, array('required' => false, 'label' => 'Description'))
            ->add('newsletter', null, array('required' => false, 'label' => 'Souhaite recevoir la newsletter'))

            ->end()
            ->with('Structure')
            ->add('company', null, array('required' => false, 'label' => 'Structure'))
            ->add('companyStatus', 'choice', array('choices' => User::getAllCompanyStatut(), 'required' => false, 'label' => 'Statut'))
            ->add('companyCreationDate', 'birthday', array('required' => false, 'label' => 'Date de création'))
            ->add('siret', null, array('required' => false, 'label' => 'SIRET'))
            ->add('address', null, array('required' => false, 'label' => 'Adresse Structure'))
            ->add('addressSuite', null, array('required' => false, 'label' => 'Adresse Structure (suite)'))
            ->add('zipcode', null, array('required' => false, 'label' => 'Code Postal Structure'))
            ->add('city', null, array('required' => false, 'label' => 'Ville Structure'))
            ->add('companyPhone', null, array('required' => false, 'label' => 'Téléphone fixe'))
            ->add('companyMobile', null, array('required' => false, 'label' => 'Téléphone mobile'))
            ->add('companyDescription', null, array('required' => false, 'label' => 'Description'))
            ->add('companyEffective', null, array('required' => false, 'label' => 'Nombre de personnes dans la structure'))
            ->add('companyStructures', null, array('required' => false, 'label' => 'Structure(s) d\'accompagnement'))
            ->add('company_site', null, array('required' => false, 'label' => 'Site web'))
            ->add('company_blog', null, array('required' => false, 'label' => 'Blog'))

            ->end()
            ->with('Souhaits')
            ->add('wishedSize', null, array('required' => false, 'label' => 'Taille souhaitée (m²)'))
            ->add('useType', null, array('required' => false, 'label' => 'Type d\'usage'))
            ->add('usageDate', null, array('required' => false, 'label' => 'Date de disponibilité'))
            ->add('usageDuration', null, array('required' => false, 'label' => 'Durée d\'occupation'))
            ->add('lengthTypeOccupation', 'choice', array('choices' => Application::getAllLengthType(), 'required' => false, 'label' => 'Type de durée'))
            ->add('projectDescription', null, array('required' => false, 'label' => 'Présentation du projet'))

            ->end()
            ->with('Réseaux sociaux')
            ->add('facebookUrl', null, array('required' => false, 'label' => 'Facebook'))
            ->add('googleUrl', null, array('required' => false, 'label' => 'Google+'))
            ->add('twitterUrl', null, array('required' => false, 'label' => 'Twitter'))
            ->add('linkedinUrl', null, array('required' => false, 'label' => 'Linkedin'))
            ->add('instagramUrl', null, array('required' => false, 'label' => 'Instagram'))
            ->add('otherUrl', null, array('required' => false, 'label' => 'Viadeo'))

            ->end()

            ->with('Documents')
            ->add('documents', 'sonata_type_collection',
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
            ->add('email')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('email')
            ->add('firstname', null, array('label' => 'Prénom'))
            ->add('lastName', null, array('label' => 'Nom'))
            ->add('enabled', null, array('label' => 'Activé'))
            ->add('locked', null, array('label' => 'Verouillé'))
        ;
    }

    public function getNewInstance()
    {
        $instance = parent::getNewInstance();
        $instance->setTypeUser(User::PORTEUR);

        return $instance;
    }

    public function syncDocs($user, $children)
    {
        foreach ($children as $child) {
            $child->setProjectHolder($user);
        }
    }

    public function preUpdate($user)
    {
        $this->getUserManager()->updateCanonicalFields($user);
        $this->getUserManager()->updatePassword($user);

        $this->syncDocs($user, $user->getDocuments());
    }

    public function setUserManager(\FOS\UserBundle\Model\UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function getUserManager()
    {
        return $this->userManager;
    }

    public function getDataSourceIterator()
    {
        $datagrid = $this->getDatagrid();
        $datagrid->buildPager();

        $datasourceit = $this->getModelManager()->getDataSourceIterator($datagrid, $this->getExportFields());
        $datasourceit->setDateTimeFormat('d/m/Y H:i');

        return $datasourceit;
    }

    public function getFormTheme()
    {
        return array_merge(
            array('AppBundle:Form:custom_admin_fields.html.twig'),
            parent::getFormTheme()
        );
    }
}
