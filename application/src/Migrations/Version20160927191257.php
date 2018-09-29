<?php
namespace Main\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160927191257 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql([
            'ALTER TABLE players
                ADD current_phase INT DEFAULT NULL AFTER user_id,
                ADD created_at DATETIME NOT NULL',
            'UPDATE players SET created_at = NOW()',
        ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE players DROP current_phase, DROP created_at');
    }
}
