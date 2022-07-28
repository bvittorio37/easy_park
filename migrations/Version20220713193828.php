<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713193828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parking ADD tarif_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parking ADD CONSTRAINT FK_B237527A357C0A59 FOREIGN KEY (tarif_id) REFERENCES tarif (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B237527A357C0A59 ON parking (tarif_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE parking DROP CONSTRAINT FK_B237527A357C0A59');
        $this->addSql('DROP INDEX IDX_B237527A357C0A59');
        $this->addSql('ALTER TABLE parking DROP tarif_id');
    }
}
