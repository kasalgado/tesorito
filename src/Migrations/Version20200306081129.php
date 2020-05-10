<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200306081129 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, date_time DATETIME NOT NULL, description VARCHAR(128) NOT NULL, weekly TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE buy (id INT AUTO_INCREMENT NOT NULL, end_day DATE NOT NULL, description VARCHAR(128) NOT NULL, completed TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date_time DATETIME NOT NULL, chat_text VARCHAR(128) NOT NULL, new_message TINYINT(1) NOT NULL, user_checking VARCHAR(255) NOT NULL, monitor TINYINT(1) NOT NULL, INDEX IDX_659DF2AAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dish (id INT AUTO_INCREMENT NOT NULL, dish_type SMALLINT NOT NULL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE homework (id INT AUTO_INCREMENT NOT NULL, on_day DATE NOT NULL, status VARCHAR(16) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal (id INT AUTO_INCREMENT NOT NULL, week SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal_dish (id INT AUTO_INCREMENT NOT NULL, meals_id INT NOT NULL, dishes_id INT NOT NULL, week_day SMALLINT NOT NULL, INDEX IDX_8FA35F4C88A25CA2 (meals_id), INDEX IDX_8FA35F4CA05DD37A (dishes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, on_day DATE NOT NULL, description VARCHAR(128) NOT NULL, completed TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('SET foreign_key_checks=0');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE meal_dish ADD CONSTRAINT FK_8FA35F4C88A25CA2 FOREIGN KEY (meals_id) REFERENCES meal (id)');
        $this->addSql('ALTER TABLE meal_dish ADD CONSTRAINT FK_8FA35F4CA05DD37A FOREIGN KEY (dishes_id) REFERENCES dish (id)');
        $this->addSql('SET foreign_key_checks=1');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE meal_dish DROP FOREIGN KEY FK_8FA35F4CA05DD37A');
        $this->addSql('ALTER TABLE meal_dish DROP FOREIGN KEY FK_8FA35F4C88A25CA2');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AAA76ED395');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE buy');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE dish');
        $this->addSql('DROP TABLE homework');
        $this->addSql('DROP TABLE meal');
        $this->addSql('DROP TABLE meal_dish');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE user');
    }
}
