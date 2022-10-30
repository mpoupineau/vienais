<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221009185540 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE v_wine_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE v_promo_code (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(30) NOT NULL, type VARCHAR(30) NOT NULL, description TEXT DEFAULT NULL, start_date DATETIME DEFAULT NULL, expiry_date DATETIME NOT NULL, fixed_reduction DOUBLE PRECISION DEFAULT NULL, variable_reduction DOUBLE PRECISION DEFAULT NULL, visible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE v_order (id INT AUTO_INCREMENT NOT NULL, delivery_address_id INT DEFAULT NULL, reference TINYTEXT NOT NULL, raw TEXT NOT NULL, sub_price DOUBLE PRECISION NOT NULL, delivery_fees DOUBLE PRECISION NOT NULL, total_discount DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, state VARCHAR(255) NOT NULL, payment_type VARCHAR(255) DEFAULT NULL, discount_id INT DEFAULT NULL, discount_description LONGTEXT DEFAULT NULL, tpp_reference TINYTEXT DEFAULT NULL, new TINYINT(1) NOT NULL, mail_sent TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_DC07E4C8EBF23851 (delivery_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE v_photo_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE v_delivery_address (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, address_complement VARCHAR(255) DEFAULT NULL, zipcode VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE v_capacity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) DEFAULT NULL, volume DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE v_vintage (id INT AUTO_INCREMENT NOT NULL, cuvee_id INT DEFAULT NULL, year INT NOT NULL, description TEXT NOT NULL, visible TINYINT(1) NOT NULL, priority INT NOT NULL, INDEX fk_foreign_cuvee_id (cuvee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE v_cuvee (id INT AUTO_INCREMENT NOT NULL, wine_type_id INT DEFAULT NULL, name VARCHAR(100) DEFAULT NULL, description TEXT NOT NULL, variety LONGTEXT DEFAULT NULL, vinification LONGTEXT DEFAULT NULL, tasting LONGTEXT DEFAULT NULL, accord LONGTEXT DEFAULT NULL, image_path VARCHAR(255) DEFAULT NULL, priority INT NOT NULL, visible TINYINT(1) NOT NULL, INDEX IDX_1851C3A9D624406 (wine_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE v_delivery_fees (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) DEFAULT NULL, quantity INT NOT NULL, fees DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE v_photo (id INT AUTO_INCREMENT NOT NULL, image_path VARCHAR(255) DEFAULT NULL, priority INT NOT NULL, visible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo_photo_tag (photo_id INT NOT NULL, photo_tag_id INT NOT NULL, INDEX IDX_81D3D8767E9E4C8C (photo_id), INDEX IDX_81D3D876EF6D1439 (photo_tag_id), PRIMARY KEY(photo_id, photo_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE v_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7A2D1E30F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE v_message (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, comment TEXT NOT NULL, date DATETIME NOT NULL, new TINYINT(1) NOT NULL, archived TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE v_news (id INT AUTO_INCREMENT NOT NULL, image_path VARCHAR(255) DEFAULT NULL, title VARCHAR(50) DEFAULT NULL, slug VARCHAR(128) NOT NULL, text LONGTEXT DEFAULT NULL, visible TINYINT(1) NOT NULL, homePage TINYINT(1) NOT NULL, createdAt DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE v_bottle (id INT AUTO_INCREMENT NOT NULL, vintage_id INT DEFAULT NULL, capacity_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, promo_price DOUBLE PRECISION DEFAULT NULL, visible TINYINT(1) NOT NULL, available TINYINT(1) NOT NULL, INDEX fk_foreign_capacity_id (capacity_id), INDEX fk_foreign_vintage_id (vintage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE v_order ADD CONSTRAINT FK_DC07E4C8EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES v_delivery_address (id)');
        $this->addSql('ALTER TABLE v_vintage ADD CONSTRAINT FK_D5DBC35F9C478A4F FOREIGN KEY (cuvee_id) REFERENCES v_cuvee (id)');
        $this->addSql('ALTER TABLE v_cuvee ADD CONSTRAINT FK_1851C3A9D624406 FOREIGN KEY (wine_type_id) REFERENCES v_wine_type (id)');
        $this->addSql('ALTER TABLE photo_photo_tag ADD CONSTRAINT FK_81D3D8767E9E4C8C FOREIGN KEY (photo_id) REFERENCES v_photo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo_photo_tag ADD CONSTRAINT FK_81D3D876EF6D1439 FOREIGN KEY (photo_tag_id) REFERENCES v_photo_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE v_bottle ADD CONSTRAINT FK_C7EBD6D648198056 FOREIGN KEY (vintage_id) REFERENCES v_vintage (id)');
        $this->addSql('ALTER TABLE v_bottle ADD CONSTRAINT FK_C7EBD6D666B6F0BA FOREIGN KEY (capacity_id) REFERENCES v_capacity (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE v_cuvee DROP FOREIGN KEY FK_1851C3A9D624406');
        $this->addSql('ALTER TABLE photo_photo_tag DROP FOREIGN KEY FK_81D3D876EF6D1439');
        $this->addSql('ALTER TABLE v_order DROP FOREIGN KEY FK_DC07E4C8EBF23851');
        $this->addSql('ALTER TABLE v_bottle DROP FOREIGN KEY FK_C7EBD6D666B6F0BA');
        $this->addSql('ALTER TABLE v_bottle DROP FOREIGN KEY FK_C7EBD6D648198056');
        $this->addSql('ALTER TABLE v_vintage DROP FOREIGN KEY FK_D5DBC35F9C478A4F');
        $this->addSql('ALTER TABLE photo_photo_tag DROP FOREIGN KEY FK_81D3D8767E9E4C8C');
        $this->addSql('DROP TABLE v_wine_type');
        $this->addSql('DROP TABLE v_promo_code');
        $this->addSql('DROP TABLE v_order');
        $this->addSql('DROP TABLE v_photo_tag');
        $this->addSql('DROP TABLE v_delivery_address');
        $this->addSql('DROP TABLE v_capacity');
        $this->addSql('DROP TABLE v_vintage');
        $this->addSql('DROP TABLE v_cuvee');
        $this->addSql('DROP TABLE v_delivery_fees');
        $this->addSql('DROP TABLE v_photo');
        $this->addSql('DROP TABLE photo_photo_tag');
        $this->addSql('DROP TABLE v_user');
        $this->addSql('DROP TABLE v_message');
        $this->addSql('DROP TABLE v_news');
        $this->addSql('DROP TABLE v_bottle');
    }
}
