<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220719164301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE etat_place_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE historique_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE etat_place (id INT NOT NULL, place_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_328A7F74DA6A219 ON etat_place (place_id)');
        $this->addSql('CREATE TABLE historique (id INT NOT NULL, place_id INT NOT NULL, client_id INT NOT NULL, tarif_id INT DEFAULT NULL, matricule VARCHAR(30) NOT NULL, debut TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, depart TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, amende INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EDBFD5ECDA6A219 ON historique (place_id)');
        $this->addSql('CREATE INDEX IDX_EDBFD5EC19EB6921 ON historique (client_id)');
        $this->addSql('CREATE INDEX IDX_EDBFD5EC357C0A59 ON historique (tarif_id)');
        $this->addSql('ALTER TABLE etat_place ADD CONSTRAINT FK_328A7F74DA6A219 FOREIGN KEY (place_id) REFERENCES place (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECDA6A219 FOREIGN KEY (place_id) REFERENCES place (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC19EB6921 FOREIGN KEY (client_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC357C0A59 FOREIGN KEY (tarif_id) REFERENCES tarif (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE etat_place_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE historique_id_seq CASCADE');
        $this->addSql('DROP TABLE etat_place');
        $this->addSql('DROP TABLE historique');
    }
}
