<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170112173537 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE out_stream_to_twitter_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE out_stream_to_twitter (id INT NOT NULL, out_stream_id INT NOT NULL, public_id VARCHAR(250) NOT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, access_token VARCHAR(250) NOT NULL, access_token_secret VARCHAR(250) NOT NULL, twitter_id VARCHAR(250) NOT NULL, twitter_username VARCHAR(250) NOT NULL, content_prefix VARCHAR(250) NOT NULL, mins_after_tweet_before_next_tweet SMALLINT NOT NULL, mon_post_after SMALLINT NOT NULL, mon_post_before SMALLINT NOT NULL, tue_post_after SMALLINT NOT NULL, tue_post_before SMALLINT NOT NULL, wed_post_after SMALLINT NOT NULL, wed_post_before SMALLINT NOT NULL, thu_post_after SMALLINT NOT NULL, thu_post_before SMALLINT NOT NULL, fri_post_after SMALLINT NOT NULL, fri_post_before SMALLINT NOT NULL, sat_post_after SMALLINT NOT NULL, sat_post_before SMALLINT NOT NULL, sun_post_after SMALLINT NOT NULL, sun_post_before SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_16FC0495AA1E1129 ON out_stream_to_twitter (out_stream_id)');
        $this->addSql('CREATE UNIQUE INDEX out_stream_to_twitter_public_id ON out_stream_to_twitter (out_stream_id, public_id)');
        $this->addSql('CREATE TABLE out_stream_to_twitter_has_item (item_id INT NOT NULL, out_stream_to_twitter_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, tweeted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, tweet_id VARCHAR(250) DEFAULT NULL, PRIMARY KEY(item_id, out_stream_to_twitter_id))');
        $this->addSql('CREATE INDEX IDX_1E9E0381126F525E ON out_stream_to_twitter_has_item (item_id)');
        $this->addSql('CREATE INDEX IDX_1E9E03814DFEC40E ON out_stream_to_twitter_has_item (out_stream_to_twitter_id)');
        $this->addSql('ALTER TABLE out_stream_to_twitter ADD CONSTRAINT FK_16FC0495AA1E1129 FOREIGN KEY (out_stream_id) REFERENCES out_stream (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE out_stream_to_twitter_has_item ADD CONSTRAINT FK_1E9E0381126F525E FOREIGN KEY (item_id) REFERENCES item (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE out_stream_to_twitter_has_item ADD CONSTRAINT FK_1E9E03814DFEC40E FOREIGN KEY (out_stream_to_twitter_id) REFERENCES out_stream_to_twitter (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE out_stream_to_twitter_has_item DROP CONSTRAINT FK_1E9E03814DFEC40E');
        $this->addSql('DROP SEQUENCE out_stream_to_twitter_id_seq CASCADE');
        $this->addSql('DROP TABLE out_stream_to_twitter');
        $this->addSql('DROP TABLE out_stream_to_twitter_has_item');
    }
}
