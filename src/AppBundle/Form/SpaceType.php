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
            ->add('name', null, array('label' => 'Nom du projet' , 'attr' => array('class' => 'form-control')))
            ->add('description', null, array('label' => "Description de l'espace", 'attr' => array('class' => 'form-control')))
            ->add('locationDescription', null, array('label' => 'Description de la situation du lieu' , 'attr' => array('class' => 'form-control')))
            ->add('usageRestriction', 'text', array('label' => "Condition d'utilisation du lieu", 'attr' => array('class' => 'form-control')))
            ->add('surface', null, array('label' => 'Nombre total de m2', 'attr' => array('class' => 'form-control')))
            ->add('size', null, array('label' => 'Taille des lots possibles', 'attr' => array('class' => 'form-control')))
            ->add('availability', null, array('label' => 'Période de disponibilité', 'attr' => array('class' => 'form-control')))
            ->add('limitAvailability', null, array('label' => 'Date de fin de candidature possible', 'attr' => array('class' => 'form-control')))
            ->add('price', null, array('label' => 'Prix de la redevance au m2 mensuel', 'attr' => array('class' => 'form-control')))
//            ->add('owner')
            ->add('tags', 'entity', array(
                'attr'      => array('class' => 'after-checkbox-label-block'),
                'class'     => 'AppBundle:Attribute',
                'expanded'  => true,
                'label'     => 'Attributs de l\'espace',
                'multiple'  => true,
                'property'  => 'name',
            ))
            ->add('pics', 'afe_collection_upload', array(
                'type' => new ImageType(),
                'nameable' => false,
                'label' => 'Photos',
                'allow_add' => true,
                'allow_delete'  => true,
                'maxNumberOfFiles' => 5,
                'uploadRouteName' => 'upload_action',
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
            'data_class' => 'AppBundle\Entity\Space'
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
