<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230708185354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE client_coupons_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE client_coupons (id INT NOT NULL, client_id INT NOT NULL, coupon_id INT NOT NULL, montant_utilise INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A759556519EB6921 ON client_coupons (client_id)');
        $this->addSql('CREATE INDEX IDX_A759556566C5951B ON client_coupons (coupon_id)');
        $this->addSql('COMMENT ON COLUMN client_coupons.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN client_coupons.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE client_coupons ADD CONSTRAINT FK_A759556519EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client_coupons ADD CONSTRAINT FK_A759556566C5951B FOREIGN KEY (coupon_id) REFERENCES coupons (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE client_coupons_id_seq CASCADE');
        $this->addSql('ALTER TABLE client_coupons DROP CONSTRAINT FK_A759556519EB6921');
        $this->addSql('ALTER TABLE client_coupons DROP CONSTRAINT FK_A759556566C5951B');
        $this->addSql('DROP TABLE client_coupons');
    }
}
