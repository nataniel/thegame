<?php
namespace Main\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160926175544 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql([
            'ALTER TABLE users ADD locale VARCHAR(255) DEFAULT NULL AFTER active',
            'UPDATE users SET locale = "pl"',
        ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE users DROP locale');
    }
}
