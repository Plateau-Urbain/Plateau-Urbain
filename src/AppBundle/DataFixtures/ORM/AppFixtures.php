<?php

namespace AppBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class AppFixtures extends DataFixtureLoader
{
    /**
     * {@inheritDoc}
     */
    protected function getFixtures()
    {
        return array(
            __DIR__.'/Users.yml',
            __DIR__.'/Attributes.yml',
            __DIR__.'/Categories.yml',
            __DIR__.'/Spaces.yml',
        );
    }
}
