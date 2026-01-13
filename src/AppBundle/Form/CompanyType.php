<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
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
            ->add('siret', TextType::class, [
                'label' => "SIRET", 
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: 123 456 789 01234',
                    'maxlength' => '18'
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(\d{3}\s?){4}\d{2}$/',
                        'message' => 'Le SIRET doit contenir exactement 14 chiffres. Format accepté : 123 456 789 01234'
                    ])
                ]
            ])
            ->add('companyFunction', null, [
                'label' => "Fonction",
                'attr' => ['class' => 'form-control', 'rows' => 5]
            ])
            ->add('companyDescription', TextareaType::class, [
                'label' => "Présentation de la structure",
                'attr' => ['class' => 'form-control', 'rows' => 5]
            ])
            ->add('companyEffective', NumberType::class, [
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
            ->add('companyPhone', TelType::class, [
                'label' => "Téléphone fixe",
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: 01 23 45 67 89 ou +33 1 23 45 67 89'
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(\+33\s?[1-9](\s?\d{2}){4}|0[1-9](\s?\d{2}){4})$/',
                        'message' => 'Le format du téléphone n\'est pas valide. Utilisez le format français (01 23 45 67 89) ou international (+33 1 23 45 67 89).'
                    ])
                ]
            ])
            ->add('companyMobile', TelType::class, [
                'label' => "Téléphone mobile",
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: 06 12 34 56 78 ou +33 6 12 34 56 78',
                    'required' => 'required'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le téléphone mobile est obligatoire.',
                        'groups' => ['projectHolder', 'Default']
                    ]),
                    new Regex([
                        'pattern' => '/^(\+33\s?[1-9](\s?\d{2}){4}|0[1-9](\s?\d{2}){4})$/',
                        'message' => 'Le format du téléphone n\'est pas valide. Utilisez le format français (06 12 34 56 78) ou international (+33 6 12 34 56 78).',
                        'groups' => ['projectHolder', 'Default']
                    ])
                ]
            ])
            ->add('address', TextType::class, [
                'label' => "Adresse de la structure",
                'attr' => ['class' => 'form-control']
            ])
           /* ->add('addressSuite', TextType::class, [
                'label' => "Adresse (suite)",
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])*/
            ->add('zipcode', TextType::class, [
                'label' => 'Code postal',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: 75001',
                    'maxlength' => '5',
                    'pattern' => '[0-9]{5}',
                    'required' => 'required'
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{5}$/',
                        'message' => 'Le code postal doit contenir exactement 5 chiffres.'
                    ])
                ]
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
