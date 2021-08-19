<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151207095408 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE use_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fos_user DROP FOREIGN KEY FK_957A647912469DE2');
        $this->addSql('DROP INDEX IDX_957A647912469DE2 ON fos_user');
        $this->addSql('ALTER TABLE fos_user CHANGE category_id useType_id INT DEFAULT NULL');
        $this->addSql("INSERT INTO use_type VALUES(1, 'Artistique')");
        $this->addSql("INSERT INTO use_type VALUES(2, 'Activité')");
        $this->addSql("UPDATE fos_user SET useType_id = '1'");
        $this->addSql('ALTER TABLE fos_user ADD CONSTRAINT FK_957A647935521D14 FOREIGN KEY (useType_id) REFERENCES use_type (id)');
        $this->addSql('CREATE INDEX IDX_957A647935521D14 ON fos_user (useType_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fos_user DROP FOREIGN KEY FK_957A647935521D14');
        $this->addSql('DROP TABLE UseType');
        $this->addSql('DROP INDEX IDX_957A647935521D14 ON fos_user');
        $this->addSql('ALTER TABLE fos_user CHANGE usetype_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fos_user ADD CONSTRAINT FK_957A647912469DE2 FOREIGN KEY (category_id) REFERENCES Category (id)');
        $this->addSql('CREATE INDEX IDX_957A647912469DE2 ON fos_user (category_id)');
    }
}
