<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ParcelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('floor', null, array('label' => 'Etage' , 'attr' => array('class' => 'form-control')))
            ->add('type', null, array('label' => 'Type de locaux' , 'attr' => array('class' => 'form-control')))
            ->add('surface', null, array('label' => 'Surface' , 'attr' => array('class' => 'form-control')))
            ->add('disponibility', null, array('label' => 'Disponibilité' , 'attr' => array('class' => 'inline-date')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
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
