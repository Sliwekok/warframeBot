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
CREATE TABLE dbo.platform
	(
	id int IDENTITY(1,1) PRIMARY KEY,
	name nvarchar(10) NOT NULL
	)  ON [PRIMARY]
ALTER TABLE dbo.platform SET (LOCK_ESCALATION = TABLE)
SQL
        );

        $this->addSql(<<<SQL
insert into platform (name)
values ('pc'),
       ('xbox'),
       ('ps'),
       ('switch')
SQL
        );

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
