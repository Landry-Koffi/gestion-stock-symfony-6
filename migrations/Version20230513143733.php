<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230513143733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE commande_client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE commande_fournisseur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE fournisseur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mails_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE moyen_reglement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE produit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE produit_commande_client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE produit_commande_fournisseur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reglement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, code VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, responsable VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, matfiscal VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN client.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN client.update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE commande_client (id INT NOT NULL, client_id INT NOT NULL, numero_commande VARCHAR(255) NOT NULL, date_commande_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, observation TEXT NOT NULL, total_ht INT NOT NULL, total_tva INT NOT NULL, total_ttc INT NOT NULL, etat_traite BOOLEAN NOT NULL, etat_valide BOOLEAN NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, numero_facture VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C510FF8019EB6921 ON commande_client (client_id)');
        $this->addSql('COMMENT ON COLUMN commande_client.date_commande_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN commande_client.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN commande_client.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE commande_fournisseur (id INT NOT NULL, fournisseur_id INT NOT NULL, numero_commande VARCHAR(255) NOT NULL, date_commande_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, observation TEXT NOT NULL, etat_traite BOOLEAN NOT NULL, etat_valide BOOLEAN NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, numero_facture VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7F6F4F53670C757F ON commande_fournisseur (fournisseur_id)');
        $this->addSql('COMMENT ON COLUMN commande_fournisseur.date_commande_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN commande_fournisseur.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN commande_fournisseur.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE fournisseur (id INT NOT NULL, code VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, entreprise VARCHAR(255) NOT NULL, responsable VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, matfiscal VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN fournisseur.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN fournisseur.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE mails (id INT NOT NULL, email_sender VARCHAR(255) NOT NULL, email_receive VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN mails.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE moyen_reglement (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE produit (id INT NOT NULL, category_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, prix_achat INT NOT NULL, prix_vente INT NOT NULL, tva DOUBLE PRECISION NOT NULL, stock INT NOT NULL, image VARCHAR(255) NOT NULL, numero_article VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_29A5EC2712469DE2 ON produit (category_id)');
        $this->addSql('CREATE TABLE produit_commande_client (id INT NOT NULL, produit_id INT NOT NULL, commande_client_id INT NOT NULL, numero_commande VARCHAR(255) NOT NULL, quantite INT NOT NULL, prix_total INT NOT NULL, tva DOUBLE PRECISION NOT NULL, etat_traite BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E51E3F92F347EFB ON produit_commande_client (produit_id)');
        $this->addSql('CREATE INDEX IDX_E51E3F929E73363 ON produit_commande_client (commande_client_id)');
        $this->addSql('COMMENT ON COLUMN produit_commande_client.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN produit_commande_client.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE produit_commande_fournisseur (id INT NOT NULL, produit_id INT NOT NULL, commande_fournisseur_id INT NOT NULL, numero_commande VARCHAR(255) NOT NULL, quantite INT NOT NULL, etat_traite BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8C186C1FF347EFB ON produit_commande_fournisseur (produit_id)');
        $this->addSql('CREATE INDEX IDX_8C186C1FA2577AA5 ON produit_commande_fournisseur (commande_fournisseur_id)');
        $this->addSql('COMMENT ON COLUMN produit_commande_fournisseur.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN produit_commande_fournisseur.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE reglement (id INT NOT NULL, commande_client_id INT NOT NULL, mode_reglement_id INT NOT NULL, montant INT NOT NULL, echeance_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EBE4C14C9E73363 ON reglement (commande_client_id)');
        $this->addSql('CREATE INDEX IDX_EBE4C14CE04B7BE2 ON reglement (mode_reglement_id)');
        $this->addSql('COMMENT ON COLUMN reglement.echeance_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, state BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
        $this->addSql('COMMENT ON COLUMN users.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN users.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE commande_client ADD CONSTRAINT FK_C510FF8019EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commande_fournisseur ADD CONSTRAINT FK_7F6F4F53670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produit_commande_client ADD CONSTRAINT FK_E51E3F92F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produit_commande_client ADD CONSTRAINT FK_E51E3F929E73363 FOREIGN KEY (commande_client_id) REFERENCES commande_client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produit_commande_fournisseur ADD CONSTRAINT FK_8C186C1FF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produit_commande_fournisseur ADD CONSTRAINT FK_8C186C1FA2577AA5 FOREIGN KEY (commande_fournisseur_id) REFERENCES commande_fournisseur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14C9E73363 FOREIGN KEY (commande_client_id) REFERENCES commande_client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14CE04B7BE2 FOREIGN KEY (mode_reglement_id) REFERENCES moyen_reglement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE commande_client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE commande_fournisseur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE fournisseur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mails_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE moyen_reglement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE produit_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE produit_commande_client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE produit_commande_fournisseur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reglement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('ALTER TABLE commande_client DROP CONSTRAINT FK_C510FF8019EB6921');
        $this->addSql('ALTER TABLE commande_fournisseur DROP CONSTRAINT FK_7F6F4F53670C757F');
        $this->addSql('ALTER TABLE produit DROP CONSTRAINT FK_29A5EC2712469DE2');
        $this->addSql('ALTER TABLE produit_commande_client DROP CONSTRAINT FK_E51E3F92F347EFB');
        $this->addSql('ALTER TABLE produit_commande_client DROP CONSTRAINT FK_E51E3F929E73363');
        $this->addSql('ALTER TABLE produit_commande_fournisseur DROP CONSTRAINT FK_8C186C1FF347EFB');
        $this->addSql('ALTER TABLE produit_commande_fournisseur DROP CONSTRAINT FK_8C186C1FA2577AA5');
        $this->addSql('ALTER TABLE reglement DROP CONSTRAINT FK_EBE4C14C9E73363');
        $this->addSql('ALTER TABLE reglement DROP CONSTRAINT FK_EBE4C14CE04B7BE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande_client');
        $this->addSql('DROP TABLE commande_fournisseur');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE mails');
        $this->addSql('DROP TABLE moyen_reglement');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE produit_commande_client');
        $this->addSql('DROP TABLE produit_commande_fournisseur');
        $this->addSql('DROP TABLE reglement');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
