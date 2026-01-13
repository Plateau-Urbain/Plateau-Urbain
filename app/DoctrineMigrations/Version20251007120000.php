<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to add price_text field to Space entity (if it doesn't exist)
 */
final class Version20251007120000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add price_text field to Space entity';
    }

    public function up(Schema $schema) : void
    {
        // Ajouter la colonne price_text
        // Note: Si la colonne existe déjà, cette migration peut être marquée comme exécutée
        // avec: php app/console doctrine:migrations:version Version20251007120000 --add
        $this->addSql('ALTER TABLE space ADD price_text VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE space DROP price_text');
    }
}

