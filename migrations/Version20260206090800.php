<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260206090800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE build_decoration (id INT AUTO_INCREMENT NOT NULL, quantity INT NOT NULL, build_id INT DEFAULT NULL, decoration_id INT NOT NULL, INDEX IDX_F5BF1F1E17C13F8B (build_id), INDEX IDX_F5BF1F1E3446DFC4 (decoration_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE decoration (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slot_level INT NOT NULL, skill_level INT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, skill_id INT NOT NULL, INDEX IDX_7649DA75585C142 (skill_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE build_decoration ADD CONSTRAINT FK_F5BF1F1E17C13F8B FOREIGN KEY (build_id) REFERENCES build (id)');
        $this->addSql('ALTER TABLE build_decoration ADD CONSTRAINT FK_F5BF1F1E3446DFC4 FOREIGN KEY (decoration_id) REFERENCES decoration (id)');
        $this->addSql('ALTER TABLE decoration ADD CONSTRAINT FK_7649DA75585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE build_decoration DROP FOREIGN KEY FK_F5BF1F1E17C13F8B');
        $this->addSql('ALTER TABLE build_decoration DROP FOREIGN KEY FK_F5BF1F1E3446DFC4');
        $this->addSql('ALTER TABLE decoration DROP FOREIGN KEY FK_7649DA75585C142');
        $this->addSql('DROP TABLE build_decoration');
        $this->addSql('DROP TABLE decoration');
    }
}
