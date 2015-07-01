<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150701210850 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE automated_search_config ADD content_type VARCHAR(100) NOT NULL, ADD content_title VARCHAR(100) NOT NULL, ADD preferred_quality VARCHAR(200) NOT NULL, ADD preferred_format VARCHAR(200) NOT NULL, ADD content_language VARCHAR(100) NOT NULL, ADD last_checked_date DATETIME DEFAULT NULL, ADD last_download_date DATETIME DEFAULT NULL, DROP contentType, DROP contentTitle, DROP preferredQuality, DROP preferredFormat, DROP contentLanguage, DROP lastCheckedDate, DROP lastDownloadedDate, CHANGE referencedate reference_date DATETIME NOT NULL, CHANGE subtitleslanguage subtitles_languages VARCHAR(100) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE automated_search_config ADD contentType VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, ADD contentTitle VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, ADD preferredQuality VARCHAR(200) NOT NULL COLLATE utf8_unicode_ci, ADD preferredFormat VARCHAR(200) NOT NULL COLLATE utf8_unicode_ci, ADD contentLanguage VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, ADD lastCheckedDate DATETIME DEFAULT NULL, ADD lastDownloadedDate DATETIME DEFAULT NULL, DROP content_type, DROP content_title, DROP preferred_quality, DROP preferred_format, DROP content_language, DROP last_checked_date, DROP last_download_date, CHANGE reference_date referenceDate DATETIME NOT NULL, CHANGE subtitles_languages subtitlesLanguage VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
