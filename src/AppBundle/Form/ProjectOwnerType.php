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
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\User;
use AppBundle\Entity\Application;
use AppBundle\Entity\UserDocument;
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
                'label' => "J'accepte de recevoir la newsletter de Plateau Urbain",
                'attr' => [],
                'required' => false
            ])
            ->add('wishedSize', null, array('label' => "Surface", 'attr' => array('class' => 'form-control', 'min' => 0)))
            ->add('useType', null, array('label' => "Type d'usage", 'attr' => array('class' => 'form-control')))
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
            ->add('usageDuration', null, array('label' => "Durée d'occupation", 'attr' => array('class' => 'form-control', 'min' => 0)))
            ->add(
                'lengthTypeOccupation',
                'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
                array('choices' => array_flip(Application::getAllLengthType()),
                'choices_as_values' => true,
                'label' => "Durée d'occupation",
                'attr' => array('class' => 'form-control'))
            )
            ->add('projectDescription', null, array('label' => "Présentation de mon projet", 'attr' => array('class' => 'form-control', 'rows' => 5)))
            ->add('facebookUrl', null, array('label' => "Facebook", 'attr' => array('class' => 'form-control')))
            ->add('instagramUrl', null, array('label' => "Instagram", 'attr' => array('class' => 'form-control')))
            ->add('twitterUrl', null, array('label' => "Twitter", 'attr' => array('class' => 'form-control')))
            ->add('googleUrl', null, array('label' => "Google+", 'attr' => array('class' => 'form-control')))
            ->add('linkedinUrl', null, array('label' => "Linkedin", 'attr' => array('class' => 'form-control')))
            ->add('otherUrl', null, array('label' => "Viadeo", 'attr' => array('class' => 'form-control')));

            if (! $builder->getForm()->getData()->hasDocuments('kbis')) {
                $builder
                ->add('kbis', UserDocumentType::class, array(
                    'label' => 'Kbis',
                    'mapped' => false,
                    'error_bubbling' => false,
                ));
            }

            if (! $builder->getForm()->getData()->hasDocuments('idcard')) {
                $builder
                ->add('idcard', UserDocumentType::class, array(
                    'label' => 'Carte d\'identité',
                    'mapped' => false,
                    'error_bubbling' => false
                ))
                ;
            }


        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $projectHolder = $event->getData();

            // Handles kbis
            $kbis = null;
            if ($event->getForm()->has('kbis')) {
                $kbis = $event->getForm()->get('kbis')->getData();
            }
            if ($kbis instanceof UserDocument) {
                $kbis->setProjectHolder($projectHolder);
                $kbis->setType(UserDocument::KBIS_TYPE);

                if ($projectHolder->hasDocuments(UserDocument::KBIS_TYPE)) {
                    $currentKbis = $projectHolder->getDocumentsType(UserDocument::KBIS_TYPE)[0];
                    $currentKbis->setFile($kbis->getFile());
                    $currentKbis->setFileName($kbis->getFileName());
                } else {
                    if ($kbis->getFile()) {
                        $projectHolder->addDocument($kbis);
                    }
                }
            } else {
                if (!$projectHolder->hasDocuments(UserDocument::KBIS_TYPE) && $projectHolder->getCompanyStatus() != 'Association') {
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

                if ($projectHolder->hasDocuments(UserDocument::ID_TYPE)) {
                    $currentIdcard = $projectHolder->getDocumentsType(UserDocument::ID_TYPE)[0];
                    $currentIdcard->setFile($idcard->getFile());
                    $currentIdcard->setFileName($idcard->getFileName());
                } else {
                    if ($idcard->getFile()) {
                        $projectHolder->addDocument($idcard);
                    }
                }
            } else {
                if (!$projectHolder->hasDocuments(UserDocument::ID_TYPE) && $projectHolder->getCompanyStatus() == 'Association') {
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
            "allow_extra_fields" => true
        ));
    }

    public function getBlockPrefix()
    {
        return 'project_owner';
    }
}
