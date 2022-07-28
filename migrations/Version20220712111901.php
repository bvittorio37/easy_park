<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220712111901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parking DROP CONSTRAINT fk_b237527a357c0a59');
        $this->addSql('DROP INDEX idx_b237527a357c0a59');
        $this->addSql('ALTER TABLE parking DROP tarif_id');
        $this->addSql('ALTER TABLE tarif ADD parking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tarif ADD CONSTRAINT FK_E7189C9F17B2DD FOREIGN KEY (parking_id) REFERENCES parking (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E7189C9F17B2DD ON tarif (parking_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE parking ADD tarif_id INT NOT NULL');
        $this->addSql('ALTER TABLE parking ADD CONSTRAINT fk_b237527a357c0a59 FOREIGN KEY (tarif_id) REFERENCES tarif (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b237527a357c0a59 ON parking (tarif_id)');
        $this->addSql('ALTER TABLE tarif DROP CONSTRAINT FK_E7189C9F17B2DD');
        $this->addSql('DROP INDEX IDX_E7189C9F17B2DD');
        $this->addSql('ALTER TABLE tarif DROP parking_id');
    }
}
