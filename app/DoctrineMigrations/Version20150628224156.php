<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150628224156 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE automated_search_config (id INT AUTO_INCREMENT NOT NULL, contentType VARCHAR(100) NOT NULL, contentTitle VARCHAR(100) NOT NULL, preferredQuality VARCHAR(200) NOT NULL, preferredFormat VARCHAR(200) NOT NULL, subtitles_enabled TINYINT(1) DEFAULT NULL, contentLanguage VARCHAR(100) NOT NULL, download_starts_automatically TINYINT(1) DEFAULT NULL, referenceDate DATETIME NOT NULL, lastCheckedDate DATETIME DEFAULT NULL, lastDownloadedDate DATETIME DEFAULT NULL, subtitlesLanguage VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP TABLE automated_search_config');
    }
}
