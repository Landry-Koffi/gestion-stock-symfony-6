<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230709150415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE monnaie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE monnaie (id INT NOT NULL, client_fidele_id INT NOT NULL, montant INT NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B3A6E2E630EF05F ON monnaie (client_fidele_id)');
        $this->addSql('COMMENT ON COLUMN monnaie.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE monnaie ADD CONSTRAINT FK_B3A6E2E630EF05F FOREIGN KEY (client_fidele_id) REFERENCES fidelisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE monnaie_id_seq CASCADE');
        $this->addSql('ALTER TABLE monnaie DROP CONSTRAINT FK_B3A6E2E630EF05F');
        $this->addSql('DROP TABLE monnaie');
    }
}
