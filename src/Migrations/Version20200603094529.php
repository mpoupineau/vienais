<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200603094529 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE v_message CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE v_cuvee RENAME INDEX idx_317fb4f9d624406 TO IDX_1851C3A9D624406');
        $this->addSql('ALTER TABLE v_order CHANGE new new TINYINT(1) NOT NULL, CHANGE state state VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE v_delivery_address ADD email VARCHAR(255) NOT NULL, ADD address_complement VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE v_bottle DROP FOREIGN KEY FK_ACA9A9559C478A4F');
        $this->addSql('ALTER TABLE v_bottle ADD CONSTRAINT FK_C7EBD6D648198056 FOREIGN KEY (vintage_id) REFERENCES v_vintage (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE v_bottle DROP FOREIGN KEY FK_C7EBD6D648198056');
        $this->addSql('ALTER TABLE v_bottle ADD CONSTRAINT FK_ACA9A9559C478A4F FOREIGN KEY (vintage_id) REFERENCES v_cuvee (id)');
        $this->addSql('ALTER TABLE v_cuvee RENAME INDEX idx_1851c3a9d624406 TO IDX_317FB4F9D624406');
        $this->addSql('ALTER TABLE v_delivery_address DROP email, DROP address_complement');
        $this->addSql('ALTER TABLE v_message CHANGE phone phone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE v_order CHANGE state state VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'init\' NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE new new INT NOT NULL');
    }
}
