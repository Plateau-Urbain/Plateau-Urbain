<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration to replace surface field with minSurface and maxSurface fields in Parcel table
 */
class Version20250915160603 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // Copy surface value to new fields
        $this->addSql('ALTER TABLE parcel ADD min_surface INT NOT NULL DEFAULT 0, ADD max_surface INT NOT NULL DEFAULT 0');
        $this->addSql('UPDATE parcel SET min_surface = surface, max_surface = surface');
        $this->addSql('ALTER TABLE parcel DROP surface');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // Restore surface field with max_surface value
        $this->addSql('ALTER TABLE parcel ADD surface INT NOT NULL DEFAULT 0');
        $this->addSql('UPDATE parcel SET surface = max_surface');
        $this->addSql('ALTER TABLE parcel DROP min_surface, DROP max_surface');
    }
}