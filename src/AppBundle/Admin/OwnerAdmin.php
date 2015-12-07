<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use AppBundle\Entity\User;

class OwnerAdmin extends Admin
{
    protected $baseRouteName = 'owner';
    protected $baseRoutePattern = 'owner';

    private   $userManager;
    
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere(
            $query->expr()->eq($query->getRootAliases()[0].'.typeUser', ':typeUser')
        );
        $query->setParameter('typeUser', User::PROPRIO);

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
            ->add('enabled', null, array('label' => 'Activé', 'required' => false))

            ->end()
            ->with('Profile')

            ->add('civility', 'choice', array('choices' => User::getAllCivilities(), 'required' => false, 'label' => 'Civilité'))
            ->add('firstname', null, array('required' => false, 'label' => 'Prénom'))
            ->add('lastname', null, array('required' => false, 'label' => 'Nom'))
            ->add('companyFunction', null, array('required' => false, 'label' => 'Fonction'))
            ->add('companyPhone', null, array('required' => false, 'label' => 'Téléphone'))
            ->add('companyMobile', null, array('required' => false, 'label' => 'Téléphone mobile'))

            ->end()
            ->with('Structure')

            ->add('company', null, array('required' => false, 'label' => 'Structure'))
            ->add('companyStatus', 'choice', array('choices' => User::getAllCompanyStatut(), 'required' => false, 'label' => 'Statut'))
            ->add('address', null, array('required' => false, 'label' => 'Adresse'))
            ->add('addressSuite', null, array('required' => false, 'label' => 'Adresse (suite)'))
            ->add('zipcode', null, array('required' => false, 'label' => 'Code Postal'))
            ->add('city', null, array('required' => false, 'label' => 'Ville Structure'))
            ->add('company_site', null, array('required' => false, 'label' => 'Site Web'))

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
        $instance->setTypeUser(User::PROPRIO);

        return $instance;
    }
    
    public function preUpdate($user)
    {
        $this->getUserManager()->updateCanonicalFields($user);
        $this->getUserManager()->updatePassword($user);
    }

    public function prePersist($user) {
        $user->addRole('ROLE_OWNER');
    }
    
    public function setUserManager(\FOS\UserBundle\Model\UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function getUserManager()
    {
        return $this->userManager;
    }
}
