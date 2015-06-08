<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150607200310 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Space ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Space ADD CONSTRAINT FK_E8B3EE3E7E3C61F9 FOREIGN KEY (owner_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_E8B3EE3E7E3C61F9 ON Space (owner_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Space DROP FOREIGN KEY FK_E8B3EE3E7E3C61F9');
        $this->addSql('DROP INDEX IDX_E8B3EE3E7E3C61F9 ON Space');
        $this->addSql('ALTER TABLE Space DROP owner_id');
    }
}
