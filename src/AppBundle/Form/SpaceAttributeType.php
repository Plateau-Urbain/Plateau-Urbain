<?php

namespace AppBundle\Form;

use AppBundle\Entity\SpaceAttribute;
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
            ->add('availability', 'choice', array(
                    'label' => 'Disponibilité' ,
                    'choices' => array(
                        SpaceAttribute::STATUS_INCLUDED => 'Inclus',
                        SpaceAttribute::STATUS_EXPECTED => 'A prevoir',
                        SpaceAttribute::STATUS_NO => 'non'
                    ),
                    'expanded' => true,
                )
            )
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
