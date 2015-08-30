<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SpaceAttributeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('attribute', null, array('label' => 'Prestation' , 'attr' => array('class' => 'form-control')))
            ->add('availability', 'choice', array('label' => 'Disponibilité' , 
                'choices' => array(0 => 'A prevoir', 1 => 'Inclus'), 
                'expanded' => true,
                'multiple' => false,
                'attr' => array('class' => '')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\SpaceAttribute'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_space_attribute';
    }
}
