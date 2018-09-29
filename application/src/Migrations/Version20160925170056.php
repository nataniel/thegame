<?php
namespace Main\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160925170056 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE players_buildings (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT NULL, amount INT NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_4EE8E9799E6F5DF (player_id), UNIQUE INDEX player_type (player_id, type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE players_supplies (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT NULL, amount INT NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_3780CFEF99E6F5DF (player_id), UNIQUE INDEX player_type (player_id, type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE players_units (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT NULL, amount INT NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_F4955DE399E6F5DF (player_id), UNIQUE INDEX player_type (player_id, type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE players_buildings ADD CONSTRAINT FK_4EE8E9799E6F5DF FOREIGN KEY (player_id) REFERENCES players (id)');
        $this->addSql('ALTER TABLE players_supplies ADD CONSTRAINT FK_3780CFEF99E6F5DF FOREIGN KEY (player_id) REFERENCES players (id)');
        $this->addSql('ALTER TABLE players_units ADD CONSTRAINT FK_F4955DE399E6F5DF FOREIGN KEY (player_id) REFERENCES players (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE players_buildings');
        $this->addSql('DROP TABLE players_supplies');
        $this->addSql('DROP TABLE players_units');
    }
}
