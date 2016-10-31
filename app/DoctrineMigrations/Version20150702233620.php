<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150702233620 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feed ADD automated_search_config_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE feed ADD CONSTRAINT FK_feed_automated_search FOREIGN KEY (automated_search_config_id) REFERENCES automated_search_config (id)');
        $this->addSql('CREATE INDEX IDX_automated_search ON feed (automated_search_config_id)');
        $this->addSql('ALTER TABLE automated_search_config CHANGE active active TINYINT(1) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE automated_search_config CHANGE active active TINYINT(1) DEFAULT \'1\' NOT NULL');
        $this->addSql('ALTER TABLE feed DROP FOREIGN KEY FK_feed_automated_search');
        $this->addSql('DROP INDEX IDX_automated_search ON feed');
        $this->addSql('ALTER TABLE feed DROP automated_search_config_id');
    }
}
