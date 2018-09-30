<?php
namespace Main\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180929174134 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql([

            'CREATE TABLE players (
                id INT AUTO_INCREMENT NOT NULL,
                user_id INT DEFAULT NULL,
                current_turn INT NOT NULL,
                created_at DATETIME NOT NULL,
                INDEX IDX_264E43A6A76ED395 (user_id),
                PRIMARY KEY(id))
                DEFAULT CHARACTER SET utf8
                COLLATE utf8_unicode_ci
                ENGINE = InnoDB',

            'ALTER TABLE players
             ADD CONSTRAINT FK_264E43A6A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)',

            'CREATE TABLE players_buildings (
                id INT AUTO_INCREMENT NOT NULL,
                player_id INT DEFAULT NULL,
                amount INT NOT NULL,
                type VARCHAR(255) NOT NULL,
                INDEX IDX_4EE8E9799E6F5DF (player_id),
                UNIQUE INDEX player_type (player_id, type),
                PRIMARY KEY(id))
                DEFAULT CHARACTER SET utf8
                COLLATE utf8_unicode_ci
                ENGINE = InnoDB',
            'ALTER TABLE players_buildings
             ADD CONSTRAINT FK_4EE8E9799E6F5DF FOREIGN KEY (player_id) REFERENCES players (id)',

            'CREATE TABLE players_supplies (
                id INT AUTO_INCREMENT NOT NULL,
                player_id INT DEFAULT NULL,
                amount INT NOT NULL,
                type VARCHAR(255) NOT NULL,
                INDEX IDX_3780CFEF99E6F5DF (player_id),
                UNIQUE INDEX player_type (player_id, type),
                PRIMARY KEY(id))
                DEFAULT CHARACTER SET utf8
                COLLATE utf8_unicode_ci
                ENGINE = InnoDB',
            'ALTER TABLE players_supplies
             ADD CONSTRAINT FK_3780CFEF99E6F5DF FOREIGN KEY (player_id) REFERENCES players (id)',

            'CREATE TABLE players_units (
                id INT AUTO_INCREMENT NOT NULL,
                player_id INT DEFAULT NULL,
                amount INT NOT NULL,
                type VARCHAR(255) NOT NULL,
                INDEX IDX_F4955DE399E6F5DF (player_id),
                UNIQUE INDEX player_type (player_id, type),
                PRIMARY KEY(id))
                DEFAULT CHARACTER SET utf8
                COLLATE utf8_unicode_ci
                ENGINE = InnoDB',
            'ALTER TABLE players_units
             ADD CONSTRAINT FK_F4955DE399E6F5DF FOREIGN KEY (player_id) REFERENCES players (id)',

            'CREATE TABLE players_technologies (
                id INT AUTO_INCREMENT NOT NULL,
                player_id INT DEFAULT NULL,
                progress INT DEFAULT NULL,
                active TINYINT(1) DEFAULT NULL,
                type VARCHAR(255) NOT NULL,
                INDEX IDX_24E10CF099E6F5DF (player_id),
                UNIQUE INDEX player_type (player_id, type),
                PRIMARY KEY(id))
                DEFAULT CHARACTER SET utf8
                COLLATE utf8_unicode_ci
                ENGINE = InnoDB',
            'ALTER TABLE players_technologies 
             ADD CONSTRAINT FK_24E10CF099E6F5DF FOREIGN KEY (player_id) REFERENCES players (id)',
        ]);

    }

    public function down(Schema $schema) : void
    {
    }
}
