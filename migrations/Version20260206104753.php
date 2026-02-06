<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260206104753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE charm_skill ADD skill_id INT NOT NULL');
        $this->addSql('ALTER TABLE charm_skill ADD CONSTRAINT FK_4A4A82365585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('CREATE INDEX IDX_4A4A82365585C142 ON charm_skill (skill_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE charm_skill DROP FOREIGN KEY FK_4A4A82365585C142');
        $this->addSql('DROP INDEX IDX_4A4A82365585C142 ON charm_skill');
        $this->addSql('ALTER TABLE charm_skill DROP skill_id');
    }
}
