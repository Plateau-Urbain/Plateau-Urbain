<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use AppBundle\Entity\User;
use AppBundle\Entity\Application;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company', TextType::class, [
                'label' => 'Nom de ma structure',
                'attr' => ['class' => 'form-control']
            ])
            ->add('companyCreationDate', BirthdayType::class, [
                'label' => 'Date de création',
                'input' => 'datetime',
                'widget' => 'choice',
                'years' => range(date('Y') - 100, date('Y') + 5),
                'attr' => ['class' => 'oneline-date']
            ])
            ->add('companyStatus', ChoiceType::class, [
                'choices' => User::getAllProCompanyStatut(),
                'label' => "Statut",
                'attr' => ['class' => 'form-control']
            ])
            ->add('siret', null, ['label' => "SIRET", 'attr' => ['class' => 'form-control']])
            ->add('companyFunction', null, [
                'label' => "Fonction",
                'attr' => ['class' => 'form-control', 'rows' => 5]
            ])
            ->add('companyDescription', null, [
                'label' => "Présentation de la structure",
                'attr' => ['class' => 'form-control', 'rows' => 5]
            ])
            ->add('companyEffective', null, [
                'label' => "Nombre de personnes dans la structure",
                'attr' => ['class' => 'form-control', 'min' => 0]
            ])
            ->add('companyStructures', null, [
                'label' => "Structure(s) d'accompagnement",
                'attr' => ['class' => 'form-control']
            ])
            ->add('companyBlog', TextType::class, [
                'label' => "Blog",
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('companySite', UrlType::class, [
                'label' => "Site web", 'required' => false, 'attr' => ['class' => 'form-control']
            ])
            ->add('companyPhone', TextType::class, [
                'label' => "Téléphone fixe",
                'attr' => ['class' => 'form-control']
            ])
            ->add('companyMobile', TextType::class, [
                'label' => "Téléphone mobile",
                'attr' => ['class' => 'form-control']
            ])
            ->add('address', TextType::class, [
                'label' => "Adresse de la structure",
                'attr' => ['class' => 'form-control']
            ])
            ->add('addressSuite', TextType::class, [
                'label' => "Adresse (suite)",
                'attr' => ['class' => 'form-control']
            ])
            ->add('zipcode', TextType::class, [
                'label' => 'Code postal',
                'attr' => ['class' => 'form-control']
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'inherit_data' => true,
        ]);
    }
}
