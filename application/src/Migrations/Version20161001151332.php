<?php
namespace Main\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20161001151332 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE players_technologies ADD active TINYINT(1) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX player_active ON players_technologies (player_id, active)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP INDEX player_active ON players_technologies');
        $this->addSql('ALTER TABLE players_technologies DROP active');
    }
}
