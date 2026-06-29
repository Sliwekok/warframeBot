<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260625161353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE TABLE items_tradable (
    id INT IDENTITY(1,1) NOT NULL,
    parent_id INT NULL,
    external_id NVARCHAR(100) NOT NULL,
    name NVARCHAR(255) NOT NULL,
    slug NVARCHAR(255) NOT NULL,
    vaulted BIT NOT NULL,
    tradable BIT NOT NULL,
    tags NVARCHAR(MAX) NOT NULL, -- JSON stored as text
    created_at DATETIME2 NOT NULL,
    updated_at DATETIME2 NOT NULL,

    CONSTRAINT PK_items_tradable PRIMARY KEY (id),
    CONSTRAINT UQ_items_tradable_external_id UNIQUE (external_id),
    CONSTRAINT UQ_items_tradable_slug UNIQUE (slug)
);

CREATE INDEX IDX_items_tradable_parent
ON items_tradable(parent_id);

SQL
        );

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
