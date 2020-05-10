<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200306123044 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE observer (id INT AUTO_INCREMENT NOT NULL, from_user_id INT DEFAULT NULL, to_user_id INT DEFAULT NULL, last_change DATETIME NOT NULL, widget VARCHAR(32) NOT NULL, changed TINYINT(1) NOT NULL, INDEX IDX_9B6F44E72130303A (from_user_id), INDEX IDX_9B6F44E729F6EE60 (to_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('SET foreign_key_checks=0');
        $this->addSql('ALTER TABLE observer ADD CONSTRAINT FK_9B6F44E72130303A FOREIGN KEY (from_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE observer ADD CONSTRAINT FK_9B6F44E729F6EE60 FOREIGN KEY (to_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chat CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE goal CHANGE percentage percentage SMALLINT DEFAULT NULL');
        $this->addSql('SET foreign_key_checks=1');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE observer');
        $this->addSql('ALTER TABLE chat CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE goal CHANGE percentage percentage SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
