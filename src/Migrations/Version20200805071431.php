<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200805071431 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, date_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_task (id INT AUTO_INCREMENT NOT NULL, training_id INT NOT NULL, name VARCHAR(64) NOT NULL, description VARCHAR(255) NOT NULL, duration TIME NOT NULL, completed TINYINT(1) NOT NULL, INDEX IDX_5DE49C66BEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE training_task ADD CONSTRAINT FK_5DE49C66BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
        $this->addSql('ALTER TABLE chat CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE money CHANGE description description VARCHAR(128) DEFAULT NULL');
        $this->addSql('ALTER TABLE observer CHANGE from_user_id from_user_id INT DEFAULT NULL, CHANGE to_user_id to_user_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE training_task DROP FOREIGN KEY FK_5DE49C66BEFD98D1');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE training_task');
        $this->addSql('ALTER TABLE chat CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE money CHANGE description description VARCHAR(128) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE observer CHANGE from_user_id from_user_id INT DEFAULT NULL, CHANGE to_user_id to_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
