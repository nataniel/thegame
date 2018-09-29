<?php
namespace Main\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20161113102321 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('DROP INDEX player_type_turn ON players_events');
        $this->addSql('CREATE UNIQUE INDEX player_turn ON players_events (player_id, turn)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP INDEX player_turn ON players_events');
        $this->addSql('CREATE UNIQUE INDEX player_type_turn ON players_events (player_id, type, turn)');
    }
}