<?php
namespace Main\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180929142142 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql([

            'CREATE TABLE users (
                id INT AUTO_INCREMENT NOT NULL,
                first_name VARCHAR(255) NOT NULL,
                last_name VARCHAR(255) NOT NULL,
                login VARCHAR(255) DEFAULT NULL,
                encrypted_password VARCHAR(255) DEFAULT NULL,
                active TINYINT(1) NOT NULL,
                locale VARCHAR(10) DEFAULT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME DEFAULT NULL,
                UNIQUE INDEX UNIQ_1483A5E9AA08CB10 (login),
                PRIMARY KEY(id))
                DEFAULT CHARACTER SET utf8
                COLLATE utf8_unicode_ci
                ENGINE = InnoDB',

            'CREATE TABLE users_properties (
                id INT AUTO_INCREMENT NOT NULL,
                user_id INT DEFAULT NULL,
                name VARCHAR(255) NOT NULL,
                value LONGTEXT NOT NULL,
                INDEX IDX_50A89E53A76ED395 (user_id),
                PRIMARY KEY(id))
                DEFAULT CHARACTER SET utf8
                COLLATE utf8_unicode_ci
                ENGINE = InnoDB',

            'ALTER TABLE users_properties
             ADD CONSTRAINT FK_1E849A07A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)',

            'CREATE TABLE users_tokens (
                id INT AUTO_INCREMENT NOT NULL,
                user_id INT DEFAULT NULL,
                type VARCHAR(255) NOT NULL,
                hash VARCHAR(255) NOT NULL,
                created_at DATETIME NOT NULL,
                expires_at DATETIME DEFAULT NULL,
                INDEX IDX_A5BD9F1EA76ED395 (user_id),
                INDEX user_hash (user_id, type, hash),
                PRIMARY KEY(id))
                DEFAULT CHARACTER SET utf8
                COLLATE utf8_unicode_ci
                ENGINE = InnoDB',

            'ALTER TABLE users_tokens
             ADD CONSTRAINT FK_A5BD9F1EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)',

            'CREATE TABLE users_profiles (
                id INT AUTO_INCREMENT NOT NULL,
                user_id INT DEFAULT NULL,
                profile_id VARCHAR(255) NOT NULL,
                type VARCHAR(255) NOT NULL,
                created_at DATETIME NOT NULL,
                INDEX IDX_F071AEEAA76ED395 (user_id),
                UNIQUE INDEX profile_type (profile_id, type),
                PRIMARY KEY(id))
                DEFAULT CHARACTER SET utf8
                COLLATE utf8_unicode_ci
                ENGINE = InnoDB',

            'ALTER TABLE users_profiles
             ADD CONSTRAINT FK_F071AEEAA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)',

        ]);
    }

    public function down(Schema $schema) : void
    {

    }
}
