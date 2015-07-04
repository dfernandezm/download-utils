<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150704004107 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE torrent ADD automated_search_config_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE torrent ADD CONSTRAINT FK_DCC7B7B63AD86DE4 FOREIGN KEY (automated_search_config_id) REFERENCES automated_search_config (id)');
        $this->addSql('CREATE INDEX IDX_DCC7B7B63AD86DE4 ON torrent (automated_search_config_id)');
        $this->addSql('ALTER TABLE feed DROP FOREIGN KEY FK_feed_automated_search');
        $this->addSql('DROP INDEX idx_automated_search ON feed');
        $this->addSql('CREATE INDEX IDX_234044AB3AD86DE4 ON feed (automated_search_config_id)');
        $this->addSql('ALTER TABLE feed ADD CONSTRAINT FK_feed_automated_search FOREIGN KEY (automated_search_config_id) REFERENCES automated_search_config (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feed DROP FOREIGN KEY FK_234044AB3AD86DE4');
        $this->addSql('DROP INDEX idx_234044ab3ad86de4 ON feed');
        $this->addSql('CREATE INDEX IDX_automated_search ON feed (automated_search_config_id)');
        $this->addSql('ALTER TABLE feed ADD CONSTRAINT FK_234044AB3AD86DE4 FOREIGN KEY (automated_search_config_id) REFERENCES automated_search_config (id)');
        $this->addSql('ALTER TABLE torrent DROP FOREIGN KEY FK_DCC7B7B63AD86DE4');
        $this->addSql('DROP INDEX IDX_DCC7B7B63AD86DE4 ON torrent');
        $this->addSql('ALTER TABLE torrent DROP automated_search_config_id');
    }
}
