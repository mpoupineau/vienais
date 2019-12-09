<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191102162354 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE capacity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) DEFAULT NULL, volume DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, object VARCHAR(255) NOT NULL, comment TEXT NOT NULL, date DATETIME NOT NULL, new TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cuvee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) DEFAULT NULL, description TEXT NOT NULL, image_path VARCHAR(255) DEFAULT NULL, visible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wine_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bottle (id INT AUTO_INCREMENT NOT NULL, cuvee_id INT DEFAULT NULL, wine_type_id INT DEFAULT NULL, capacity_id INT DEFAULT NULL, year INT NOT NULL, price DOUBLE PRECISION NOT NULL, description TEXT NOT NULL, visible TINYINT(1) NOT NULL, available TINYINT(1) NOT NULL, INDEX fk_foreign_wine_type_id (wine_type_id), INDEX fk_foreign_capacity_id (capacity_id), INDEX fk_foreign_cuvee_id (cuvee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bottle ADD CONSTRAINT FK_ACA9A9559C478A4F FOREIGN KEY (cuvee_id) REFERENCES cuvee (id)');
        $this->addSql('ALTER TABLE bottle ADD CONSTRAINT FK_ACA9A955D624406 FOREIGN KEY (wine_type_id) REFERENCES wine_type (id)');
        $this->addSql('ALTER TABLE bottle ADD CONSTRAINT FK_ACA9A95566B6F0BA FOREIGN KEY (capacity_id) REFERENCES capacity (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bottle DROP FOREIGN KEY FK_ACA9A95566B6F0BA');
        $this->addSql('ALTER TABLE bottle DROP FOREIGN KEY FK_ACA9A9559C478A4F');
        $this->addSql('ALTER TABLE bottle DROP FOREIGN KEY FK_ACA9A955D624406');
        $this->addSql('DROP TABLE capacity');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE cuvee');
        $this->addSql('DROP TABLE wine_type');
        $this->addSql('DROP TABLE bottle');
    }
}
