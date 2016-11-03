<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 */
class Version20161103163742 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');


        // This was added by hand; we don't care about existing data, just new data. So drop table and start again.
        // Migration of existing data is to annoying
        $this->addSql('DROP TABLE out_stream_has_item');

        $this->addSql('CREATE SEQUENCE out_stream_has_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE item_from_source_stream (source_stream_id INT NOT NULL, item_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(source_stream_id, item_id))');
        $this->addSql('CREATE INDEX IDX_5B11FD2BB873D5F0 ON item_from_source_stream (source_stream_id)');
        $this->addSql('CREATE INDEX IDX_5B11FD2B126F525E ON item_from_source_stream (item_id)');
        $this->addSql('CREATE TABLE out_stream_has_item (id INT NOT NULL, out_stream_id INT NOT NULL, item_id INT NOT NULL, added_by_user_id INT DEFAULT NULL, removed_by_user_id INT DEFAULT NULL, added_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, removed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3FF0413BAA1E1129 ON out_stream_has_item (out_stream_id)');
        $this->addSql('CREATE INDEX IDX_3FF0413B126F525E ON out_stream_has_item (item_id)');
        $this->addSql('CREATE INDEX IDX_3FF0413BCA792C6B ON out_stream_has_item (added_by_user_id)');
        $this->addSql('CREATE INDEX IDX_3FF0413BF42461CD ON out_stream_has_item (removed_by_user_id)');
        $this->addSql('ALTER TABLE item_from_source_stream ADD CONSTRAINT FK_5B11FD2BB873D5F0 FOREIGN KEY (source_stream_id) REFERENCES source_stream (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_from_source_stream ADD CONSTRAINT FK_5B11FD2B126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE out_stream_has_item ADD CONSTRAINT FK_3FF0413BAA1E1129 FOREIGN KEY (out_stream_id) REFERENCES out_stream (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE out_stream_has_item ADD CONSTRAINT FK_3FF0413B126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE out_stream_has_item ADD CONSTRAINT FK_3FF0413BCA792C6B FOREIGN KEY (added_by_user_id) REFERENCES user_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE out_stream_has_item ADD CONSTRAINT FK_3FF0413BF42461CD FOREIGN KEY (removed_by_user_id) REFERENCES user_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item DROP CONSTRAINT fk_1f1b251eb873d5f0');
        $this->addSql('DROP INDEX idx_1f1b251eb873d5f0');
        $this->addSql('ALTER TABLE item DROP source_stream_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        throw new \Exception("No Down Migration for this one ");
    }
}
