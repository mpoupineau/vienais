<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221021132510 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE v_vintage ADD prize_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE v_vintage ADD CONSTRAINT FK_D5DBC35FBBE43214 FOREIGN KEY (prize_id) REFERENCES v_prize (id)');
        $this->addSql('CREATE INDEX IDX_D5DBC35FBBE43214 ON v_vintage (prize_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE v_vintage DROP FOREIGN KEY FK_D5DBC35FBBE43214');
        $this->addSql('DROP INDEX IDX_D5DBC35FBBE43214 ON v_vintage');
        $this->addSql('ALTER TABLE v_vintage DROP prize_id');
    }
}
