<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160407144839 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Application CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE start_occupation start_occupation DATE DEFAULT NULL, CHANGE length_occupation length_occupation INT DEFAULT NULL, CHANGE length_type_occupation length_type_occupation VARCHAR(15) DEFAULT NULL, CHANGE wishedSize wishedSize INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Application CHANGE name name VARCHAR(255) NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE start_occupation start_occupation DATE NOT NULL, CHANGE length_occupation length_occupation INT NOT NULL, CHANGE length_type_occupation length_type_occupation VARCHAR(15) NOT NULL, CHANGE wishedSize wishedSize INT NOT NULL');
    }
}
