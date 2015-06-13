<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        // add your custom field
        ->add('lastname', null, array('label'=>"Nom", 'attr' => array('class' => ' col-lg-6 form-control') ))
        ->add('firstName', null, array('label'=>"Prénom" , 'attr' => array('class' => 'form-control')))
        ->add('email', null, array('label'=>"Email" , 'attr' => array('class' => 'form-control')))
        ->add('plainPassword', 'repeated', array(

            'type' => 'password',
            'first_options' => array('label' => 'form.password', 'attr' => array('class' => 'form-control')),
            'second_options' => array('label' => 'form.password_confirmation', 'attr' => array('class' => 'form-control')),
            'label'=>"Mot de passe" ))
        ->add('birthday','date', array(
                'input'  => 'datetime',
                'label'=>"Date de sortie souhaitée",
                'widget'=>'single_text',
                'attr' => array(
                    'class'=>'form-control input-box')
            )
        )

        ->add('company', null, array('label'=>"Nom de la structure" , 'attr' => array('class' => 'form-control')))
        ->add('siret', null, array('label'=>"N° Siret" , 'attr' => array('class' => 'form-control')))
        ->add('address', null, array('label'=>"Adresse de la structure" , 'attr' => array('class' => 'form-control')))
        ->add('zipcode', null, array('label'=>"Code postal de la structure" , 'attr' => array('class' => 'form-control')))
        ->add('city', null, array('label'=>"Ville de la structure" , 'attr' => array('class' => 'form-control')))

        ->add('phone', null, array('label'=>"Téléphone", 'attr' => array('class' => 'form-control')))
        ->add('facebookUrl', null, array('label'=>"Facebook", 'attr' => array('class' => 'form-control')))
        ->add('instagramUrl', null, array('label'=>"Instagram", 'attr' => array('class' => 'form-control')))
        ->add('twitterUrl', null, array('label'=>"Twitter", 'attr' => array('class' => 'form-control')))
        ->add('description', null, array('label'=>"Description du projet", 'attr' => array('class' => 'form-control')))
        ->add('wishedSize', null, array('label'=>"Taille du plateau souhaité", 'attr' => array('class' => 'form-control')))
        ->add('usageType', null, array('label'=>"Type d'usage du plateau prévu", 'attr' => array('class' => 'form-control')))
        ->add('usageDate', null, array('label'=>"Date prévisionnelle d'occupatation souhaitée", 'attr' => array('class' => 'form-control')))
        ->add('usageDuration', null, array('label'=>"Durée de location souhaitée", 'attr' => array('class' => 'form-control')))

        ->add('phone', null, array('label'=>"Téléphone", 'attr' => array('class' => 'form-control')))
        ;



        $builder->remove('username');
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

public function getName()
{
return 'project_holder_user_registration';
}
}