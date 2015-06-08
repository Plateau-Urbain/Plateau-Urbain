<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150604173813 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Attribute (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Space (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, locationDescription LONGTEXT NOT NULL, usageRestriction LONGTEXT NOT NULL, surface VARCHAR(255) NOT NULL, size VARCHAR(255) NOT NULL, availability LONGTEXT NOT NULL, limitAvailability DATE NOT NULL, price VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE space_attributes (id INT AUTO_INCREMENT NOT NULL, space_id INT DEFAULT NULL, attribute_id INT DEFAULT NULL, INDEX IDX_37048A2123575340 (space_id), INDEX IDX_37048A21B6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE space_image (id INT AUTO_INCREMENT NOT NULL, space_id INT DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL, INDEX IDX_C83B181B23575340 (space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE space_attributes ADD CONSTRAINT FK_37048A2123575340 FOREIGN KEY (space_id) REFERENCES Space (id)');
        $this->addSql('ALTER TABLE space_attributes ADD CONSTRAINT FK_37048A21B6E62EFA FOREIGN KEY (attribute_id) REFERENCES Attribute (id)');
        $this->addSql('ALTER TABLE space_image ADD CONSTRAINT FK_C83B181B23575340 FOREIGN KEY (space_id) REFERENCES Space (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE space_attributes DROP FOREIGN KEY FK_37048A21B6E62EFA');
        $this->addSql('ALTER TABLE space_attributes DROP FOREIGN KEY FK_37048A2123575340');
        $this->addSql('ALTER TABLE space_image DROP FOREIGN KEY FK_C83B181B23575340');
        $this->addSql('DROP TABLE Attribute');
        $this->addSql('DROP TABLE Space');
        $this->addSql('DROP TABLE space_attributes');
        $this->addSql('DROP TABLE space_image');
    }
}
