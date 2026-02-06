<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260206004335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE build ADD head_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE build ADD CONSTRAINT FK_BDA0F2DBF41A619E FOREIGN KEY (head_id) REFERENCES armor (id)');
        $this->addSql('CREATE INDEX IDX_BDA0F2DBF41A619E ON build (head_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE build DROP FOREIGN KEY FK_BDA0F2DBF41A619E');
        $this->addSql('DROP INDEX IDX_BDA0F2DBF41A619E ON build');
        $this->addSql('ALTER TABLE build DROP head_id');
    }
}
