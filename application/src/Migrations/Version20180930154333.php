<?php
namespace Main\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180930154333 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql([

            'CREATE TABLE players_notifications (
                id INT AUTO_INCREMENT NOT NULL,
                player_id INT DEFAULT NULL,
                created_at DATETIME NOT NULL,
                INDEX IDX_CEB9F06E99E6F5DF (player_id),
                PRIMARY KEY(id))
                DEFAULT CHARACTER SET utf8
                COLLATE utf8_unicode_ci
                ENGINE = InnoDB',
            'ALTER TABLE players_notifications
             ADD CONSTRAINT FK_CEB9F06E99E6F5DF FOREIGN KEY (player_id) REFERENCES players (id)',

            'ALTER TABLE players
             DROP INDEX IDX_264E43A6A76ED395,
             ADD UNIQUE INDEX UNIQ_264E43A6A76ED395 (user_id)',

        ]);
    }

    public function down(Schema $schema) : void
    {
    }
}