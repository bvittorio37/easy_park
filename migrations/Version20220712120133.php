<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220712120133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tarif ADD parking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tarif ADD CONSTRAINT FK_E7189C9F17B2DD FOREIGN KEY (parking_id) REFERENCES parking (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E7189C9F17B2DD ON tarif (parking_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tarif DROP CONSTRAINT FK_E7189C9F17B2DD');
        $this->addSql('DROP INDEX IDX_E7189C9F17B2DD');
        $this->addSql('ALTER TABLE tarif DROP parking_id');
    }
}
