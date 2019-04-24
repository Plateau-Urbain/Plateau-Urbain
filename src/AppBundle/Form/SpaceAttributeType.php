<?php
// vim:expandtab:sw=4 softtabstop=4:

namespace AppBundle\Form;

use AppBundle\Entity\SpaceAttribute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
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
