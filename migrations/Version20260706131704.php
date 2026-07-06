<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260706131704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE riven_attribute_external (id INT IDENTITY NOT NULL, name NVARCHAR(255) NOT NULL, slug NVARCHAR(255) NOT NULL, exclusive_to VARCHAR(MAX) NOT NULL, positive_is_negative BIT, positive_only BIT, negative_only BIT, unit NVARCHAR(255) NOT NULL, external_id NVARCHAR(255) NOT NULL, created_at DATETIME2 NOT NULL, updated_at DATETIME2 NOT NULL , PRIMARY KEY (id))');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:array)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'riven_attribute_external\', N\'COLUMN\', \'exclusive_to\'');
        $this->addSql('CREATE TABLE riven_weapons_external (id INT IDENTITY NOT NULL, name NVARCHAR(255) NOT NULL, slug NVARCHAR(255) NOT NULL, groups VARCHAR(MAX) NOT NULL, type NVARCHAR(255) NOT NULL, wiki_link NVARCHAR(1000), icon NVARCHAR(1000), external_id NVARCHAR(255) NOT NULL, created_at DATETIME2 NOT NULL, updated_at DATETIME2 NOT NULL , PRIMARY KEY (id))');
        $this->addSql('EXEC sp_addextendedproperty N\'MS_Description\', N\'(DC2Type:array)\', N\'SCHEMA\', \'dbo\', N\'TABLE\', \'riven_weapons_external\', N\'COLUMN\', \'groups\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE riven_attribute_external');
        $this->addSql('DROP TABLE riven_weapons_external');
    }
}
