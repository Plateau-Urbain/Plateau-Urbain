<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160219171548 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE application_file DROP FOREIGN KEY FK_7B735E98DF558641');
        $this->addSql('ALTER TABLE application_file ADD CONSTRAINT FK_7B735E98DF558641 FOREIGN KEY (space_document_id) REFERENCES SpaceDocument (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE application_file DROP FOREIGN KEY FK_7B735E98DF558641');
        $this->addSql('ALTER TABLE application_file ADD CONSTRAINT FK_7B735E98DF558641 FOREIGN KEY (space_document_id) REFERENCES Application (id)');
    }
}
