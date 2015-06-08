<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SpaceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('locationDescription')
            ->add('usageRestriction')
            ->add('surface')
            ->add('size')
            ->add('availability')
            ->add('limitAvailability')
            ->add('price')
            ->add('owner')
            ->add('spaceAttributes', 'entity', array(
                'attr'      => array('class' => 'after-checkbox-label-block'),
                'class'     => 'AppBundle:Attribute',
                'expanded'  => true,
                'label'     => 'Objet de la demande',
                'multiple'  => true,
                'property'  => 'name',
            ))
            ->add('pics', 'afe_collection_upload', array(
                'type' => new ImageType(),
                'nameable' => false,
                'allow_add' => true,
                'allow_delete'  => true,
                'maxNumberOfFiles' => 5,
                'uploadRouteName' => 'homepage',
                'prependFiles' => true,
                'autoUpload' => true,
                'options' => array(
                    'data_class' => "AppBundle\Entity\SpaceImage",
                ),
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Space',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_space';
    }
}
