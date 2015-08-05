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
            ->end()
            ->with('Profile')
            ->add('firstname', null, array('required' => false, 'label' => 'Prénom'))
            ->add('lastname', null, array('required' => false, 'label' => 'Nom'))
            ->add('biography', 'text', array('required' => false, 'label' => 'Fonction'))
            ->add('phone', null, array('required' => false, 'label' => 'Téléphone'))
            ->add('company', null, array('required' => false, 'label' => 'Structure'))
            ->add('address', null, array('required' => false, 'label' => 'Adresse Structure'))
            ->add('zipcode', null, array('required' => false, 'label' => 'Code Postal Structure'))
            ->add('city', null, array('required' => false, 'label' => 'Ville Structure'))

            ->add('enabled', null, array('label' => 'Activé', 'required' => false))
            ->add('locked', null, array('label' => 'Verouillé', 'required' => false))
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
}
