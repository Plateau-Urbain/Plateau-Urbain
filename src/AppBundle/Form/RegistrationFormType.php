<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                // add your custom field
                ->add('email', null, array('label' => "Email", 'attr' => array('class' => 'form-control')))
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'first_options' => array('label' => 'form.password', 'attr' => array('class' => 'form-control')),
                    'second_options' => array('label' => 'form.password_confirmation', 'attr' => array('class' => 'form-control')),
                    'label' => "Mot de passe"))
                ->add('category', null, array('label' => "Type d'usage", 'required' => true, 'attr' => array('class' => 'form-control')))
                ->add('wishedSize', null, array('label' => "Surface en m²", 'attr' => array('class' => 'form-control')))
        ;



        $builder->remove('username');
    }

    public function getParent() {
        return 'fos_user_registration';
    }

    public function getName() {
        return 'project_holder_user_registration';
    }

}
