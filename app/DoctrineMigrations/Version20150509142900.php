<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150509142900 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql("DELETE FROM mediacenter_settings");
        $this->addSql("DELETE FROM transmission_settings");
        $this->addSql("INSERT INTO mediacenter_settings (id,description,base_downloads_path,base_library_path,is_remote,xbmc_host_or_ip," .
                      "processing_temp_path,transcode_temp_path) VALUES (1,'Basic settings','/mediacenter/torrents','/mediacenter'," .
                      "0,'localhost','/mediacenter/temp','/mediacenter/transcode')");

        $this->addSql("INSERT INTO transmission_settings (id,description,ip_or_host,port,username,password,base_downloads_dir) VALUES (" .
                      "1,'Local transmission','localhost',9091,'transmission','ZVCvrasp','/mediacenter/torrents')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    }
}
