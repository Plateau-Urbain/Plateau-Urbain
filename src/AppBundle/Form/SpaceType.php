<?php
// vim:expandtab:sw=4 softtabstop=4:

namespace AppBundle\Form;

use AppBundle\Entity\Parcel;
use AppBundle\Entity\Space;
use AppBundle\Entity\SpaceAttribute;
use AppBundle\Entity\SpaceImage;
use AppBundle\Entity\SpaceDocument;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpaceType extends AbstractType
{
    /**
     * SpaceType constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'Nom de l\'espace' , 'attr' => array('class' => 'form-control')))
            ->add('zipCode', null, array('label' => 'Code postal' , 'attr' => array('class' => 'form-control')))
            ->add('city', null, array('label' => 'Ville' , 'attr' => array('class' => 'form-control')))
            ->add('limitAvailability', DateType::class, [
                    'label' => 'Date limite de candidature',
                    'widget' => 'single_text',
                    'attr' => array(
                        'class' => 'form-control',
                    )
                ]
            )
            ->add('type', null, array('label' => 'Type de locaux', 'attr' => array('class' => 'form-control')))
            ->add('price', null, array('label' => 'Prix au m² mensuel', 'attr' => array('class' => 'form-control')))
            ->add('availability', null, array('label' => 'Période de disponibilité', 'attr' => array('class' => 'form-control')))
            ->add('description', null, array('label' => 'Description', 'attr' => array('class' => 'form-control', 'rows' => 5)))
            ->add('activityDescription', null, array('label' => 'Activités recherchées', 'attr' => array('class' => 'form-control', 'rows' => 5)))
            ->add('tags', CollectionType::class, [
                //'type' => new SpaceAttributeType(),
                'entry_type' => SpaceAttributeType::class,
                'label' => false,
                'allow_add' => false,
                'allow_delete' => false,
                'by_reference' => false
            ])
            ->add('pics', SpaceImageType::class,
                array(
                'label' => 'Ajouter une photo',
                'mapped' => false,
                'required' => false
            )
            )
            ->add(
                'newParcel',
                ParcelType::class,
                array(
                'label'     => 'Ajouter un lot',
                'mapped' => false,
                'required' => false
            )
            )
            ->add(
                'newDocument',
                SpaceDocumentType::class,
                array(
                'label'     => 'Ajouter un document',
                'mapped' => false,
                'required' => false
            )
            )
        ;

        $attributes = $this->getAttributes();
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($attributes) {
            /**
             * @var Space $data
             */
            $data = $event->getData();

            $currentAttributes = $data->getTags()->map(function ($spaceAttribute) {
                return $spaceAttribute->getAttribute();
            });

            foreach ($attributes as $attribute) {
                if (!$currentAttributes->contains($attribute)) {
                    $spaceAttribute = new SpaceAttribute();
                    $spaceAttribute->setAttribute($attribute);
                    $data->addTag($spaceAttribute);
                }
            }
        });

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            // Handles new parcel
            $newParcel = $event->getForm()->get('newParcel')->getData();
            if ($newParcel instanceof Parcel) {
                $event->getData()->addParcel($newParcel);
            }

            // Handles new image
            $newImage = $event->getForm()->get('pics')->getData();
            if ($newImage instanceof SpaceImage) {
                $event->getData()->addPic($newImage);
            }

            // Handles new document
            $newDocument = $event->getForm()->get('newDocument')->getData();
            if ($newDocument instanceof SpaceDocument) {
                $newDocument->setSpace($event->getData());
                $event->getData()->addDocument($newDocument);
            }
        });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // The "cascade_validation" option is deprecated since Symfony 2.8 and
        // will be removed in 3.0. Use "constraints" with a Valid constraint
        // instead.
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Space',
            //'cascade_validation' => true,
            'constraints' => new \Symfony\Component\Validator\Constraints\Valid(),
            'validation_groups' => function (FormInterface $form) {
                if ($form->get('publish')->isClicked()) {
                    return 'save';
                }

                return 'draft';
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
        return 'appbundle_space';
    }

    /**
     * @return \AppBundle\Entity\Attribute[]|array
     */
    protected function getAttributes()
    {
        return $this->em->getRepository('AppBundle:Attribute')->findAll();
    }
}
