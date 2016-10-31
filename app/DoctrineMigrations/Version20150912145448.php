<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150912145448 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE search_website CHANGE search_url search_url VARCHAR(200) DEFAULT NULL, CHANGE torrent_main_results_filter_string torrent_main_results_filter_string VARCHAR(200) DEFAULT NULL, CHANGE torrent_titles_filter_string torrent_titles_filter_string VARCHAR(200) DEFAULT NULL, CHANGE torrent_files_filter_string torrent_files_filter_string VARCHAR(200) DEFAULT NULL, CHANGE torrent_magnet_links_filter_string torrent_magnet_links_filter_string VARCHAR(200) DEFAULT NULL, CHANGE torrent_attribute_filter_string torrent_attribute_filter_string VARCHAR(200) DEFAULT NULL, CHANGE name site_name VARCHAR(200) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE search_website CHANGE search_url search_url VARCHAR(200) NOT NULL COLLATE utf8_unicode_ci, CHANGE torrent_main_results_filter_string torrent_main_results_filter_string VARCHAR(200) NOT NULL COLLATE utf8_unicode_ci, CHANGE torrent_titles_filter_string torrent_titles_filter_string VARCHAR(200) NOT NULL COLLATE utf8_unicode_ci, CHANGE torrent_files_filter_string torrent_files_filter_string VARCHAR(200) NOT NULL COLLATE utf8_unicode_ci, CHANGE torrent_magnet_links_filter_string torrent_magnet_links_filter_string VARCHAR(200) NOT NULL COLLATE utf8_unicode_ci, CHANGE torrent_attribute_filter_string torrent_attribute_filter_string VARCHAR(200) NOT NULL COLLATE utf8_unicode_ci, CHANGE site_name name VARCHAR(200) NOT NULL COLLATE utf8_unicode_ci');
    }
}
