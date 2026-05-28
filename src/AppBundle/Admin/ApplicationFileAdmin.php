<?php

namespace AppBundle\Admin;

use AppBundle\Entity\ApplicationFile;
use AppBundle\Form\DocAdminType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

/**
 * ApplicationFile admin.
 */
class ApplicationFileAdmin extends AbstractAdmin
{
    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     *
     * @return \Sonata\AdminBundle\Datagrid\ListMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('fileName');

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
            ->add('file', DocAdminType::class, array(
                'label' => 'Document',
                'required' => false,
            ));

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
