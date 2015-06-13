<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150611140047 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Application (id INT AUTO_INCREMENT NOT NULL, space_id INT DEFAULT NULL, category_id INT DEFAULT NULL, description LONGTEXT NOT NULL, startOccupation DATE NOT NULL, endOccupation DATE NOT NULL, projectHolder_id INT DEFAULT NULL, INDEX IDX_22C7521623575340 (space_id), INDEX IDX_22C7521612469DE2 (category_id), INDEX IDX_22C752164F912EC8 (projectHolder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Application ADD CONSTRAINT FK_22C7521623575340 FOREIGN KEY (space_id) REFERENCES Space (id)');
        $this->addSql('ALTER TABLE Application ADD CONSTRAINT FK_22C7521612469DE2 FOREIGN KEY (category_id) REFERENCES Category (id)');
        $this->addSql('ALTER TABLE Application ADD CONSTRAINT FK_22C752164F912EC8 FOREIGN KEY (projectHolder_id) REFERENCES fos_user (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Application DROP FOREIGN KEY FK_22C7521612469DE2');
        $this->addSql('DROP TABLE Application');
        $this->addSql('DROP TABLE Category');
    }
}
