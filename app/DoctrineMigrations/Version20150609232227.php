<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150609232227 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Attribute (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_4B019DDB5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Parcel (id INT AUTO_INCREMENT NOT NULL, space_id INT DEFAULT NULL, surface INT NOT NULL, INDEX IDX_CE37585623575340 (space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Space (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, description VARCHAR(255) NOT NULL, locationDescription LONGTEXT NOT NULL, usageRestriction LONGTEXT NOT NULL, surface VARCHAR(255) NOT NULL, size VARCHAR(255) NOT NULL, availability LONGTEXT NOT NULL, limitAvailability DATE NOT NULL, price VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_E8B3EE3E7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE space_attribute (space_id INT NOT NULL, attribute_id INT NOT NULL, INDEX IDX_D3DBA1BE23575340 (space_id), INDEX IDX_D3DBA1BEB6E62EFA (attribute_id), PRIMARY KEY(space_id, attribute_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE space_image (id INT AUTO_INCREMENT NOT NULL, space_id INT DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL, INDEX IDX_C83B181B23575340 (space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, date_of_birth DATETIME DEFAULT NULL, firstname VARCHAR(64) DEFAULT NULL, lastname VARCHAR(64) DEFAULT NULL, website VARCHAR(64) DEFAULT NULL, biography VARCHAR(255) DEFAULT NULL, gender VARCHAR(1) DEFAULT NULL, locale VARCHAR(8) DEFAULT NULL, timezone VARCHAR(64) DEFAULT NULL, phone VARCHAR(64) DEFAULT NULL, facebook_uid VARCHAR(255) DEFAULT NULL, facebook_name VARCHAR(255) DEFAULT NULL, facebook_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', twitter_uid VARCHAR(255) DEFAULT NULL, twitter_name VARCHAR(255) DEFAULT NULL, twitter_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', gplus_uid VARCHAR(255) DEFAULT NULL, gplus_name VARCHAR(255) DEFAULT NULL, gplus_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', token VARCHAR(255) DEFAULT NULL, two_step_code VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, zipcode VARCHAR(10) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, typeUser INT DEFAULT NULL, UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_groups (user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_FF8AB7E0A76ED395 (user_id), INDEX IDX_FF8AB7E0FE54D947 (group_id), PRIMARY KEY(user_id, group_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Parcel ADD CONSTRAINT FK_CE37585623575340 FOREIGN KEY (space_id) REFERENCES Space (id)');
        $this->addSql('ALTER TABLE Space ADD CONSTRAINT FK_E8B3EE3E7E3C61F9 FOREIGN KEY (owner_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE space_attribute ADD CONSTRAINT FK_D3DBA1BE23575340 FOREIGN KEY (space_id) REFERENCES Space (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE space_attribute ADD CONSTRAINT FK_D3DBA1BEB6E62EFA FOREIGN KEY (attribute_id) REFERENCES Attribute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE space_image ADD CONSTRAINT FK_C83B181B23575340 FOREIGN KEY (space_id) REFERENCES Space (id)');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0FE54D947 FOREIGN KEY (group_id) REFERENCES fos_group (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE space_attribute DROP FOREIGN KEY FK_D3DBA1BEB6E62EFA');
        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0FE54D947');
        $this->addSql('ALTER TABLE Parcel DROP FOREIGN KEY FK_CE37585623575340');
        $this->addSql('ALTER TABLE space_attribute DROP FOREIGN KEY FK_D3DBA1BE23575340');
        $this->addSql('ALTER TABLE space_image DROP FOREIGN KEY FK_C83B181B23575340');
        $this->addSql('ALTER TABLE Space DROP FOREIGN KEY FK_E8B3EE3E7E3C61F9');
        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0A76ED395');
        $this->addSql('DROP TABLE Attribute');
        $this->addSql('DROP TABLE fos_group');
        $this->addSql('DROP TABLE Parcel');
        $this->addSql('DROP TABLE Space');
        $this->addSql('DROP TABLE space_attribute');
        $this->addSql('DROP TABLE space_image');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE users_groups');
    }
}
