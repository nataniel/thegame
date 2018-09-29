<?php
namespace Main\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160921200810 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql([
            'CREATE UNIQUE INDEX game_user ON players (game_id, user_id)',
            'CREATE UNIQUE INDEX game_position ON players (game_id, position)',
        ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql([
            'DROP INDEX game_user ON players',
            'DROP INDEX game_position ON players',
        ]);
    }
}
