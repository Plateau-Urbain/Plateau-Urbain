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
        // Accessing type "entity" by its string name is deprecated
        // since symfony 2.8
        // Use the fully-qualified type class name "Symfony\Bridge\Doctrine\Form\Type\EntityType instead
        // The "property" option is deprecated since Symfony 2.7 and will
        // be removed in 3.0. Use "choice_label" instead
        $builder
            ->add('localType', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', //'entity',
              array('class'=>'AppBundle\Entity\SpaceType',
                //'property' => 'name',
                'choice_label' => 'name',
                'required'  => false,
                'attr'      => array(
                'data-placeholder'=>"Type de local"))) //liste déroulante)
            // Accessing type "choice" by its string name is deprecated since
            // Symfony 2.8 and will be removed in 3.0. Use the fully-qualified
            // type class name "Symfony\Component\Form\Extension\Core\Type\ChoiceType" instead
            ->add('minimumPrice', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',//'choice',
                  array(
                    'choices'   => array_combine(range(0, 1000, 10), range(0, 1000, 10)),
                    'choices_as_values' => true,
                    'required'  => false,
                    'attr'      => array(
                        'data-placeholder'=>"Prix min/m²/mois")))
            ->add('maximumPrice', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',//'choice',
               array(
                'choices'   => array_combine(range(10, 1000, 10), range(10, 1000, 10)),
                'choices_as_values' => true,
                'required'  => false,
                'attr'      => array(
                    'data-placeholder'=>"Prix max/m²/mois")))
            ->add('minimumSurface', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',//'choice',
               array(
                'choices'   => array_combine(range(0, 1000, 5), range(0, 1000, 5)),
                'choices_as_values' => true,
                'required'  => false,
                'attr'      => array(
                    'data-placeholder'=>"Surface min")
            ))
            ->add('maximumSurface', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',//'choice',
               array(
                'choices'   => array_combine(range(5, 1000, 5), range(5, 1000, 5)),
                'choices_as_values' => true,
                'required'  => false,
                'attr'      => array(
                    'data-placeholder'=>"Surface max")
            ))
            // Accessing type "hidden" by its string name is deprecated since
            // Symfony 2.8 and will be removed in 3.0. Use the fully-qualified
            // type class name "Symfony\Component\Form\Extension\Core\Type\HiddenType" instead
            ->add('zipCode', 'Symfony\Component\Form\Extension\Core\Type\HiddenType')
            // Accessing type "text" by its string name is deprecated since
            // Symfony 2.8 and will be removed in 3.0. Use the fully-qualified
            // type class name "Symfony\Component\Form\Extension\Core\Type\TextType" instead.
            ->add(
                'orderBy',
                'Symfony\Component\Form\Extension\Core\Type\TextType',
                array('data' => 'name')
            )
            ->add(
                'sort',
                'Symfony\Component\Form\Extension\Core\Type\TextType',
                array('data' => 'ASC')
            )

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

    // AppBundle\Form\SearchType: The FormTypeInterface::getName()
    // method is deprecated since Symfony 2.8 and will be removed in 3.0.
    // Remove it from your classes. Use getBlockPrefix() if you want to
    // customize the template block prefix. This method will be added
    // to the FormTypeInterface with Symfony 3.0.
    /**
     * @return string
     */
    //public function getName()
    public function getBlockPrefix()
    {
        return 'appbundle_search_space';
    }
}
