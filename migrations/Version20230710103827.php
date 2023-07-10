<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710103827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE monnaie_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE sorties_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE sorties (id INT NOT NULL, produits_id INT NOT NULL, admin_id INT NOT NULL, motif TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, quantite INT NOT NULL, prix_unitaire INT NOT NULL, prix_total INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_488163E8CD11A2CF ON sorties (produits_id)');
        $this->addSql('CREATE INDEX IDX_488163E8642B8210 ON sorties (admin_id)');
        $this->addSql('COMMENT ON COLUMN sorties.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E8CD11A2CF FOREIGN KEY (produits_id) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sorties ADD CONSTRAINT FK_488163E8642B8210 FOREIGN KEY (admin_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE monnaie DROP CONSTRAINT fk_b3a6e2e630ef05f');
        $this->addSql('DROP TABLE monnaie');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE sorties_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE monnaie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE monnaie (id INT NOT NULL, client_fidele_id INT NOT NULL, montant INT NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_b3a6e2e630ef05f ON monnaie (client_fidele_id)');
        $this->addSql('COMMENT ON COLUMN monnaie.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE monnaie ADD CONSTRAINT fk_b3a6e2e630ef05f FOREIGN KEY (client_fidele_id) REFERENCES fidelisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sorties DROP CONSTRAINT FK_488163E8CD11A2CF');
        $this->addSql('ALTER TABLE sorties DROP CONSTRAINT FK_488163E8642B8210');
        $this->addSql('DROP TABLE sorties');
    }
}
