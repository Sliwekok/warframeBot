<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230730102526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
if object_id('dbo.platform', 'U') is not null begin
    CREATE TABLE dbo.platform
        (
            id int IDENTITY(1,1) PRIMARY KEY,
            name nvarchar(10) NOT NULL
        )  ON [PRIMARY]
    ALTER TABLE dbo.platform SET (LOCK_ESCALATION = TABLE)
end
SQL
        );

        $this->addSql(<<<SQL
if not exists (select 1 from platform where name = 'pc') begin
    insert into platform (name)
    values ('pc')
end
                                                         
if not exists (select 1 from platform where name = 'xbox') begin
    insert into platform (name)
    values ('xbox')
end
                                                         
if not exists (select 1 from platform where name = 'ps') begin
    insert into platform (name)
    values ('ps')
end
                                                         
if not exists (select 1 from platform where name = 'switch') begin
    insert into platform (name)
    values ('switch')
end
SQL
        );

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
