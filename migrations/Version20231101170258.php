<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231101170258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
if object_id('dbo.notifications', 'U') is null begin
    CREATE TABLE dbo.notifications
        (
            id int IDENTITY(1,1) PRIMARY KEY,
            is_read smallint,
            login_id int,
            item_id int, 
            seller nvarchar(255),
            price int,
            date datetime2
        )  ON [PRIMARY]
end
if not exists (
    SELECT
        1
    FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS 
    WHERE CONSTRAINT_NAME ='FK_notifications_login_id'     
    ) begin
    ALTER TABLE dbo.notifications ADD CONSTRAINT
        FK_notifications_login_id FOREIGN KEY
        (login_id) REFERENCES dbo.login (id)
            ON UPDATE  NO ACTION 
            ON DELETE  NO ACTION 
end

if not exists (
    SELECT
        1
    FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS 
    WHERE CONSTRAINT_NAME ='FK_notifications_item_id'     
    ) begin
    ALTER TABLE dbo.notifications ADD CONSTRAINT
        FK_notifications_item_id FOREIGN KEY
        (item_id) REFERENCES dbo.item (id)
            ON UPDATE  NO ACTION 
            ON DELETE  NO ACTION 
end
ALTER TABLE dbo.notifications SET (LOCK_ESCALATION = TABLE)
SQL
        );

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
