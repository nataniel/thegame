<?php
namespace Main\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180930183405 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql([

            'CREATE TABLE players_events (
                id INT AUTO_INCREMENT NOT NULL,
                player_id INT DEFAULT NULL,
                random_seed INT DEFAULT NULL,
                status INT NOT NULL,
                created_at DATETIME NOT NULL,
                type VARCHAR(255) NOT NULL,
                INDEX IDX_6599389599E6F5DF (player_id),
                PRIMARY KEY(id))
                DEFAULT CHARACTER SET utf8
                COLLATE utf8_unicode_ci
                ENGINE = InnoDB',
            'ALTER TABLE players_events
             ADD CONSTRAINT FK_6599389599E6F5DF FOREIGN KEY (player_id) REFERENCES players (id)',

        ]);
    }

    public function down(Schema $schema) : void
    {
    }
}
