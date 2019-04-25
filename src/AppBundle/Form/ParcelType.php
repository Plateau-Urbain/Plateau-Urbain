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
            // date => Symfony\Component\Form\Extension\Core\Type\DateType
            ->add('disponibility',
                'Symfony\Component\Form\Extension\Core\Type\DateType',
                array(
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
        return 'appbundle_parcel';
    }
}
