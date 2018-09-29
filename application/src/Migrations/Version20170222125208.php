<?php
namespace Main\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170222125208 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE `groups` DROP FOREIGN KEY FK_F06D3970727ACA70');
        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0FE54D947');
        $this->addSql('DROP TABLE `groups`');
        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0A76ED395');
        $this->addSql('DROP INDEX IDX_FF8AB7E0FE54D947 ON users_groups');
        $this->addSql('ALTER TABLE users_groups DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users_groups ADD PRIMARY KEY (user_id, group_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('CREATE TABLE `groups` (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, position INT DEFAULT NULL, active TINYINT(1) NOT NULL, INDEX IDX_F06D3970727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `groups` ADD CONSTRAINT FK_F06D3970727ACA70 FOREIGN KEY (parent_id) REFERENCES `groups` (id)');
        $this->addSql('ALTER TABLE users_groups DROP FOREIGN KEY FK_FF8AB7E0A76ED395');
        $this->addSql('ALTER TABLE users_groups DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0FE54D947 FOREIGN KEY (group_id) REFERENCES `groups` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_groups ADD CONSTRAINT FK_FF8AB7E0A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_FF8AB7E0FE54D947 ON users_groups (group_id)');
        $this->addSql('ALTER TABLE users_groups ADD PRIMARY KEY (group_id, user_id)');
    }
}