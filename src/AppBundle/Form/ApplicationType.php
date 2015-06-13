<?php

namespace AppBundle\Form;

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
            ->add('startOccupation', 'date', array(
                    'label'=>"Date d'entrée souhaitée",
                    'input'  => 'datetime',
                'widget'=>'single_text',
                'attr' => array(
                    'class'=>'form-control input-box')
                )
            )
            ->add('endOccupation', 'date', array(
                    'input'  => 'datetime',
                    'label'=>"Date de sortie souhaitée",
                    'widget'=>'single_text',
                    'attr' => array(
                        'placeholder'=>"Nom du projet",
                        'class'=>'form-control input-box')
                )
            )
            //->add('space')
            ->add('category', null, array('label'=>"Categorie du projet",'required'=> true, 'attr'=> array('placeholder'=>"Categorie du projet", 'class'=>'form-control input-box')))
            //->add('projectHolder')

            ->add('files', 'afe_collection_upload', array(
                'type' => new ImageType(),
                'nameable' => false,
                'label' => 'Fichiers',
                'allow_add' => true,
                'allow_delete'  => true,
                'maxNumberOfFiles' => 10,
                'uploadRouteName' => 'upload_action',
                'prependFiles' => true,
                'autoUpload' => true,
                'options' => array(
                    'data_class' => "AppBundle\Entity\File",
                ),
            ))
        ;
        ;
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
