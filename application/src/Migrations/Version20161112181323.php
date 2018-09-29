<?php
namespace Main\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20161112181323 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE players_events (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT NULL, seed INT NOT NULL, turn INT NOT NULL, is_resolved TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_6599389599E6F5DF (player_id), UNIQUE INDEX player_type_turn (player_id, type, turn), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE players_events ADD CONSTRAINT FK_6599389599E6F5DF FOREIGN KEY (player_id) REFERENCES players (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE players_events');
    }
}