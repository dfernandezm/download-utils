<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150523205710 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE torrent_search_result (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, magnet_link VARCHAR(300) DEFAULT NULL, date DATETIME DEFAULT NULL, date_found DATETIME DEFAULT NULL, state VARCHAR(300) DEFAULT NULL, content_type VARCHAR(300) DEFAULT NULL, origin VARCHAR(255) DEFAULT NULL, torrent_file_link VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, seeds INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
      
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP TABLE torrent_search_result');
    }
}
