<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\Application;

class ProjectOwnerType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                // add your custom field
                ->add('civility', 'choice', array('choices' => User::getAllCivilities(), 'expanded' => true, 'label' => "Civilité", 'attr' => array('class' => 'pu-radios')))
                ->add('firstname', null, array('label' => "Prénom", 'attr' => array('class' => 'form-control')))
                ->add('lastname', null, array('label' => "Nom", 'attr' => array('class' => 'form-control')))
                ->add('birthday', 'birthday', array('label' => "Date de naissance", 'attr' => array('class' => 'inline-date')))
                ->add('phone', null, array('label' => "Téléphone", 'attr' => array('class' => 'form-control')))
                ->add('email', null, array('label' => "Email", 'attr' => array('class' => 'form-control')))
                ->add('password', 'password', array('required' => false, 'label' => "Mot de passe", 'attr' => array('class' => 'form-control')))
                ->add('description', null, array('label' => "Description", 'attr' => array('class' => 'form-control', 'rows' => 5)))
                ->add('newsletter', null, array('label' => "J'accepte de recevoir la newsletter de Plateau Urbain", 'attr' => array()))
                ->add('company', null, array('label' => "Nom de ma structure", 'attr' => array('class' => 'form-control')))
                ->add('companyStatus', 'choice', array('choices' => User::getAllCompanyStatut(), 'label' => "Statut", 'attr' => array('class' => 'form-control')))
                ->add('companyCreationDate', 'birthday', array('label' => "Date de création", 'attr' => array('class' => 'inline-date')))
                ->add('siret', null, array('label' => "SIRET", 'attr' => array('class' => 'form-control')))
                ->add('address', null, array('label' => "Adresse de la structure", 'attr' => array('class' => 'form-control')))
                ->add('addressSuite', null, array('label' => "Adresse (suite)", 'attr' => array('class' => 'form-control')))
                ->add('zipcode', null, array('label' => "Code postal", 'attr' => array('class' => 'form-control')))
                ->add('city', null, array('label' => "Ville", 'attr' => array('class' => 'form-control')))
                ->add('companyPhone', null, array('label' => "Téléphone fixe", 'attr' => array('class' => 'form-control')))
                ->add('companyMobile', null, array('label' => "Téléphone mobile", 'attr' => array('class' => 'form-control')))
                ->add('companyDescription', null, array('label' => "Présentation de l'entreprise", 'attr' => array('class' => 'form-control', 'rows' => 5)))
                ->add('companyEffective', null, array('label' => "Nombre de personnes dans la structure", 'attr' => array('class' => 'form-control')))
                ->add('companyStructures', null, array('label' => "Structure(s) d'accompagnement", 'attr' => array('class' => 'form-control')))
                ->add('companySite', null, array('label' => "Site web", 'attr' => array('class' => 'form-control')))
                ->add('companyBlog', null, array('label' => "Blog", 'attr' => array('class' => 'form-control')))
                ->add('wishedSize', null, array('label' => "Surface", 'attr' => array('class' => 'form-control')))
                ->add('category', null, array('label' => "Type d'usage", 'attr' => array('class' => 'form-control')))
                ->add('usageDate', null, array('label' => "Date de disponibilité", 'attr' => array('class' => 'inline-date')))
                ->add('usageDuration', null, array('label' => "Durée d'occupation", 'attr' => array('class' => 'form-control small-input')))
                ->add('lengthTypeOccupation', 'choice', array('choices' => Application::getAllLengthType(),  'label' => "Durée d'occupation", 'attr' => array('class' => 'form-control')))
                ->add('usageDescription', null, array('label' => "Présentation de mon projet", 'attr' => array('class' => 'form-control', 'rows' => 5)))
                ->add('facebookUrl', null, array('label' => "Facebook", 'attr' => array('class' => 'form-control')))
                ->add('instagramUrl', null, array('label' => "Instagram", 'attr' => array('class' => 'form-control')))
                ->add('twitterUrl', null, array('label' => "Twitter", 'attr' => array('class' => 'form-control')))
                ->add('googleUrl', null, array('label' => "Google+", 'attr' => array('class' => 'form-control')))
                ->add('linkedinUrl', null, array('label' => "Linkedin", 'attr' => array('class' => 'form-control')))
                ->add('otherUrl', null, array('label' => "Autre", 'attr' => array('class' => 'form-control')))
        ;



        $builder->remove('username');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
        ));
    }

    public function getName() {
        return 'project_owner';
    }

}
