<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220712052823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parking ALTER tarif_id SET NOT NULL');
        $this->addSql('ALTER TABLE parking ALTER debut DROP DEFAULT');
        $this->addSql('ALTER TABLE parking ALTER debut SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE parking ALTER tarif_id DROP NOT NULL');
        $this->addSql('ALTER TABLE parking ALTER debut SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE parking ALTER debut DROP NOT NULL');
    }
}
