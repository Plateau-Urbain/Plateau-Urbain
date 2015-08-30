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
            ->add('name', null, array('label' => 'Nom de l\'espace' , 'attr' => array('class' => 'form-control')))
            ->add('zipCode', null, array('label' => 'Code postal' , 'attr' => array('class' => 'form-control')))
            ->add('city', null, array('label' => 'Ville' , 'attr' => array('class' => 'form-control')))
            ->add('limitAvailability', null, array('label' => 'Date limite de candidature', 'attr' => array('class' => 'inline-date')))
            ->add('type', null, array('label' => 'Type de locaux', 'attr' => array('class' => 'form-control')))
            ->add('price', null, array('label' => 'Prix au m²', 'attr' => array('class' => 'form-control')))
            ->add('availability', null, array('label' => 'Période de disponibilité', 'attr' => array('class' => 'form-control')))
            ->add('description', null, array('label' => 'Description', 'attr' => array('class' => 'form-control', 'rows' => 5)))
            ->add('activityDescription', null, array('label' => 'Activités recherchées', 'attr' => array('class' => 'form-control', 'rows' => 5)))
            ->add('tags', 'collection', array(
                'type'      => new SpaceAttributeType(),
                'label'     => 'Prestations',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('pics', 'collection', array(
                'type' => new ImageType(),
                'label' => 'Photos',
                'allow_add' => true,
                'allow_delete'  => true,
                'by_reference' => false
            ))
            ->add('parcels', 'collection', array(
                'type'      => new ParcelType(),
                'label'     => 'Lots',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
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
