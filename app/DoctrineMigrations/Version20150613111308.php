<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150613111308 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Sponsor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fos_user ADD created DATETIME NOT NULL, ADD birthday DATE NOT NULL, ADD facebookUrl VARCHAR(255) DEFAULT NULL, ADD instagramUrl VARCHAR(255) DEFAULT NULL, ADD twitterUrl VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, ADD siret VARCHAR(255) DEFAULT NULL, ADD wishedSize VARCHAR(255) DEFAULT NULL, ADD usageType VARCHAR(255) DEFAULT NULL, ADD usageDate VARCHAR(255) DEFAULT NULL, ADD usageDuration VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Sponsor');
        $this->addSql('ALTER TABLE fos_user DROP created, DROP birthday, DROP facebookUrl, DROP instagramUrl, DROP twitterUrl, DROP description, DROP siret, DROP wishedSize, DROP usageType, DROP usageDate, DROP usageDuration');
    }
}
