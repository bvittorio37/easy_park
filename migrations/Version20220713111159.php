<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713111159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE demande_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE portefeuil_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE demande (id INT NOT NULL, client_id INT NOT NULL, somme DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2694D7A519EB6921 ON demande (client_id)');
        $this->addSql('CREATE TABLE portefeuil (id INT NOT NULL, client_id INT NOT NULL, solde INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_80F98D5D19EB6921 ON portefeuil (client_id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A519EB6921 FOREIGN KEY (client_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE portefeuil ADD CONSTRAINT FK_80F98D5D19EB6921 FOREIGN KEY (client_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parking ALTER debut DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE demande_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE portefeuil_id_seq CASCADE');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE portefeuil');
        $this->addSql('ALTER TABLE parking ALTER debut SET DEFAULT CURRENT_TIMESTAMP');
    }
}
