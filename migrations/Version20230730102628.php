<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230730102628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create system login table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE TABLE dbo.login(
	id int IDENTITY(1,1) PRIMARY KEY,
	username nvarchar(50) NOT NULL,
	email nvarchar(50) NOT NULL,
	password nvarchar(50) NOT NULL,
	is_active bit NOT NULL DEFAULT  1,
	modification_date datetime NOT NULL DEFAULT GETDATE(),
	platform_id int NOT NULL DEFAULT 1
	)  ON [PRIMARY]

ALTER TABLE dbo.login ADD CONSTRAINT
	FK_login_platform_id FOREIGN KEY
	(
	    platform_id
	) REFERENCES dbo.platform
	(
	id
	) ON UPDATE  NO ACTION 
	 ON DELETE  NO ACTION 
SQL
        );

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
