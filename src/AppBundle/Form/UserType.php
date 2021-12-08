<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use AppBundle\Entity\User;
use AppBundle\Entity\Application;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility', ChoiceType::class, [
                'choices' => array_flip(User::getAllCivilities()),
                'expanded' => true,
                'label' => "Civilité",
                'attr' => array('class' => 'pu-radios')
            ])
            ->add('firstname', TextType::class, array('label' => "Prénom", 'attr' => array('class' => 'form-control')))
            ->add('lastname', TextType::class, array('label' => "Nom", 'attr' => array('class' => 'form-control')))
            ->add('email', EmailType::class, array('label' => "Email", 'attr' => array('class' => 'form-control')))
            ->add('phone', TelType::class, array('label' => "Téléphone", 'attr' => array('class' => 'form-control')))
            ->add('birthday', BirthdayType::class, [
                'label' => 'Date de naissance', 'input' => 'datetime',
                'widget' => 'choice', 'attr' => ['class' => 'oneline-date']
            ])
            ->add('description', TextareaType::class, array('label' => "Une courte description de moi", 'attr' => array('class' => 'form-control', 'rows' => 5)))
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux champs doivent être identique',
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répéter le mot de passe'],
                'attr' => ['class' => 'form-control']
            ])        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'inherit_data' => true,
        ]);
    }
}
