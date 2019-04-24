<?php
// vim:expandtab:sw=4 softtabstop=4:

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParcelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('floor', null, array('label' => 'Étage', 'placeholder' => 'Étage' ,'attr' => array('class' => 'form-control')))
            ->add('type', null, array('label' => 'Type de locaux', 'placeholder' => 'Type de locaux', 'attr' => array('class' => 'form-control')))
            ->add('surface', null, array('label' => 'Surface', 'attr' => array('class' => 'form-control')))
            ->add('disponibility', 'date', array(
                'label' => 'Disponibilité',
                'widget' => 'single_text',
                //'format' => 'dd/MM/yyyy',
                'attr' => array(
                    'class' => 'form-control',
                    //'data-provide' => 'datepicker'
                )
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Parcel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_parcel';
    }
}
