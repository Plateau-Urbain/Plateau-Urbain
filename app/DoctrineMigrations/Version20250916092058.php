<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration pour ajouter les champs nb_spaces, min_space et max_space à la table space
 */
class Version20250916092058 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE space ADD nb_spaces INT DEFAULT NULL, ADD min_space INT DEFAULT NULL, ADD max_space INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE space DROP nb_spaces, DROP min_space, DROP max_space');
    }
}