<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141118231121 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE torrent (id INT AUTO_INCREMENT NOT NULL, guid VARCHAR(100) NOT NULL, title VARCHAR(100) NOT NULL, hash VARCHAR(100) DEFAULT NULL, magnet_link VARCHAR(300) NOT NULL, date DATETIME DEFAULT NULL, asset VARCHAR(300) NOT NULL, state VARCHAR(300) DEFAULT NULL, content_type VARCHAR(300) DEFAULT NULL, file_path VARCHAR(300) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE feed CHANGE description description VARCHAR(200) DEFAULT NULL, CHANGE url url VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP TABLE torrent');
        $this->addSql('ALTER TABLE feed CHANGE url url VARCHAR(200) NOT NULL, CHANGE description description VARCHAR(200) NOT NULL');
    }
}
