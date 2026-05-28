<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add ERP flag on Space and requires_erp flag on Category.
 *
 * - Space.is_erp: indique si le lieu est un ERP (Établissement Recevant du Public).
 * - Category.requires_erp: un "type d'usage" marqué ainsi n'est proposé
 *   dans le formulaire de candidature que pour les espaces ERP.
 */
class Version20260330130000 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE space ADD is_erp TINYINT(1) NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE category ADD requires_erp TINYINT(1) NOT NULL DEFAULT 0');

        $this->addSql('UPDATE space SET is_erp = 0');
        $this->addSql('UPDATE category SET requires_erp = 0');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE space DROP is_erp');
        $this->addSql('ALTER TABLE category DROP requires_erp');
    }
}
