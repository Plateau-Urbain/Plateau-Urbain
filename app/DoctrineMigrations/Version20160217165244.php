<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160217165244 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE UserDocument DROP FOREIGN KEY FK_156BCCAFA76ED395');
        $this->addSql('DROP INDEX IDX_156BCCAFA76ED395 ON UserDocument');
        $this->addSql('ALTER TABLE UserDocument CHANGE user_id projectHolder_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE UserDocument ADD CONSTRAINT FK_156BCCAF4F912EC8 FOREIGN KEY (projectHolder_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_156BCCAF4F912EC8 ON UserDocument (projectHolder_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE UserDocument DROP FOREIGN KEY FK_156BCCAF4F912EC8');
        $this->addSql('DROP INDEX IDX_156BCCAF4F912EC8 ON UserDocument');
        $this->addSql('ALTER TABLE UserDocument CHANGE projectholder_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE UserDocument ADD CONSTRAINT FK_156BCCAFA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_156BCCAFA76ED395 ON UserDocument (user_id)');
    }
}
