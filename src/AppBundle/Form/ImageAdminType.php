<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;

class ImageAdminType extends AbstractType
{
    public function getParent()
    {
        return 'file';
    }

    public function getName()
    {
        return 'image_admin_type';
    }
}
