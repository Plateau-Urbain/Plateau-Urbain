<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;

class DocAdminType extends AbstractType
{
    public function getParent()
    {
        return 'file';
    }

    public function getName()
    {
        return 'doc_admin_type';
    }
}
