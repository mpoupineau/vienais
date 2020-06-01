<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200601143637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE v_order (id INT AUTO_INCREMENT NOT NULL, delivery_address_id INT DEFAULT NULL, raw TEXT NOT NULL, sub_price DOUBLE PRECISION NOT NULL, delivery_fees DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_DC07E4C8EBF23851 (delivery_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE v_delivery_address (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zipcode VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE v_order ADD CONSTRAINT FK_DC07E4C8EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES v_delivery_address (id)');
        $this->addSql('ALTER TABLE v_message CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE v_cuvee RENAME INDEX idx_317fb4f9d624406 TO IDX_1851C3A9D624406');
        $this->addSql('ALTER TABLE v_bottle DROP FOREIGN KEY FK_ACA9A9559C478A4F');
        $this->addSql('ALTER TABLE v_bottle ADD CONSTRAINT FK_C7EBD6D648198056 FOREIGN KEY (vintage_id) REFERENCES v_vintage (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE v_order DROP FOREIGN KEY FK_DC07E4C8EBF23851');
        $this->addSql('DROP TABLE v_order');
        $this->addSql('DROP TABLE v_delivery_address');
        $this->addSql('ALTER TABLE v_bottle DROP FOREIGN KEY FK_C7EBD6D648198056');
        $this->addSql('ALTER TABLE v_bottle ADD CONSTRAINT FK_ACA9A9559C478A4F FOREIGN KEY (vintage_id) REFERENCES v_cuvee (id)');
        $this->addSql('ALTER TABLE v_cuvee RENAME INDEX idx_1851c3a9d624406 TO IDX_317FB4F9D624406');
        $this->addSql('ALTER TABLE v_message CHANGE phone phone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
