<?php
namespace Main\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160921185259 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql([
            'CREATE TABLE `groups` (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, position INT DEFAULT NULL, active TINYINT(1) NOT NULL, INDEX IDX_F06D3970727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB',
            'CREATE TABLE users_groups (group_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_FF8AB7E0FE54D947 (group_id), INDEX IDX_FF8AB7E0A76ED395 (user_id), PRIMARY KEY(group_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB',
            'CREATE TABLE mailer_templates (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, from_name VARCHAR(255) NOT NULL, from_email VARCHAR(255) NOT NULL, to_name VARCHAR(255) NOT NULL, to_email VARCHAR(255) NOT NULL, headers LONGTEXT NOT NULL, subject VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, format SMALLINT NOT NULL, locale VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB',
            'CREATE TABLE users_preferences (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, value LONGTEXT NOT NULL, INDEX IDX_1E849A07A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB',
            'CREATE TABLE users_tokens (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, expires_at DATETIME DEFAULT NULL, INDEX IDX_A5BD9F1EA76ED395 (user_id), INDEX user_hash (user_id, type, hash), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB',
            'CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, remote_addr VARCHAR(255) NOT NULL, remote_host VARCHAR(255) NOT NULL, login VARCHAR(255) DEFAULT NULL, encrypted_password VARCHAR(255) DEFAULT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB',
            'ALTER TABLE `groups` ADD CONSTRAINT FK_F06D3970727ACA70 FOREIGN KEY (parent_id) REFERENCES `groups` (id)',
            'ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0FE54D947 FOREIGN KEY (group_id) REFERENCES `groups` (id) ON DELETE CASCADE',
            'ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE',
            'ALTER TABLE users_preferences ADD CONSTRAINT FK_1E849A07A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)',
            'ALTER TABLE users_tokens ADD CONSTRAINT FK_A5BD9F1EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)',
        ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql([
            'ALTER TABLE `groups` DROP FOREIGN KEY FK_F06D3970727ACA70',
            'ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0FE54D947',
            'ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0A76ED395',
            'ALTER TABLE users_preferences DROP FOREIGN KEY FK_1E849A07A76ED395',
            'ALTER TABLE users_tokens DROP FOREIGN KEY FK_A5BD9F1EA76ED395',
            'DROP TABLE `groups`',
            'DROP TABLE users_groups',
            'DROP TABLE mailer_templates',
            'DROP TABLE users_preferences',
            'DROP TABLE users_tokens',
            'DROP TABLE users',
        ]);
    }
}
