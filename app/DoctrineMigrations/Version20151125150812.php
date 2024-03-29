<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151125150812 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE application_file (id INT AUTO_INCREMENT NOT NULL, application_id INT DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL, INDEX IDX_7B735E983E030ACD (application_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application_file ADD CONSTRAINT FK_7B735E983E030ACD FOREIGN KEY (application_id) REFERENCES Application (id)');
        $this->addSql('DROP TABLE file');
        $this->addSql('ALTER TABLE Application CHANGE contribution contribution LONGTEXT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, application_id INT DEFAULT NULL, file_name VARCHAR(255) DEFAULT NULL, INDEX IDX_8C9F36103E030ACD (application_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F36103E030ACD FOREIGN KEY (application_id) REFERENCES Application (id)');
        $this->addSql('DROP TABLE application_file');
        $this->addSql('ALTER TABLE Application CHANGE contribution contribution LONGTEXT NOT NULL');
    }
}
