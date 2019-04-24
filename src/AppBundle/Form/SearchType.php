<?php
// vim:expandtab:sw=4 softtabstop=4:

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('localType', 'entity', array('class'=>'AppBundle\Entity\SpaceType', 'property' => 'name',
                'required'  => false,
                'attr'      => array(
                'data-placeholder'=>"Type de local")) ) //liste déroulante)
            ->add('minimumPrice', 'choice', array(
                    'choices'   => array_combine(range(0,1000,10), range(0,1000,10)),
                    'required'  => false,
                    'attr'      => array(
                        'data-placeholder'=>"Prix min/m²/mois")) )
            ->add('maximumPrice', 'choice', array(
                'choices'   => array_combine(range(10,1000,10), range(10,1000,10)),
                'required'  => false,
                'attr'      => array(
                    'data-placeholder'=>"Prix max/m²/mois")) )
            ->add('minimumSurface', 'choice', array(
                'choices'   => array_combine(range(0,1000,5), range(0,1000,5)),
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
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
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
