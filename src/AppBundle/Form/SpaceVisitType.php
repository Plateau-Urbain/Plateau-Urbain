<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpaceVisitType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visitDate', DateType::class, array(
                'label' => 'Date de visite',
                'widget' => 'single_text',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Date de visite'
                ),
                'required' => true
            ))
            ->add('startTime', TimeType::class, array(
                'label' => 'Heure de début',
                'widget' => 'single_text',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Heure de début'
                ),
                'required' => true
            ))
            ->add('endTime', TimeType::class, array(
                'label' => 'Heure de fin',
                'widget' => 'single_text',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Heure de fin'
                ),
                'required' => true
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\SpaceVisit'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_spacevisit';
    }
}
