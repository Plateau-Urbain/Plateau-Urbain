<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                // add your custom field
                ->add('email', null, array('label' => "Email", 'attr' => array('class' => 'form-control', 'placeholder' => 'Adresse email')))
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'first_options' => array('label' => 'form.password', 'attr' => array('class' => 'form-control', 'placeholder' => 'Mot de passe')),
                    'second_options' => array('label' => 'form.password_confirmation', 'attr' => array('class' => 'form-control', 'placeholder' => 'Confirmation')),
                    'label' => "Mot de passe"))
                ->add('useType', null, array('label' => "Type d'usage", 'required' => true, 'empty_value' => 'Sélectionner un type d\'usage *', 'attr' => array('class' => 'form-control')))
                ->add('wishedSize', null, array('label' => "Surface en m²", 'attr' => array('class' => 'form-control')))
        ;



        $builder->remove('username');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'intention'  => 'registration',
            'validation_groups' => array("register", 'Default')
        ));
    }

    public function getParent() {
        return 'fos_user_registration';
    }

    public function getName() {
        return 'project_holder_user_registration';
    }

}
