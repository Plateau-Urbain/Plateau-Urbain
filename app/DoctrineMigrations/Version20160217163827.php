<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160217163827 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE UserDocument DROP FOREIGN KEY FK_156BCCAF6A24B1A2');
        $this->addSql('DROP INDEX IDX_156BCCAF6A24B1A2 ON UserDocument');
        $this->addSql('ALTER TABLE UserDocument CHANGE user_document_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE UserDocument ADD CONSTRAINT FK_156BCCAFA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_156BCCAFA76ED395 ON UserDocument (user_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE UserDocument DROP FOREIGN KEY FK_156BCCAFA76ED395');
        $this->addSql('DROP INDEX IDX_156BCCAFA76ED395 ON UserDocument');
        $this->addSql('ALTER TABLE UserDocument CHANGE user_id user_document_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE UserDocument ADD CONSTRAINT FK_156BCCAF6A24B1A2 FOREIGN KEY (user_document_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_156BCCAF6A24B1A2 ON UserDocument (user_document_id)');
    }
}
