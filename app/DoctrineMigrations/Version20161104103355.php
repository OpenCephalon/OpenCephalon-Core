<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161104103355 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE source_stream_to_out_stream_condition_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
            $this->addSql('CREATE TABLE source_stream_to_out_stream_condition (id INT NOT NULL, source_stream_id INT NOT NULL, out_stream_id INT NOT NULL, public_id VARCHAR(250) NOT NULL, contains VARCHAR(250) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3419DBDAB873D5F0 ON source_stream_to_out_stream_condition (source_stream_id)');
        $this->addSql('CREATE INDEX IDX_3419DBDAAA1E1129 ON source_stream_to_out_stream_condition (out_stream_id)');
        $this->addSql('CREATE UNIQUE INDEX source_stream_to_out_stream_condition_public_id ON source_stream_to_out_stream_condition (source_stream_id, out_stream_id, public_id)');
        $this->addSql('ALTER TABLE source_stream_to_out_stream_condition ADD CONSTRAINT FK_3419DBDAB873D5F0 FOREIGN KEY (source_stream_id) REFERENCES source_stream (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE source_stream_to_out_stream_condition ADD CONSTRAINT FK_3419DBDAAA1E1129 FOREIGN KEY (out_stream_id) REFERENCES out_stream (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE source_stream_to_out_stream_condition_id_seq CASCADE');
        $this->addSql('DROP TABLE source_stream_to_out_stream_condition');
    }
}
