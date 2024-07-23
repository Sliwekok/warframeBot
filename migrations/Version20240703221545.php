<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240703221545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
if object_id('dbo.riven', 'U') is null begin
        CREATE TABLE dbo.riven
        (
            id int IDENTITY(1,1) PRIMARY KEY,
            login_id int NOT NULL,
            weapon_name nvarchar(255) NOT NULL,
            attr_pos_1 nvarchar(255) NULL,
            attr_pos_2 nvarchar(255) NULL,
            attr_pos_3 nvarchar(255) NULL,
            attr_neg nvarchar(255) NULL,
            image_url NVARCHAR(255) NOT NULL,
            wiki_url NVARCHAR(255) NOT NULL,
            name_curl NVARCHAR(255) NOT NULL,
            price int NOT NULL
        )  ON [PRIMARY];
        ALTER TABLE dbo.riven SET (LOCK_ESCALATION = TABLE);
    end

    if not exists (
        SELECT
            1
        FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
        WHERE CONSTRAINT_NAME ='FK_riven_login_id'
    ) begin
        ALTER TABLE dbo.riven ADD CONSTRAINT
            FK_riven_login_id FOREIGN KEY
                (login_id) REFERENCES dbo.login
                    (id) ON UPDATE  NO ACTION
                ON DELETE  NO ACTION
    end
    ALTER TABLE dbo.riven SET (LOCK_ESCALATION = TABLE)
SQL);
    }

    public function down(Schema $schema): void
    {

    }
}
