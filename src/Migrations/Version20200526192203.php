<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200526192203 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE v_vintage (id INT AUTO_INCREMENT NOT NULL, cuvee_id INT DEFAULT NULL, year INT NOT NULL, description TEXT NOT NULL, visible TINYINT(1) NOT NULL, priority INT NOT NULL, INDEX fk_foreign_cuvee_id (cuvee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE v_vintage ADD CONSTRAINT FK_D5DBC35F9C478A4F FOREIGN KEY (cuvee_id) REFERENCES v_cuvee (id)');
        $this->addSql('ALTER TABLE v_message CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE v_cuvee RENAME INDEX idx_317fb4f9d624406 TO IDX_1851C3A9D624406');
        $this->addSql('ALTER TABLE v_bottle DROP FOREIGN KEY FK_ACA9A9559C478A4F');
        $this->addSql('DROP INDEX fk_foreign_cuvee_id ON v_bottle');
        $this->addSql('ALTER TABLE v_bottle DROP year, DROP description, DROP priority, CHANGE cuvee_id vintage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE v_bottle ADD CONSTRAINT FK_C7EBD6D648198056 FOREIGN KEY (vintage_id) REFERENCES v_vintage (id)');
        $this->addSql('CREATE INDEX fk_foreign_vintage_id ON v_bottle (vintage_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE v_bottle DROP FOREIGN KEY FK_C7EBD6D648198056');
        $this->addSql('DROP TABLE v_vintage');
        $this->addSql('DROP INDEX fk_foreign_vintage_id ON v_bottle');
        $this->addSql('ALTER TABLE v_bottle ADD year INT NOT NULL, ADD description TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD priority INT NOT NULL, CHANGE vintage_id cuvee_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE v_bottle ADD CONSTRAINT FK_ACA9A9559C478A4F FOREIGN KEY (cuvee_id) REFERENCES v_cuvee (id)');
        $this->addSql('CREATE INDEX fk_foreign_cuvee_id ON v_bottle (cuvee_id)');
        $this->addSql('ALTER TABLE v_cuvee RENAME INDEX idx_1851c3a9d624406 TO IDX_317FB4F9D624406');
        $this->addSql('ALTER TABLE v_message CHANGE phone phone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
