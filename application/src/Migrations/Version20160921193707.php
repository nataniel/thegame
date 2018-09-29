<?php
namespace Main\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160921193707 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql([
            'CREATE TABLE games (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB',
            'CREATE TABLE players (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, user_id INT DEFAULT NULL, position INT NOT NULL, INDEX IDX_264E43A6E48FD905 (game_id), INDEX IDX_264E43A6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB',
            'ALTER TABLE players ADD CONSTRAINT FK_264E43A6E48FD905 FOREIGN KEY (game_id) REFERENCES games (id)',
            'ALTER TABLE players ADD CONSTRAINT FK_264E43A6A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)',
        ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql([
            'ALTER TABLE players DROP FOREIGN KEY FK_264E43A6E48FD905',
            'DROP TABLE games',
            'DROP TABLE players',
        ]);
    }
}