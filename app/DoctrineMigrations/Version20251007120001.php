<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migration to change limitAvailability column from DATE to DATETIME
 * This allows storing time information (23:59:59) for the application deadline
 */
class Version20251007120001 extends AbstractMigration
{
    /**
     * Désactive les transactions pour cette migration
     * car ALTER TABLE peut causer des problèmes de transaction dans MySQL
     */
    public function isTransactional(): bool
    {
        return false;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // Change the column type from DATE to DATETIME
        // This allows storing time information (23:59:59) for the deadline
        // MODIFY fonctionne même si la colonne est déjà DATETIME
        $this->addSql('ALTER TABLE space MODIFY limitAvailability DATETIME DEFAULT NULL');
        
        // Update existing records to set time to 23:59:59 if they are at 00:00:00
        // This ensures all existing deadlines are at the end of the day
        $this->addSql("UPDATE space SET limitAvailability = CONCAT(DATE(limitAvailability), ' 23:59:59') WHERE limitAvailability IS NOT NULL AND (TIME(limitAvailability) = '00:00:00' OR TIME(limitAvailability) IS NULL)");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // Revert back to DATE type (this will lose time information)
        $this->addSql('ALTER TABLE space CHANGE limitAvailability limitAvailability DATE DEFAULT NULL');
    }
}

