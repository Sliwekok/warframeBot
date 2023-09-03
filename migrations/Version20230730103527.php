<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230730103527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
if object_id('dbo.item', 'U') is not null begin
    CREATE TABLE dbo.item
        (
        id int IDENTITY(1,1) PRIMARY KEY,
        login_id int NOT NULL,
        name nvarchar(50) NOT NULL,
        name_curl nvarchar(50),
        price int NOT NULL,
        platform_id int NOT NULL
        )  ON [PRIMARY]
end
if not exists (
    SELECT
        1
    FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS 
    WHERE CONSTRAINT_NAME ='FK_item_platform_id'     
    ) begin
    ALTER TABLE dbo.item ADD CONSTRAINT
        FK_item_platform_id FOREIGN KEY
        (
            platform_id
        ) REFERENCES dbo.platform
        (id) ON UPDATE  NO ACTION 
         ON DELETE  NO ACTION
end
if not exists (
    SELECT
        1
    FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS 
    WHERE CONSTRAINT_NAME ='FK_item_login_id'     
    ) begin
    ALTER TABLE dbo.item ADD CONSTRAINT
        FK_item_login_id FOREIGN KEY
        (login_id) REFERENCES dbo.login
        (id) ON UPDATE  NO ACTION 
         ON DELETE  NO ACTION 
end
ALTER TABLE dbo.item SET (LOCK_ESCALATION = TABLE)
SQL
        );

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
