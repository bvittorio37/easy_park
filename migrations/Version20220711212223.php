<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220711212223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE parking_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE place_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tarif_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE parking (id INT NOT NULL, place_id INT NOT NULL, tarif_id INT DEFAULT NULL, matricule VARCHAR(20) NOT NULL, debut TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, sortie TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B237527ADA6A219 ON parking (place_id)');
        $this->addSql('CREATE INDEX IDX_B237527A357C0A59 ON parking (tarif_id)');
        $this->addSql('CREATE TABLE place (id INT NOT NULL, no_park VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tarif (id INT NOT NULL, temps TIME(0) WITHOUT TIME ZONE NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE parking ADD CONSTRAINT FK_B237527ADA6A219 FOREIGN KEY (place_id) REFERENCES place (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE parking ADD CONSTRAINT FK_B237527A357C0A59 FOREIGN KEY (tarif_id) REFERENCES tarif (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE parking DROP CONSTRAINT FK_B237527ADA6A219');
        $this->addSql('ALTER TABLE parking DROP CONSTRAINT FK_B237527A357C0A59');
        $this->addSql('DROP SEQUENCE parking_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE place_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tarif_id_seq CASCADE');
        $this->addSql('DROP TABLE parking');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE tarif');
    }
}
