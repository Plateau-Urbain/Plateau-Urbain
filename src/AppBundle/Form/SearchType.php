<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('localType', 'entity', array('class'=>'AppBundle\Entity\LocalType', 'property' => 'name',
                'required'  => false,
                'attr'      => array(
                'data-placeholder'=>"Type de local")) ) //liste déroulante)
            ->add('minimumPrice', 'choice', array(
                    'choices'   => array_combine(range(10,1000,10), range(10,1000,10)),
                    'required'  => false,
                    'attr'      => array(
                        'data-placeholder'=>"Prix min/m2/mois")) )
            ->add('maximumPrice', 'choice', array(
                'choices'   => array_combine(range(100,1000,10), range(100,1000,10)),
                'required'  => false,
                'attr'      => array(
                    'data-placeholder'=>"Prix max/m2/mois")) )
            ->add('minimumSurface', 'choice', array(
                'choices'   => array_combine(range(5,1000,5), range(5,1000,5)),
                'required'  => false,
                'attr'      => array(
                    'data-placeholder'=>"Surface min")
            ))
            ->add('maximumSurface', 'choice', array(
                'choices'   => array_combine(range(5,1000,5), range(5,1000,5)),
                'required'  => false,
                'attr'      => array(
                    'data-placeholder'=>"Surface max")
            ))
            ->add('zipCode', 'hidden')
            ->add('orderBy', 'text', array('data' => 'name'))
            ->add('sort', 'text', array('data' => 'ASC'))

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_search_space';
    }
}
