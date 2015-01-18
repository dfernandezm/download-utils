<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150118171020 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE mediacenter_settings (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(200) DEFAULT NULL, base_downloads_path VARCHAR(50) NOT NULL, base_library_path VARCHAR(50) NOT NULL, is_remote TINYINT(1) DEFAULT NULL, xbmc_host_or_ip VARCHAR(30) DEFAULT NULL, processing_temp_path VARCHAR(50) NOT NULL, transcode_temp_path VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transmission_settings (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(200) DEFAULT NULL, ip_or_host VARCHAR(30) DEFAULT NULL, port INT DEFAULT NULL, username VARCHAR(100) DEFAULT NULL, password VARCHAR(100) DEFAULT NULL, base_downloads_dir VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP TABLE mediacenter_settings');
        $this->addSql('DROP TABLE transmission_settings');
    }
}
