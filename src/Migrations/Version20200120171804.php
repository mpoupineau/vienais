<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200120171804 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE photo_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, image_path VARCHAR(255) DEFAULT NULL, priority INT NOT NULL, visible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo_photo_tag (photo_id INT NOT NULL, photo_tag_id INT NOT NULL, INDEX IDX_81D3D8767E9E4C8C (photo_id), INDEX IDX_81D3D876EF6D1439 (photo_tag_id), PRIMARY KEY(photo_id, photo_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo_photo_tag ADD CONSTRAINT FK_81D3D8767E9E4C8C FOREIGN KEY (photo_id) REFERENCES photo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo_photo_tag ADD CONSTRAINT FK_81D3D876EF6D1439 FOREIGN KEY (photo_tag_id) REFERENCES photo_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cuvee CHANGE wine_type_id wine_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuvee ADD CONSTRAINT FK_317FB4F9D624406 FOREIGN KEY (wine_type_id) REFERENCES wine_type (id)');
        $this->addSql('CREATE INDEX IDX_317FB4F9D624406 ON cuvee (wine_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photo_photo_tag DROP FOREIGN KEY FK_81D3D876EF6D1439');
        $this->addSql('ALTER TABLE photo_photo_tag DROP FOREIGN KEY FK_81D3D8767E9E4C8C');
        $this->addSql('DROP TABLE photo_tag');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE photo_photo_tag');
        $this->addSql('ALTER TABLE cuvee DROP FOREIGN KEY FK_317FB4F9D624406');
        $this->addSql('DROP INDEX IDX_317FB4F9D624406 ON cuvee');
        $this->addSql('ALTER TABLE cuvee CHANGE wine_type_id wine_type_id INT DEFAULT 1 NOT NULL');
    }
}
