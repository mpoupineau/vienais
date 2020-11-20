<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201120195613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE v_order ADD total_discount DOUBLE PRECISION NOT NULL, ADD discount_id INT DEFAULT NULL, ADD discount_description LONGTEXT DEFAULT NULL, CHANGE new new TINYINT(1) NOT NULL, CHANGE state state VARCHAR(255) NOT NULL, CHANGE reference reference TINYTEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE v_order DROP total_discount, DROP discount_id, DROP discount_description, CHANGE reference reference VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE state state VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'init\' NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE new new INT NOT NULL');
    }
}
