<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration pour créer la table space_visit (visites d'un espace)
 */
class Version20250918100000 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE space_visit (id INT AUTO_INCREMENT NOT NULL, space_id INT DEFAULT NULL, visit_date DATE NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, INDEX IDX_5A6E8A9D4B3F7FB (space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE space_visit ADD CONSTRAINT FK_5A6E8A9D4B3F7FB FOREIGN KEY (space_id) REFERENCES space (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE space_visit');
    }
}


