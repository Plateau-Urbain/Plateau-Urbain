<?php
// vim:expandtab:sw=4 softtabstop=4:

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;
use AppBundle\Entity\Application;
use AppBundle\Entity\UserDocument;
use AppBundle\Entity\UseType;
use AppBundle\Form\UserType;
use AppBundle\Form\CompanyType;

class ProjectOwnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userInfo', UserType::class, ['data_class' => ProjectOwnerType::class])
            ->add('companyInfo', CompanyType::class, ['mapped' => false, 'data_class' => ProjectOwnerType::class])
            ->add('newsletter', CheckboxType::class, [
                'label' => "J'accepte de recevoir les appels à candidatures",
                'attr' => [],
                'required' => false
            ])
            ->add('wishedSize', null, array('label' => "Surface souhaitée en m2", 'attr' => array('class' => 'form-control', 'min' => 0)))
            ->add(
                'usageDate',
                DateType::class,
                array(
                    'label' => 'Date de disponibilité',
                    'widget' => 'single_text',
                    //'format' => 'dd/MM/yyyy',
                    'years' => range(date('Y') - 5, date('Y') + 5),
                    'attr' => array(
                        'class' => 'form-control',
                        //'data-provide' => 'datepicker'
                    )
                )
            )
            ->add('preferredDepartments', ChoiceType::class, array(
                'label' => 'Zone(s) géographique(s) souhaitée(s)',
                'choices' => User::getAllFrenchDepartments(),
                'multiple' => true,
                'expanded' => false,
                'attr' => array(
                    'class' => 'js-preferred-departments',
                    'data-placeholder' => 'Selectionnez un ou plusieurs departements',
                    'size' => 8
                ),
                'required' => true
            ))
            ->add('usageDuration', null, array('label' => "Durée d'occupation", 'attr' => array('class' => 'form-control', 'min' => 0)))
            ->add('monthlyBudgetMax', null, array('label' => "Budget mensuel total maximum (€)", 'required' => true, 'attr' => array('class' => 'form-control', 'min' => 0, 'required' => 'required')))
            ->add(
                'lengthTypeOccupation',
                'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
                array('choices' => array_flip(Application::getAllLengthType()),
                'choices_as_values' => true,
                'label' => "Durée d'occupation",
                'attr' => array('class' => 'form-control'))
            )
            ->add('projectDescription', null, array('label' => "Présentation du projet", 'attr' => array('class' => 'form-control', 'rows' => 5)))
            ->add('facebookUrl', null, array('label' => "Facebook", 'attr' => array('class' => 'form-control')))
            ->add('instagramUrl', null, array('label' => "Instagram", 'attr' => array('class' => 'form-control')))
            ->add('twitterUrl', null, array('label' => "Twitter / X", 'attr' => array('class' => 'form-control')))
            ->add('googleUrl', null, array('label' => "Google+", 'attr' => array('class' => 'form-control')))
            ->add('linkedinUrl', null, array('label' => "LinkedIn", 'attr' => array('class' => 'form-control')))
            ->add('youtubeUrl', null, array('label' => "YouTube", 'attr' => array('class' => 'form-control')))
            ->add('tiktokUrl', null, array('label' => "TikTok", 'attr' => array('class' => 'form-control')))
            ->add('otherUrl', null, array('label' => "Autre URL", 'attr' => array('class' => 'form-control')));

            if (! $builder->getForm()->getData()->hasDocuments(UserDocument::KBIS_TYPE)) {
                $builder->add('kbis', UserDocumentType::class, [
                    'label' => 'Kbis',
                    'mapped' => false,
                    'error_bubbling' => false
                ]);
            }

            if (! $builder->getForm()->getData()->hasDocuments(UserDocument::ID_TYPE)) {
                $builder
                ->add('idcard', UserDocumentType::class, [
                    'label' => 'Carte d\'identité',
                    'mapped' => false,
                    'error_bubbling' => false
                ]);
            }


        // Ne proposer que les "Type de projet" actifs dans la liste, mais conserver
        // la valeur actuellement sélectionnée même si elle a été archivée (isActive = false)
        // afin de ne pas perdre la donnée sur un profil existant.
        $disableUseType = !empty($options['disable_use_type']);
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($disableUseType) {
            $form = $event->getForm();
            $user = $event->getData();
            $currentUseTypeId = null;
            if ($user instanceof User && $user->getUseType() instanceof UseType) {
                $currentUseTypeId = $user->getUseType()->getId();
            }

            $form->add('useType', EntityType::class, array(
                'class' => UseType::class,
                'label' => "Type de projet",
                'attr' => array('class' => 'form-control'),
                'placeholder' => 'Sélectionnez un type de projet',
                'required' => false,
                // Quand le champ est utilisé dans apply (section profil en récap), on le désactive
                // pour que la soumission ne vide pas la valeur en base (clearMissing par défaut).
                'disabled' => $disableUseType,
                'choice_label' => function ($useType) {
                    if (!$useType instanceof UseType) {
                        return '';
                    }
                    if (!$useType->getIsActive()) {
                        return $useType->getName() . ' (archivé — veuillez choisir un type actuel)';
                    }

                    return $useType->getName();
                },
                'query_builder' => function (EntityRepository $repo) use ($currentUseTypeId) {
                    $qb = $repo->createQueryBuilder('u')
                        ->where('u.isActive = :active')
                        ->setParameter('active', true);
                    if ($currentUseTypeId) {
                        $qb->orWhere('u.id = :current')
                           ->setParameter('current', $currentUseTypeId);
                    }
                    return $qb->orderBy('u.name', 'ASC');
                },
            ));
        });

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $user = $event->getData();
            if (!$user instanceof User) {
                return;
            }
            $form = $event->getForm();
            if (!$form->has('useType')) {
                return;
            }
            $useTypeField = $form->get('useType');
            if ($useTypeField->isDisabled()) {
                return;
            }
            $ut = $user->getUseType();
            if ($ut instanceof UseType && !$ut->getIsActive()) {
                $useTypeField->addError(new FormError(
                    'Ce type de projet n\'est plus proposé. Veuillez sélectionner une option actuelle dans la liste.'
                ));
            }
        });

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $projectHolder = $event->getData();
            $allowedSchemes = ['http', 'https'];

            // Validation des URLs Site web et Blog (dans le sous-formulaire companyInfo)
            if ($projectHolder instanceof User && $event->getForm()->has('companyInfo')) {
                foreach (['companySite' => 'getCompanySite', 'companyBlog' => 'getCompanyBlog'] as $field => $getter) {
                    $value = $projectHolder->$getter();
                    if ($value !== null && trim((string) $value) !== '') {
                        $value = trim($value);
                        $pos = strpos($value, ':');
                        $scheme = ($pos !== false) ? strtolower(substr($value, 0, $pos)) : '';
                        if (!in_array($scheme, $allowedSchemes, true)) {
                            $event->getForm()->get('companyInfo')->get($field)->addError(new FormError('Seuls les liens commençant par http:// ou https:// sont acceptés.'));
                        }
                    }
                }
            }

            // Validation des URLs sociales (champs directs du formulaire)
            if ($projectHolder instanceof User) {
                $socialFields = [
                    'facebookUrl'  => 'getFacebookUrl',
                    'twitterUrl'   => 'getTwitterUrl',
                    'instagramUrl' => 'getInstagramUrl',
                    'googleUrl'    => 'getGoogleUrl',
                    'linkedinUrl'  => 'getLinkedinUrl',
                    'youtubeUrl'   => 'getYoutubeUrl',
                    'tiktokUrl'    => 'getTiktokUrl',
                    'otherUrl'     => 'getOtherUrl',
                ];
                foreach ($socialFields as $field => $getter) {
                    if (!$event->getForm()->has($field)) {
                        continue;
                    }
                    $value = $projectHolder->$getter();
                    if ($value !== null && trim((string) $value) !== '') {
                        $value = trim($value);
                        $pos = strpos($value, ':');
                        $scheme = ($pos !== false) ? strtolower(substr($value, 0, $pos)) : '';
                        if (!in_array($scheme, $allowedSchemes, true)) {
                            $event->getForm()->get($field)->addError(new FormError('Seuls les liens commençant par http:// ou https:// sont acceptés.'));
                        }
                    }
                }
            }

            // Handles kbis
            $kbis = null;
            if ($event->getForm()->has('kbis')) {
                $kbis = $event->getForm()->get('kbis')->getData();
            }

            if ($kbis instanceof UserDocument) {
                $kbis->setProjectHolder($projectHolder);
                $kbis->setType(UserDocument::KBIS_TYPE);

                if (! $projectHolder->hasDocuments(UserDocument::KBIS_TYPE)) {
                    $projectHolder->addDocument($kbis);
                }
            } else {
                if (!$projectHolder->hasDocuments(UserDocument::KBIS_TYPE)) {
                    $event->getForm()->get('kbis')->addError(new FormError('Cette valeur ne doit pas être vide.'));
                }
            }

            // Handles ID card
            $idcard = null;
            if ($event->getForm()->has('idcard')) {
                $idcard = $event->getForm()->get('idcard')->getData();
            }

            if ($idcard instanceof UserDocument) {
                $idcard->setProjectHolder($projectHolder);
                $idcard->setType(UserDocument::ID_TYPE);

                if (! $projectHolder->hasDocuments(UserDocument::ID_TYPE)) {
                    $projectHolder->addDocument($idcard);
                }
            } else {
                if (!$projectHolder->hasDocuments(UserDocument::ID_TYPE)) {
                    $event->getForm()->get('idcard')->addError(new FormError('Cette valeur ne doit pas être vide.'));
                }
            }
        });

        $builder->get('companyInfo')->remove('companyFunction');
        $builder->remove('username');
        if ($options['noPlainPassword']) {
            $builder->get('userInfo')->remove('plainPassword');
            $builder->get('userInfo')->remove('oldPassword');
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'validation_groups' => array('projectHolder', 'Default'),
            'noPlainPassword' => false,
            // true = le champ useType est désactivé (utile côté apply pour ne pas écraser
            // le profil à la soumission quand la section profil est affichée en récap).
            'disable_use_type' => false,
            "allow_extra_fields" => true
        ));
    }

    public function getBlockPrefix()
    {
        return 'project_owner';
    }
}
