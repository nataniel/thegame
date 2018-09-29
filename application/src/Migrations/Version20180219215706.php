<?php
namespace Main\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180219215706 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql([
            "ALTER TABLE `games` CHANGE `status` `current_status` INT(11) NOT NULL",
            "ALTER TABLE `players_events` CHANGE `seed` `random_seed` INT(11) NOT NULL",
        ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql([
            "ALTER TABLE `games` CHANGE `current_status` `status` INT(11) NOT NULL",
            "ALTER TABLE `players_events` CHANGE `random_seed` `seed` INT(11) NOT NULL",
        ]);
    }
}
