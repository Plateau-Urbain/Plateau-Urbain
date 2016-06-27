<?php

namespace AppBundle\Form;

use AppBundle\Entity\UserDocument;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\Application;

class ProjectOwnerType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $user = $options['data'];

        $builder
                // add your custom field
                ->add('civility', 'choice', array('choices' => User::getAllCivilities(), 'expanded' => true, 'label' => "Civilité", 'attr' => array('class' => 'pu-radios')))
                ->add('firstname', null, array('label' => "Prénom", 'attr' => array('class' => 'form-control')))
                ->add('lastname', null, array('label' => "Nom", 'attr' => array('class' => 'form-control')))
                ->add('birthday', 'birthday',
                    array(
                      'label' => "Date de naissance",
                      'input'  => 'datetime',
                      'widget' => 'choice',
                      'attr' => array(
                          'class' => 'oneline-date'
                      )
                    ))
                ->add('phone', null, array('label' => "Téléphone", 'attr' => array('class' => 'form-control')))
                ->add('email', null, array('label' => "Email", 'attr' => array('class' => 'form-control')))
                ->add('password', 'password', array('required' => false, 'label' => "Mot de passe", 'attr' => array('class' => 'form-control')))
                ->add('description', null, array('label' => "Une courte description de moi", 'attr' => array('class' => 'form-control', 'rows' => 5)))
                ->add('newsletter', null, array('label' => "J'accepte de recevoir la newsletter de Plateau Urbain", 'attr' => array()))
                ->add('company', null, array('label' => "Nom de ma structure", 'attr' => array('class' => 'form-control')))
                ->add('companyStatus', 'choice', array('choices' => User::getAllCompanyStatut(), 'label' => "Statut", 'attr' => array('class' => 'form-control')))
                ->add('companyCreationDate', 'birthday',
                    array(
                      'label' => "Date de création",
                      'input'  => 'datetime',
                      'widget' => 'choice',
                      'years' => range(date('Y') - 100, date('Y') + 5),
                      'attr' => array(
                          'class' => 'oneline-date'
                      )
                    ))
                ->add('siret', null, array('label' => "SIRET", 'attr' => array('class' => 'form-control')))
                ->add('address', null, array('label' => "Adresse de la structure", 'attr' => array('class' => 'form-control')))
                ->add('addressSuite', null, array('label' => "Adresse (suite)", 'attr' => array('class' => 'form-control')))
                ->add('zipcode', null, array('label' => "Code postal", 'attr' => array('class' => 'form-control')))
                ->add('city', null, array('label' => "Ville", 'attr' => array('class' => 'form-control')))
                ->add('companyPhone', null, array('label' => "Téléphone fixe", 'attr' => array('class' => 'form-control')))
                ->add('companyMobile', null, array('label' => "Téléphone mobile", 'attr' => array('class' => 'form-control')))
                ->add('companyDescription', null, array('label' => "Présentation de la structure", 'attr' => array('class' => 'form-control', 'rows' => 5)))
                ->add('companyEffective', null, array('label' => "Nombre de personnes dans la structure", 'attr' => array('class' => 'form-control', 'min' => 0)))
                ->add('companyStructures', null, array('label' => "Structure(s) d'accompagnement", 'attr' => array('class' => 'form-control')))
                ->add('companySite', null, array('label' => "Site web", 'attr' => array('class' => 'form-control')))
                ->add('companyBlog', null, array('label' => "Blog", 'attr' => array('class' => 'form-control')))
                ->add('wishedSize', null, array('label' => "Surface", 'attr' => array('class' => 'form-control', 'min' => 0)))
                ->add('useType', null, array('label' => "Type d'usage", 'attr' => array('class' => 'form-control')))
                ->add('usageDate', null,
                    array(
                        'label' => 'Date de disponibilité',
                        'widget' => 'single_text',
                        'format' => 'dd/MM/yyyy',
                        'years' => range(date('Y') - 5, date('Y') + 5),
                        'attr' => array(
                            'class' => 'form-control',
                            'data-provide' => 'datepicker'
                        )
                    ))
                ->add('usageDuration', null, array('label' => "Durée d'occupation", 'attr' => array('class' => 'form-control', 'min' => 0)))
                ->add('lengthTypeOccupation', 'choice', array('choices' => Application::getAllLengthType(),  'label' => "Durée d'occupation", 'attr' => array('class' => 'form-control')))
                ->add('projectDescription', null, array('label' => "Présentation de mon projet", 'attr' => array('class' => 'form-control', 'rows' => 5)))
                ->add('facebookUrl', null, array('label' => "Facebook", 'attr' => array('class' => 'form-control')))
                ->add('instagramUrl', null, array('label' => "Instagram", 'attr' => array('class' => 'form-control')))
                ->add('twitterUrl', null, array('label' => "Twitter", 'attr' => array('class' => 'form-control')))
                ->add('googleUrl', null, array('label' => "Google+", 'attr' => array('class' => 'form-control')))
                ->add('linkedinUrl', null, array('label' => "Linkedin", 'attr' => array('class' => 'form-control')))
                ->add('otherUrl', null, array('label' => "Viadeo", 'attr' => array('class' => 'form-control')))

                ->add('kbis', new UserDocumentType(), array(
                    'label' => 'Kbis',
                    'mapped' => false,
                    'error_bubbling' => false,
                ))

                ->add('idcard', new UserDocumentType(), array(
                    'label' => 'Carte d\'identité',
                    'mapped' => false,
                    'error_bubbling' => false
                ))

                ->add('newDocument', new UserDocumentType(), array(
                    'label' => false,
                    'mapped' => false,
                    'required' => false
                ))
        ;

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $projectHolder = $event->getData();

            // Handles kbis
            $kbis = $event->getForm()->get('kbis')->getData();
            if ($kbis instanceof UserDocument) {
                $kbis->setProjectHolder($projectHolder);
                $kbis->setType(UserDocument::KBIS_TYPE);

                if ($projectHolder->hasDocuments(UserDocument::KBIS_TYPE)) {
                  $currentKbis = $projectHolder->getDocumentsType(UserDocument::KBIS_TYPE)[0];
                  $currentKbis->setFile($kbis->getFile());
                  $currentKbis->setFileName($kbis->getFileName());
                } else {
                  if($kbis->getFile()){
                    $projectHolder->addDocument($kbis);
                  }
                }
            } else {
              if (!$projectHolder->hasDocuments(UserDocument::KBIS_TYPE) && $projectHolder->getCompanyStatus() != 'Association') {
                $event->getForm()->get('kbis')->addError(new FormError('Cette valeur ne doit pas être vide.'));
              }
            }

            // Handles ID card
            $idcard = $event->getForm()->get('idcard')->getData();
            if ($idcard instanceof UserDocument) {
                $idcard->setProjectHolder($projectHolder);
                $idcard->setType(UserDocument::ID_TYPE);

                if ($projectHolder->hasDocuments(UserDocument::ID_TYPE)) {
                  $currentIdcard = $projectHolder->getDocumentsType(UserDocument::ID_TYPE)[0];
                  $currentIdcard->setFile($idcard->getFile());
                  $currentIdcard->setFileName($idcard->getFileName());
                } else {
                  if($idcard->getFile()){
                    $projectHolder->addDocument($idcard);
                  }
                }
            } else {
              if (!$projectHolder->hasDocuments(UserDocument::ID_TYPE) && $projectHolder->getCompanyStatus() == 'Association') {
                $event->getForm()->get('idcard')->addError(new FormError('Cette valeur ne doit pas être vide.'));
              }
            }

            // Handles others
            $doc = $event->getForm()->get('newDocument')->getData();
            if ($doc instanceof UserDocument) {
                $doc->setProjectHolder($projectHolder);
                $doc->setType(UserDocument::NO_TYPE);
                $projectHolder->addDocument($doc);
            }
        });

        $builder->remove('username');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'validation_groups' => array('projectHolder', 'Default')
        ));
    }

    public function getName() {
        return 'project_owner';
    }

}
