<?php
// vim:expandtab:sw=4 softtabstop=4:
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\Application;

class SpaceOwnerType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                // add your custom field
                ->add('civility', 'choice', array('choices' => User::getAllCivilities(), 'expanded' => true, 'label' => "Civilité", 'attr' => array('class' => 'pu-radios')))
                ->add('firstname', null, array('label' => "Prénom", 'attr' => array('class' => 'form-control')))
                ->add('lastname', null, array('label' => "Nom", 'attr' => array('class' => 'form-control')))
                ->add('email', null, array('label' => "Email", 'attr' => array('class' => 'form-control')))
                ->add('companyFunction', null, array('label' => "Fonction", 'attr' => array('class' => 'form-control', 'rows' => 5)))
                ->add('companyPhone', null, array('label' => "Téléphone fixe", 'attr' => array('class' => 'form-control')))
                ->add('companyMobile', null, array('label' => "Téléphone mobile", 'attr' => array('class' => 'form-control')))
                ->add('company', null, array('label' => "Nom de ma structure", 'attr' => array('class' => 'form-control')))
                ->add('companyStatus', 'choice', array('choices' => User::getAllProCompanyStatut(), 'label' => "Statut", 'attr' => array('class' => 'form-control')))
                ->add('address', null, array('label' => "Adresse de la structure", 'attr' => array('class' => 'form-control')))
                ->add('addressSuite', null, array('label' => "Adresse (suite)", 'attr' => array('class' => 'form-control')))
                ->add('zipcode', null, array('label' => "Code postal", 'attr' => array('class' => 'form-control')))
                ->add('city', null, array('label' => "Ville", 'attr' => array('class' => 'form-control')))
                ->add('companySite', null, array('label' => "Site web", 'attr' => array('class' => 'form-control')))
                ->add('oldPassword', 'password', array('mapped' => false, 'required' => false, 'label' => "Mot de passe actuel", 'attr' => array('class' => 'form-control')))
                ->add('password', 'repeated',
                    array('type' => PasswordType::class,
                          'required' => false,
                          'invalid_message' => 'Erreur dans la répétition du mot de passe.',
                          'first_options'  => array('label' => 'Nouveau mot de passe', 'attr' => array('class' => 'form-control')),
                          'second_options' => array('label' => 'Répéter nouveau mot de passe', 'attr' => array('class' => 'form-control'))))
        ;


        $builder->remove('username');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'validation_groups' => array('owner', 'Default')
        ));
    }

    public function getName() {
        return 'project_owner';
    }

}
