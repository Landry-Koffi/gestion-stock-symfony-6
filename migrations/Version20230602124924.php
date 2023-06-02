<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230602124924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_client ADD moyen_paiement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_client ADD CONSTRAINT FK_C510FF809C7E259C FOREIGN KEY (moyen_paiement_id) REFERENCES moyen_reglement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C510FF809C7E259C ON commande_client (moyen_paiement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE commande_client DROP CONSTRAINT FK_C510FF809C7E259C');
        $this->addSql('DROP INDEX IDX_C510FF809C7E259C');
        $this->addSql('ALTER TABLE commande_client DROP moyen_paiement_id');
    }
}
