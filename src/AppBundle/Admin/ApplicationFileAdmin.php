<?php

namespace AppBundle\Admin;

use AppBundle\Entity\ApplicationFile;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

/**
 * ApplicationFile admin.
 */
class ApplicationFileAdmin extends Admin
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
            ->add('file', 'doc_admin_type', array(
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
