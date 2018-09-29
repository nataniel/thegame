<?php
namespace Main\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160922220020 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql([
            'ALTER TABLE games ADD status INT NOT NULL AFTER name, ADD max_players INT NOT NULL AFTER status',
            'ALTER TABLE players CHANGE position position INT DEFAULT NULL',
        ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql([
            'ALTER TABLE games DROP status, DROP max_players',
            'ALTER TABLE players CHANGE position position INT NOT NULL',
        ]);
    }
}
