<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260206004145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE armor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(20) NOT NULL, defense INT NOT NULL, slots JSON DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE armor_skill (id INT AUTO_INCREMENT NOT NULL, level INT NOT NULL, armor_id INT NOT NULL, skil_id INT NOT NULL, INDEX IDX_B2B6111FF5AA3663 (armor_id), INDEX IDX_B2B6111F5E0DABF4 (skil_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, max_level INT NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE armor_skill ADD CONSTRAINT FK_B2B6111FF5AA3663 FOREIGN KEY (armor_id) REFERENCES armor (id)');
        $this->addSql('ALTER TABLE armor_skill ADD CONSTRAINT FK_B2B6111F5E0DABF4 FOREIGN KEY (skil_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE build ADD build_id INT DEFAULT NULL, ADD chest_id INT DEFAULT NULL, ADD arms_id INT DEFAULT NULL, ADD waist_id INT DEFAULT NULL, ADD legs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE build ADD CONSTRAINT FK_BDA0F2DB17C13F8B FOREIGN KEY (build_id) REFERENCES armor (id)');
        $this->addSql('ALTER TABLE build ADD CONSTRAINT FK_BDA0F2DB180955AC FOREIGN KEY (chest_id) REFERENCES armor (id)');
        $this->addSql('ALTER TABLE build ADD CONSTRAINT FK_BDA0F2DB776F9449 FOREIGN KEY (arms_id) REFERENCES armor (id)');
        $this->addSql('ALTER TABLE build ADD CONSTRAINT FK_BDA0F2DB2A2EFD5 FOREIGN KEY (waist_id) REFERENCES armor (id)');
        $this->addSql('ALTER TABLE build ADD CONSTRAINT FK_BDA0F2DB42DBDF0B FOREIGN KEY (legs_id) REFERENCES armor (id)');
        $this->addSql('CREATE INDEX IDX_BDA0F2DB17C13F8B ON build (build_id)');
        $this->addSql('CREATE INDEX IDX_BDA0F2DB180955AC ON build (chest_id)');
        $this->addSql('CREATE INDEX IDX_BDA0F2DB776F9449 ON build (arms_id)');
        $this->addSql('CREATE INDEX IDX_BDA0F2DB2A2EFD5 ON build (waist_id)');
        $this->addSql('CREATE INDEX IDX_BDA0F2DB42DBDF0B ON build (legs_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE armor_skill DROP FOREIGN KEY FK_B2B6111FF5AA3663');
        $this->addSql('ALTER TABLE armor_skill DROP FOREIGN KEY FK_B2B6111F5E0DABF4');
        $this->addSql('DROP TABLE armor');
        $this->addSql('DROP TABLE armor_skill');
        $this->addSql('DROP TABLE skill');
        $this->addSql('ALTER TABLE build DROP FOREIGN KEY FK_BDA0F2DB17C13F8B');
        $this->addSql('ALTER TABLE build DROP FOREIGN KEY FK_BDA0F2DB180955AC');
        $this->addSql('ALTER TABLE build DROP FOREIGN KEY FK_BDA0F2DB776F9449');
        $this->addSql('ALTER TABLE build DROP FOREIGN KEY FK_BDA0F2DB2A2EFD5');
        $this->addSql('ALTER TABLE build DROP FOREIGN KEY FK_BDA0F2DB42DBDF0B');
        $this->addSql('DROP INDEX IDX_BDA0F2DB17C13F8B ON build');
        $this->addSql('DROP INDEX IDX_BDA0F2DB180955AC ON build');
        $this->addSql('DROP INDEX IDX_BDA0F2DB776F9449 ON build');
        $this->addSql('DROP INDEX IDX_BDA0F2DB2A2EFD5 ON build');
        $this->addSql('DROP INDEX IDX_BDA0F2DB42DBDF0B ON build');
        $this->addSql('ALTER TABLE build DROP build_id, DROP chest_id, DROP arms_id, DROP waist_id, DROP legs_id');
    }
}
