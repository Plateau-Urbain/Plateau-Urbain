<?php
// vim:expandtab:sw=4 softtabstop=4:
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\User;
use AppBundle\Entity\Application;

class SpaceOwnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userInfo', UserType::class, ['mapped' => false, 'data_class' => SpaceOwnerType::class])
                ->add('companyFunction', null, array('label' => "Fonction", 'attr' => array('class' => 'form-control', 'rows' => 5)))
                ->add('oldPassword', 'password', array('mapped' => false, 'required' => false, 'label' => "Mot de passe actuel", 'attr' => array('class' => 'form-control')))
                ->add(
                    'password',
                    'repeated',
                    array('type' => PasswordType::class,
                          'required' => false,
                          'invalid_message' => 'Erreur dans la répétition du mot de passe.',
                          'first_options'  => array('label' => 'Nouveau mot de passe', 'attr' => array('class' => 'form-control')),
                          'second_options' => array('label' => 'Répéter nouveau mot de passe', 'attr' => array('class' => 'form-control')))
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
            'data_class' => 'AppBundle\Entity\User',
            'validation_groups' => array('owner', 'Default')
        ));
    }

    // The FormTypeInterface::getName()
    // method is deprecated since Symfony 2.8 and will be removed in 3.0.
    // Remove it from your classes. Use getBlockPrefix() if you want
    // to customize the template block prefix.
    // This method will be added to the FormTypeInterface with Symfony 3.0
    //public function getName()
    public function getBlockPrefix()
    {
        return 'project_owner';
    }
}
