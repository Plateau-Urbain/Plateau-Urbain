<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Vich\UploaderBundle\Form\Type\VichImageType;
use AppBundle\Entity\SpaceImage;

/**
 * SpaceImage admin.
 */
class SpaceImageAdmin extends AbstractAdmin
{
    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     *
     * @return \Sonata\AdminBundle\Datagrid\ListMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('fileName')
            ->add('fileType', 'choice', [
                'choices' => [
                    SpaceImage::FILETYPE_IMAGE => 'Image',
                    SpaceImage::FILETYPE_DOCUMENT_PLAN => 'Plan',
                    SpaceImage::FILETYPE_DOCUMENT_AAC => 'AAC'
                ],
                'label' => 'Type'
            ])
            ->add('space', null, ['label' => 'Espace']);

        return $listMapper;
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return \Sonata\AdminBundle\Form\FormMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('file', VichImageType::class, array(
                'required' => false,
            ))
            ->add('fileType', 'choice', [
                'choices' => [
                    SpaceImage::FILETYPE_IMAGE => 'Image',
                    SpaceImage::FILETYPE_DOCUMENT_PLAN => 'Plan',
                    SpaceImage::FILETYPE_DOCUMENT_AAC => 'AAC'
                ],
                'label' => 'Type de fichier',
                'required' => true
            ])
            ->add('space', null, ['label' => 'Espace']);

        return $formMapper;
    }

    public function getFormTheme()
    {
        return array_merge(
            array('AppBundle:Form:custom_admin_fields.html.twig'),
            parent::getFormTheme()
        );
    }
}
