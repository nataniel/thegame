<?php
namespace Main\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160930154952 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE players_technologies (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT NULL, progress DOUBLE PRECISION NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_24E10CF099E6F5DF (player_id), UNIQUE INDEX player_type (player_id, type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE players_technologies ADD CONSTRAINT FK_24E10CF099E6F5DF FOREIGN KEY (player_id) REFERENCES players (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE players_technologies');
    }
}
