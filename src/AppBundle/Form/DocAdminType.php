<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;

class DocAdminType extends AbstractType
{
    public function getParent()
    {
        return 'file';
    }

    // The FormTypeInterface::getName()
    // method is deprecated since Symfony 2.8 and will be removed in 3.0.
    // Remove it from your classes. Use getBlockPrefix() if you want
    // to customize the template block prefix.
    // This method will be added to the FormTypeInterface with Symfony 3.0
    //public function getName()
    public function getBlockPrefix()
    {
        return 'doc_admin_type';
    }
}
