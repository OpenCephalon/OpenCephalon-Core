<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170117105448 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE source_stream ADD user_agent TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE source_stream ALTER url TYPE TEXT');
        $this->addSql('ALTER TABLE source_stream ALTER url DROP DEFAULT');
        $this->addSql('ALTER TABLE source_stream ALTER url TYPE TEXT');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE source_stream DROP user_agent');
        $this->addSql('ALTER TABLE source_stream ALTER url TYPE VARCHAR(250)');
        $this->addSql('ALTER TABLE source_stream ALTER url DROP DEFAULT');
    }
}
