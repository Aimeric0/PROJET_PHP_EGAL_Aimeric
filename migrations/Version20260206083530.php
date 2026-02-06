<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260206083530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE charm (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slots JSON DEFAULT NULL, rarity INT NOT NULL, charm_skill_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_813D82EAD91B0E1F (charm_skill_id), INDEX IDX_813D82EA5585C142 (skill_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE charm_skill (id INT AUTO_INCREMENT NOT NULL, charm_id INT NOT NULL, INDEX IDX_4A4A823693E9261F (charm_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE charm ADD CONSTRAINT FK_813D82EAD91B0E1F FOREIGN KEY (charm_skill_id) REFERENCES armor_skill (id)');
        $this->addSql('ALTER TABLE charm ADD CONSTRAINT FK_813D82EA5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE charm_skill ADD CONSTRAINT FK_4A4A823693E9261F FOREIGN KEY (charm_id) REFERENCES charm (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE charm DROP FOREIGN KEY FK_813D82EAD91B0E1F');
        $this->addSql('ALTER TABLE charm DROP FOREIGN KEY FK_813D82EA5585C142');
        $this->addSql('ALTER TABLE charm_skill DROP FOREIGN KEY FK_4A4A823693E9261F');
        $this->addSql('DROP TABLE charm');
        $this->addSql('DROP TABLE charm_skill');
    }
}
