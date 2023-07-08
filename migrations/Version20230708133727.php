<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230708133727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE feed_back_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE feed_back (id INT NOT NULL, client_id INT NOT NULL, title VARCHAR(255) NOT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_ED592A6019EB6921 ON feed_back (client_id)');
        $this->addSql('COMMENT ON COLUMN feed_back.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE feed_back ADD CONSTRAINT FK_ED592A6019EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455F037AB0F ON client (tel)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE feed_back_id_seq CASCADE');
        $this->addSql('ALTER TABLE feed_back DROP CONSTRAINT FK_ED592A6019EB6921');
        $this->addSql('DROP TABLE feed_back');
        $this->addSql('DROP INDEX UNIQ_C7440455F037AB0F');
    }
}
