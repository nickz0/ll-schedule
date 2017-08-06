<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170806104353 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE act ADD spotify_top_tracks LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', DROP spotify_last_album_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE act ADD spotify_last_album_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP spotify_top_tracks');
    }
}
