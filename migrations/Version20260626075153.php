<?php

    declare(strict_types=1);

    namespace DoctrineMigrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    /**
     * Auto-generated Migration: Please modify to your needs!
     */
    final class Version20260626075153 extends AbstractMigration
    {
        public function getDescription(): string
        {
            return 'Refactor item table: remove old columns, add relation to items_tradable and metadata columns';
        }

        public function up(Schema $schema): void
        {
            // Drop old columns
            $this->addSql('ALTER TABLE item DROP COLUMN name_curl');
            $this->addSql('ALTER TABLE item DROP COLUMN name');
            $this->addSql('ALTER TABLE item DROP COLUMN wiki_url');
            $this->addSql('ALTER TABLE item DROP COLUMN type');
            $this->addSql('ALTER TABLE item DROP COLUMN image_url');

            // Add new columns
            $this->addSql('ALTER TABLE item ADD item_id INT NULL');
            $this->addSql("ALTER TABLE item ADD type NVARCHAR(255) NOT NULL DEFAULT ''");
            $this->addSql("ALTER TABLE item ADD status NVARCHAR(255) NOT NULL DEFAULT ''");
            $this->addSql('ALTER TABLE item ADD created_at DATETIME2 NULL');
            $this->addSql('ALTER TABLE item ADD updated_at DATETIME2 NULL');

            // Index
            $this->addSql('CREATE INDEX IDX_1F1B251E126F525E ON item (item_id)');

            // Foreign key
            $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E126F525E FOREIGN KEY (item_id) REFERENCES items_tradable (id)');

            $this->addSql(<<<SQL
create or alter view items_on_watchlist as
select i.id, i.login_id, it.name, i.price, it.wiki_link, it.icon, p.name as platform_name, i.platform_id
from item i
 inner join platform p on i.platform_id = p.id
inner join items_tradable it on it.id = i.item_id 

SQL
            );

            $this->addSql(<<<SQL
ALTER TABLE "dbo"."notifications"
	ADD "riven_id" INT NULL;
SQL
            );
        }

        public function down(Schema $schema): void
        {
            // Drop FK
            $this->addSql('ALTER TABLE item DROP CONSTRAINT FK_1F1B251E126F525E');

            // Drop index
            $this->addSql('DROP INDEX IDX_1F1B251E126F525E ON item');

            // Drop new columns
            $this->addSql('ALTER TABLE item DROP COLUMN item_id');
            $this->addSql('ALTER TABLE item DROP COLUMN type');
            $this->addSql('ALTER TABLE item DROP COLUMN status');
            $this->addSql('ALTER TABLE item DROP COLUMN created_at');
            $this->addSql('ALTER TABLE item DROP COLUMN updated_at');

            // Restore old columns
            $this->addSql("ALTER TABLE item ADD name_curl NVARCHAR(255) NOT NULL DEFAULT ''");
            $this->addSql("ALTER TABLE item ADD name NVARCHAR(255) NOT NULL DEFAULT ''");
            $this->addSql('ALTER TABLE item ADD wiki_url NVARCHAR(255) NULL');
            $this->addSql("ALTER TABLE item ADD type NVARCHAR(255) NOT NULL DEFAULT ''");
            $this->addSql('ALTER TABLE item ADD image_url NVARCHAR(255) NULL');
        }
    }
