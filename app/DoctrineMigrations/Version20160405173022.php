<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160405173022 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Space CHANGE description description LONGTEXT DEFAULT NULL, CHANGE availability availability VARCHAR(255) DEFAULT NULL, CHANGE limitAvailability limitAvailability DATE DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT NULL, CHANGE activity_description activity_description LONGTEXT DEFAULT NULL, CHANGE zip_code zip_code VARCHAR(255) DEFAULT NULL, CHANGE city city VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Space CHANGE description description LONGTEXT NOT NULL, CHANGE activity_description activity_description LONGTEXT NOT NULL, CHANGE zip_code zip_code VARCHAR(255) NOT NULL, CHANGE city city VARCHAR(255) NOT NULL, CHANGE availability availability VARCHAR(255) NOT NULL, CHANGE limitAvailability limitAvailability DATE NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL');
    }
}
