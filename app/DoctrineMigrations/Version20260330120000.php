<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add is_active flag on use_type and category tables.
 *
 * Allows to archive an entry (hide it from user-facing forms) without
 * deleting it, so existing profiles/applications referencing it keep
 * a valid value.
 */
class Version20260330120000 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE use_type ADD is_active TINYINT(1) NOT NULL DEFAULT 1');
        $this->addSql('ALTER TABLE category ADD is_active TINYINT(1) NOT NULL DEFAULT 1');

        $this->addSql('UPDATE use_type SET is_active = 1');
        $this->addSql('UPDATE category SET is_active = 1');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE use_type DROP is_active');
        $this->addSql('ALTER TABLE category DROP is_active');
    }
}
