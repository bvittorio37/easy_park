<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713112905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parking ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parking ADD CONSTRAINT FK_B237527A19EB6921 FOREIGN KEY (client_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B237527A19EB6921 ON parking (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE parking DROP CONSTRAINT FK_B237527A19EB6921');
        $this->addSql('DROP INDEX IDX_B237527A19EB6921');
        $this->addSql('ALTER TABLE parking DROP client_id');
    }
}
