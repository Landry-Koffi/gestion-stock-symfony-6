<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230712141747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE monnaie_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE lot_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE lot (id INT NOT NULL, produit_id INT NOT NULL, commande_fournisseur_id INT NOT NULL, date_peremption_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, stock INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B81291BF347EFB ON lot (produit_id)');
        $this->addSql('CREATE INDEX IDX_B81291BA2577AA5 ON lot (commande_fournisseur_id)');
        $this->addSql('COMMENT ON COLUMN lot.date_peremption_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN lot.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BA2577AA5 FOREIGN KEY (commande_fournisseur_id) REFERENCES commande_fournisseur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE monnaie DROP CONSTRAINT fk_b3a6e2e630ef05f');
        $this->addSql('DROP TABLE monnaie');
        $this->addSql('ALTER TABLE produit_commande_fournisseur ADD date_peremption_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN produit_commande_fournisseur.date_peremption_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE lot_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE monnaie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE monnaie (id INT NOT NULL, client_fidele_id INT NOT NULL, montant INT NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_b3a6e2e630ef05f ON monnaie (client_fidele_id)');
        $this->addSql('COMMENT ON COLUMN monnaie.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE monnaie ADD CONSTRAINT fk_b3a6e2e630ef05f FOREIGN KEY (client_fidele_id) REFERENCES fidelisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lot DROP CONSTRAINT FK_B81291BF347EFB');
        $this->addSql('ALTER TABLE lot DROP CONSTRAINT FK_B81291BA2577AA5');
        $this->addSql('DROP TABLE lot');
        $this->addSql('ALTER TABLE produit_commande_fournisseur DROP date_peremption_at');
    }
}
