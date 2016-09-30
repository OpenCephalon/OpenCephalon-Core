<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160930161300 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE out_stream_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE project_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE source_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE source_stream_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_account_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE item (id INT NOT NULL, project_id INT NOT NULL, source_stream_id INT NOT NULL, public_id VARCHAR(250) NOT NULL, title TEXT DEFAULT NULL, description TEXT DEFAULT NULL, url TEXT DEFAULT NULL, published_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1F1B251E166D1F9C ON item (project_id)');
        $this->addSql('CREATE INDEX IDX_1F1B251EB873D5F0 ON item (source_stream_id)');
        $this->addSql('CREATE UNIQUE INDEX item_public_id ON item (project_id, public_id)');
        $this->addSql('CREATE TABLE item_id_rss (item_id INT NOT NULL, source_id INT NOT NULL, guid TEXT DEFAULT NULL, PRIMARY KEY(item_id))');
        $this->addSql('CREATE INDEX IDX_7D77F20A953C1C61 ON item_id_rss (source_id)');
        $this->addSql('CREATE UNIQUE INDEX item_id_rss_guid ON item_id_rss (source_id, guid)');
        $this->addSql('CREATE TABLE out_stream (id INT NOT NULL, project_id INT NOT NULL, public_id VARCHAR(250) NOT NULL, title VARCHAR(250) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C5FEA89A166D1F9C ON out_stream (project_id)');
        $this->addSql('CREATE UNIQUE INDEX out_stream_public_id ON out_stream (project_id, public_id)');
        $this->addSql('CREATE TABLE out_stream_has_item (out_stream_id INT NOT NULL, item_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(out_stream_id, item_id))');
        $this->addSql('CREATE INDEX IDX_3FF0413BAA1E1129 ON out_stream_has_item (out_stream_id)');
        $this->addSql('CREATE INDEX IDX_3FF0413B126F525E ON out_stream_has_item (item_id)');
        $this->addSql('CREATE TABLE project (id INT NOT NULL, owner_id INT NOT NULL, public_id VARCHAR(250) NOT NULL, title VARCHAR(250) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2FB3D0EEB5B48B91 ON project (public_id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE7E3C61F9 ON project (owner_id)');
        $this->addSql('CREATE TABLE source (id INT NOT NULL, project_id INT NOT NULL, public_id VARCHAR(250) NOT NULL, title VARCHAR(250) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5F8A7F73166D1F9C ON source (project_id)');
        $this->addSql('CREATE UNIQUE INDEX source_public_id ON source (project_id, public_id)');
        $this->addSql('CREATE TABLE source_stream (id INT NOT NULL, source_id INT NOT NULL, public_id VARCHAR(250) NOT NULL, url VARCHAR(250) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_46169BFA953C1C61 ON source_stream (source_id)');
        $this->addSql('CREATE UNIQUE INDEX source_stream_public_id ON source_stream (source_id, public_id)');
        $this->addSql('CREATE TABLE source_stream_to_out_stream (source_stream_id INT NOT NULL, out_stream_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(source_stream_id, out_stream_id))');
        $this->addSql('CREATE INDEX IDX_D8CA2B2BB873D5F0 ON source_stream_to_out_stream (source_stream_id)');
        $this->addSql('CREATE INDEX IDX_D8CA2B2BAA1E1129 ON source_stream_to_out_stream (out_stream_id)');
        $this->addSql('CREATE TABLE user_account (id INT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, locked BOOLEAN NOT NULL, expired BOOLEAN NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, credentials_expired BOOLEAN NOT NULL, credentials_expire_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_253B48AE92FC23A8 ON user_account (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_253B48AEA0D96FBF ON user_account (email_canonical)');
        $this->addSql('COMMENT ON COLUMN user_account.roles IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EB873D5F0 FOREIGN KEY (source_stream_id) REFERENCES source_stream (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_id_rss ADD CONSTRAINT FK_7D77F20A126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_id_rss ADD CONSTRAINT FK_7D77F20A953C1C61 FOREIGN KEY (source_id) REFERENCES source (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE out_stream ADD CONSTRAINT FK_C5FEA89A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE out_stream_has_item ADD CONSTRAINT FK_3FF0413BAA1E1129 FOREIGN KEY (out_stream_id) REFERENCES out_stream (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE out_stream_has_item ADD CONSTRAINT FK_3FF0413B126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user_account (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE source ADD CONSTRAINT FK_5F8A7F73166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE source_stream ADD CONSTRAINT FK_46169BFA953C1C61 FOREIGN KEY (source_id) REFERENCES source (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE source_stream_to_out_stream ADD CONSTRAINT FK_D8CA2B2BB873D5F0 FOREIGN KEY (source_stream_id) REFERENCES source_stream (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE source_stream_to_out_stream ADD CONSTRAINT FK_D8CA2B2BAA1E1129 FOREIGN KEY (out_stream_id) REFERENCES out_stream (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE item_id_rss DROP CONSTRAINT FK_7D77F20A126F525E');
        $this->addSql('ALTER TABLE out_stream_has_item DROP CONSTRAINT FK_3FF0413B126F525E');
        $this->addSql('ALTER TABLE out_stream_has_item DROP CONSTRAINT FK_3FF0413BAA1E1129');
        $this->addSql('ALTER TABLE source_stream_to_out_stream DROP CONSTRAINT FK_D8CA2B2BAA1E1129');
        $this->addSql('ALTER TABLE item DROP CONSTRAINT FK_1F1B251E166D1F9C');
        $this->addSql('ALTER TABLE out_stream DROP CONSTRAINT FK_C5FEA89A166D1F9C');
        $this->addSql('ALTER TABLE source DROP CONSTRAINT FK_5F8A7F73166D1F9C');
        $this->addSql('ALTER TABLE item_id_rss DROP CONSTRAINT FK_7D77F20A953C1C61');
        $this->addSql('ALTER TABLE source_stream DROP CONSTRAINT FK_46169BFA953C1C61');
        $this->addSql('ALTER TABLE item DROP CONSTRAINT FK_1F1B251EB873D5F0');
        $this->addSql('ALTER TABLE source_stream_to_out_stream DROP CONSTRAINT FK_D8CA2B2BB873D5F0');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT FK_2FB3D0EE7E3C61F9');
        $this->addSql('DROP SEQUENCE item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE out_stream_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE project_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE source_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE source_stream_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_account_id_seq CASCADE');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_id_rss');
        $this->addSql('DROP TABLE out_stream');
        $this->addSql('DROP TABLE out_stream_has_item');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE source');
        $this->addSql('DROP TABLE source_stream');
        $this->addSql('DROP TABLE source_stream_to_out_stream');
        $this->addSql('DROP TABLE user_account');
    }
}
