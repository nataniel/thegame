<?php
namespace Main\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160924143719 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql([
            'CREATE TABLE users_profiles (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, profile_id VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_F071AEEAA76ED395 (user_id), UNIQUE INDEX profile_type (profile_id, type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB',
            'ALTER TABLE users_profiles ADD CONSTRAINT FK_F071AEEAA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)',
        ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql([
            'DROP TABLE users_profiles',
        ]);
    }
}
