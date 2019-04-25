<?php
// vim:expandtab:sw=4 softtabstop=4:

namespace AppBundle\Form;
use AppBundle\Entity\Application;
use AppBundle\Entity\ApplicationFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ApplicationType
 *
 * @package AppBundle\Form
 */
class ApplicationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $application = $builder->getData();

        $builder
            ->add('name', null, array('label'=>"Nom de mon projet", 'attr' => array('class'=>'form-control input-box')) )
            ->add('description', null, array(
                'label'=>"Description du projet",
                'attr' => array(
                    'class'=>'textarea-box',
                    'rows'=> 6
                )
            ))
            ->add('contribution', null, array(
                'required' => false,
                'label'=>"Quelle serait votre contribution au projet global du propriétaire ?",
                'attr' => array('class' => 'textarea-box', 'rows'=> 6),
                //'help' => 'En cochant cette case vous acceptez d’intégrer une association de gestion des locaux avec d’autres porteurs de projet'
            ))
            ->add('startOccupation', 'date', array(
                    'label'=>"Date d'entrée souhaitée",
                    'input'  => 'datetime', // 'datetime' is the default !
                    'widget'=>'single_text',
                    //'format' => 'd/M/y',
                    'attr' => array(
                        //'data-provide' => 'datepicker'
                    )
                )
            )
            ->add('lengthOccupation', null, array(
                    'label'=>"Durée d'occupation",
                    'attr' => array()
                )
            )
            ->add('openToGlobalProject', null, array('label' => "Je suis ouvert(e) à faire partie d'un projet collectif " ))
            ->add(
                'lengthTypeOccupation',
                'choice',
                array(
                    'choices' => Application::getAllLengthType(),
                    'label' => "Durée d'occupation"
                )
            )
            ->add('category', null, array('label'=>"Type de projet",'required'=> true, 'attr'=> array('placeholder'=>"Categorie du projet", 'class'=>'form-control input-box')))
            ->add('wishedSize', null, array(
                'label'=>"Surface souhaitée en m²",
                'attr' => array('class' => 'input-box'),
                'block_name' => 'size_calculator'
            ))

            ->add('newDocument', new ApplicationFileType(), array(
                'label' => false,
                'mapped' => false,
                'required' => false
            ))
        ;


        foreach ($application->getSpace()->getDocuments() as $field) {
          $builder->add('document_' . $field->getId(),
            new ApplicationFileType(),
            array(
              'label' => false,
              'mapped' => false,
              'required' => ($application->hasFileType($field->getId()) ? false : true)
            )
          );
        }

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $application = $event->getData();

            $document = $event->getForm()->get('newDocument')->getData();
            if ($document instanceof ApplicationFile) {
                $document->setApplication($application);
                $application->addFile($document);
            }


            foreach ($application->getSpace()->getDocuments() as $field) {
              $document = $event->getForm()->get('document_' . $field->getId())->getData();

                if (($document instanceof ApplicationFile) == false && !$application->hasFileType($field->getId()) || ($document instanceof ApplicationFile && $document->getFile() == null && $event->getForm()->get('submit')->isClicked())) {
                    $event->getForm()->get('document_' . $field->getId())->addError(new FormError('Le document ' . $field->getName() . ' est obligatoire'));
                } else {
                    if ($document instanceof ApplicationFile) {
                        $document->setApplication($application);
                        $document->setSpaceDocument($field);

                        if ($application->hasFileType($field->getId())) {
                            $currentDocument = $application->getFilesType($field->getId())[0];
                            $currentDocument->setFile($document->getFile());
                            $currentDocument->setFileName($document->getFileName());
                        } else {
                            if ($document->getFile()) {
                                $application->addFile($document);
                            }
                        }
                   }
                }
            }
        });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Application',
            'validation_groups' => function(FormInterface $form) {

                if ($form->get('save')->isClicked()) {
                  return "default";
                }

                return "submit";
            }
        ));
    }

    // The FormTypeInterface::getName()
    // method is deprecated since Symfony 2.8 and will be removed in 3.0.
    // Remove it from your classes. Use getBlockPrefix() if you want
    // to customize the template block prefix.
    // This method will be added to the FormTypeInterface with Symfony 3.0
    /**
     * @return string
     */
    //public function getName()
    public function getBlockPrefix()
    {
        return 'appbundle_application';
    }
}
