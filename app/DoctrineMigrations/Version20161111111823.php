<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161111111823 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE item_id_atom (item_id INT NOT NULL, source_id INT NOT NULL, guid TEXT DEFAULT NULL, PRIMARY KEY(item_id))');
        $this->addSql('CREATE INDEX IDX_A03DDF2D953C1C61 ON item_id_atom (source_id)');
        $this->addSql('CREATE UNIQUE INDEX item_id_atom_guid ON item_id_atom (source_id, guid)');
        $this->addSql('ALTER TABLE item_id_atom ADD CONSTRAINT FK_A03DDF2D126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_id_atom ADD CONSTRAINT FK_A03DDF2D953C1C61 FOREIGN KEY (source_id) REFERENCES source (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE item_id_atom');
    }
}
