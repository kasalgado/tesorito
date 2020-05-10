<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200311071332 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE money (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, trans_type SMALLINT NOT NULL, amount DOUBLE PRECISION NOT NULL, balance DOUBLE PRECISION NOT NULL, description VARCHAR(128) DEFAULT NULL, INDEX IDX_B7DF13E4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('SET foreign_key_checks=0');
        $this->addSql('ALTER TABLE money ADD CONSTRAINT FK_B7DF13E4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chat CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE goal CHANGE percentage percentage SMALLINT DEFAULT NULL, CHANGE last last SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE observer CHANGE from_user_id from_user_id INT DEFAULT NULL, CHANGE to_user_id to_user_id INT DEFAULT NULL');
        $this->addSql('SET foreign_key_checks=1');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE money');
        $this->addSql('ALTER TABLE chat CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE goal CHANGE percentage percentage SMALLINT DEFAULT NULL, CHANGE last last SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE observer CHANGE from_user_id from_user_id INT DEFAULT NULL, CHANGE to_user_id to_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
