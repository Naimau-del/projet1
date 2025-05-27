<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250527124644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__artiste AS SELECT id, nom, thumbnail_url FROM artiste
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE artiste
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE artiste (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, thumbnail_url VARCHAR(255) DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO artiste (id, nom, thumbnail_url) SELECT id, nom, thumbnail_url FROM __temp__artiste
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__artiste
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE artiste ADD COLUMN favorite BOOLEAN DEFAULT 0 NOT NULL
        SQL);
    }
}
