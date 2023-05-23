<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523160846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_client ALTER observation DROP NOT NULL');
        $this->addSql('ALTER TABLE commande_client ALTER total_tva DROP NOT NULL');
        $this->addSql('ALTER TABLE produit_commande_client DROP tva');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE commande_client ALTER observation SET NOT NULL');
        $this->addSql('ALTER TABLE commande_client ALTER total_tva SET NOT NULL');
        $this->addSql('ALTER TABLE produit_commande_client ADD tva DOUBLE PRECISION NOT NULL');
    }
}
