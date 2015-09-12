<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150912133452 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE search_website (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(200) NOT NULL, main_url VARCHAR(200) NOT NULL, site_id VARCHAR(10) NOT NULL, torrent_date_type VARCHAR(20) NOT NULL, structure_type VARCHAR(20) NOT NULL, search_url VARCHAR(200) NOT NULL, torrent_main_results_filter_string VARCHAR(200) NOT NULL, torrent_titles_filter_string VARCHAR(200) NOT NULL, torrent_files_filter_string VARCHAR(200) NOT NULL, torrent_magnet_links_filter_string VARCHAR(200) NOT NULL, torrent_attribute_filter_string VARCHAR(200) NOT NULL, main_language VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE torrent CHANGE torrentName torrentName VARCHAR(250) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE search_website');
        $this->addSql('ALTER TABLE torrent CHANGE torrentName torrentName VARCHAR(200) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
