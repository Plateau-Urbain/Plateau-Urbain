<?php
// vim:expandtab:sw=4 softtabstop=4:

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visitDate', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                'label' => 'Date de visite',
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control')
            ))
            ->add('startTime', 'Symfony\Component\Form\Extension\Core\Type\TimeType', array(
                'label' => 'Heure de début',
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control')
            ))
            ->add('endTime', 'Symfony\Component\Form\Extension\Core\Type\TimeType', array(
                'label' => 'Heure de fin',
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control')
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
        return 'appbundle_visit';
    }
}


