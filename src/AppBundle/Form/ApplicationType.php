<?php

namespace AppBundle\Form;

use AppBundle\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ApplicationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label'=>"Nom du projet", 'attr' => array('placeholder'=>"Nom du projet", 'class'=>'form-control input-box')) )
            ->add('description', null, array('label'=>"Description du projet", 'attr' => array('placeholder'=>"Description du projet", 'class'=>'form-control textarea-box')))
            ->add('contribution', null, array('label'=>"Quelle serait votre contribution au projet global du propriétaire ?", 'attr' => array('class'=>'form-control textarea-box')))
            ->add('startOccupation', 'date', array(
                    'label'=>"Date d'entrée souhaitée",
                    'input'  => 'datetime',
                'widget'=>'single_text',
                'attr' => array(
                    'class'=>'form-control input-box')
                )
            )
            ->add('lengthOccupation', null, array(
                    'label'=>"Durée d'occupation",
                    'attr' => array('class' => 'form-control')
                )
            )
            ->add('openToGlobalProject', null, array('label' => "Je suis ouvert(e) à faire partie d'un projet collectif " ))
            ->add('lengthTypeOccupation', 'choice', array('choices' => Application::getAllLengthType(),  'label' => "Durée d'occupation", 'attr' => array('class' => 'form-control')))

            ->add('category', null, array('label'=>"Categorie du projet",'required'=> true, 'attr'=> array('placeholder'=>"Categorie du projet", 'class'=>'form-control input-box')))
            ->add('wishedSize', null, array('label'=>"Surface souhaitée en m²", 'attr' => array('class' => 'form-control input-box')));

//  Don't delete... Just in case :) .
//            ->add('files', 'afe_collection_upload', array(
//                'type' => new ImageType(),
//                'nameable' => false,
//                'label' => 'Fichiers',
//                'allow_add' => true,
//                'allow_delete'  => true,
//                'maxNumberOfFiles' => 10,
//                'uploadRouteName' => 'upload_action',
//                'prependFiles' => true,
//                'autoUpload' => true,
//                'options' => array(
//                    'data_class' => "AppBundle\Entity\File",
//                ),
//            ))


    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Application'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_application';
    }
}
