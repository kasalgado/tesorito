<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200420092952 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('SET foreign_key_checks=0');
        $this->addSql('ALTER TABLE chat CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE money CHANGE description description VARCHAR(128) DEFAULT NULL');
        $this->addSql('ALTER TABLE observer CHANGE from_user_id from_user_id INT DEFAULT NULL, CHANGE to_user_id to_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(16) NOT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('SET foreign_key_checks=1');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE chat CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE money CHANGE description description VARCHAR(128) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE observer CHANGE from_user_id from_user_id INT DEFAULT NULL, CHANGE to_user_id to_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP name, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
