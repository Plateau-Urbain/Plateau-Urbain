<?php
// vim:expandtab:sw=4 softtabstop=4:

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use AppBundle\Entity\User;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Accessing type "password" by its string name is deprecated since Symfony 2.8 and will be removed in 3.0.
        // Symfony\Component\Form\Extension\Core\Type\PasswordType
        $builder
                // add your custom field
                ->add('email', null, array('label' => "Email", 'attr' => array('class' => 'form-control', 'placeholder' => 'Adresse email')))
                ->add(
                    'plainPassword',
                    RepeatedType::class,
                    array(
                        'type' => PasswordType::class,
                        'first_options' => array('label' => 'form.password', 'attr' => array('class' => 'form-control', 'placeholder' => 'Mot de passe')),
                        'second_options' => array('label' => 'form.password_confirmation', 'attr' => array('class' => 'form-control', 'placeholder' => 'Confirmation')),
                        'label' => "Mot de passe")
                )
        ;



        $builder->remove('username');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'validation_groups' => array("register", 'Default')
        ));
    }

    public function getParent()
    {
        /* Accessing type "fos_user_registration" by its string name
         * is deprecated since Symfony 2.8 and will be removed in 3.0.
         * Use the fully-qualified type class name
         * "FOS\UserBundle\Form\Type\RegistrationFormType" instead. */
        return 'FOS\\UserBundle\\Form\\Type\\RegistrationFormType';
    }

    // The FormTypeInterface::getName() method is deprecated since Symfony 2.8 and will be removed in 3.0.
    // Remove it from your classes. Use getBlockPrefix() if you want to customize the template block prefix.
    //This method will be added to the FormTypeInterface with Symfony 3.0
    //public function getName() {
    //    return 'project_holder_user_registration';
    //}
    public function getBlockPrefix()
    {
        return 'project_holder_user_registration';
    }
}
