<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160222112851 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE application_file DROP FOREIGN KEY FK_7B735E98DF558641');
        $this->addSql('DROP TABLE SpaceDocument');
        $this->addSql('DROP TABLE UserDocument');
        $this->addSql('ALTER TABLE fos_user ADD google_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_7B735E98DF558641 ON application_file');
        $this->addSql('ALTER TABLE application_file DROP space_document_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE SpaceDocument (id INT AUTO_INCREMENT NOT NULL, space_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_663D99E023575340 (space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE UserDocument (id INT AUTO_INCREMENT NOT NULL, projectHolder_id INT DEFAULT NULL, updatedAt DATETIME NOT NULL, file_name VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_156BCCAF4F912EC8 (projectHolder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE SpaceDocument ADD CONSTRAINT FK_663D99E023575340 FOREIGN KEY (space_id) REFERENCES Space (id)');
        $this->addSql('ALTER TABLE UserDocument ADD CONSTRAINT FK_156BCCAF4F912EC8 FOREIGN KEY (projectHolder_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE application_file ADD space_document_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE application_file ADD CONSTRAINT FK_7B735E98DF558641 FOREIGN KEY (space_document_id) REFERENCES SpaceDocument (id)');
        $this->addSql('CREATE INDEX IDX_7B735E98DF558641 ON application_file (space_document_id)');
        $this->addSql('ALTER TABLE fos_user DROP google_id');
    }
}
