<?php

    declare(strict_types=1);

    namespace DoctrineMigrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    final class Version20260706120000 extends AbstractMigration
    {
        public function getDescription(): string
        {
            return 'Normalize Riven attributes';
        }

        public function up(Schema $schema): void
        {
            $this->abortIf(
                $this->connection->getDatabasePlatform()->getName() !== 'mssql',
                'Migration can only be executed safely on Microsoft SQL Server.'
            );

            // Create table
            $this->addSql("
            CREATE TABLE riven_attribute (
                id INT IDENTITY(1,1) NOT NULL,
                riven_id INT NOT NULL,
                name NVARCHAR(255) NOT NULL,
                value NVARCHAR(255) NOT NULL,
                type NVARCHAR(20) NOT NULL,
                CONSTRAINT PK_riven_attribute PRIMARY KEY (id)
            )
        ");

            $this->addSql("
            CREATE INDEX IDX_riven_attribute_riven
            ON riven_attribute (riven_id)
        ");

            $this->addSql("
            ALTER TABLE riven_attribute
            ADD CONSTRAINT FK_riven_attribute_riven
            FOREIGN KEY (riven_id)
            REFERENCES riven (id)
            ON DELETE CASCADE
        ");

            // Migrate positive attributes
            $this->addSql("
            INSERT INTO riven_attribute (riven_id, name, value, type)
            SELECT id, N'Attr 1', attr_pos_1, N'positive'
            FROM riven
            WHERE attr_pos_1 IS NOT NULL
        ");

            $this->addSql("
            INSERT INTO riven_attribute (riven_id, name, value, type)
            SELECT id, N'Attr 2', attr_pos_2, N'positive'
            FROM riven
            WHERE attr_pos_2 IS NOT NULL
        ");

            $this->addSql("
            INSERT INTO riven_attribute (riven_id, name, value, type)
            SELECT id, N'Attr 3', attr_pos_3, N'positive'
            FROM riven
            WHERE attr_pos_3 IS NOT NULL
        ");

            // Migrate negative attribute
            $this->addSql("
            INSERT INTO riven_attribute (riven_id, name, value, type)
            SELECT id, N'Negative', attr_neg, N'negative'
            FROM riven
            WHERE attr_neg IS NOT NULL
        ");

            // Drop old columns
            $this->addSql("ALTER TABLE riven DROP COLUMN attr_pos_1");
            $this->addSql("ALTER TABLE riven DROP COLUMN attr_pos_2");
            $this->addSql("ALTER TABLE riven DROP COLUMN attr_pos_3");
            $this->addSql("ALTER TABLE riven DROP COLUMN attr_neg");
            $this->addSql("ALTER TABLE riven DROP COLUMN wiki_url");
            $this->addSql("ALTER TABLE riven DROP COLUMN name_curl");
        }

        public function down(Schema $schema): void
        {
            $this->abortIf(
                $this->connection->getDatabasePlatform()->getName() !== 'mssql',
                'Migration can only be executed safely on Microsoft SQL Server.'
            );

            $this->addSql("ALTER TABLE riven ADD attr_pos_1 NVARCHAR(255) NULL");
            $this->addSql("ALTER TABLE riven ADD attr_pos_2 NVARCHAR(255) NULL");
            $this->addSql("ALTER TABLE riven ADD attr_pos_3 NVARCHAR(255) NULL");
            $this->addSql("ALTER TABLE riven ADD attr_neg NVARCHAR(255) NULL");

            // Restore first three positive attributes
            $this->addSql("
            ;WITH PositiveAttributes AS (
                SELECT
                    riven_id,
                    value,
                    ROW_NUMBER() OVER (PARTITION BY riven_id ORDER BY id) AS rn
                FROM riven_attribute
                WHERE type = 'positive'
            )
            UPDATE r
            SET
                attr_pos_1 = p1.value,
                attr_pos_2 = p2.value,
                attr_pos_3 = p3.value
            FROM riven r
            LEFT JOIN PositiveAttributes p1
                ON p1.riven_id = r.id AND p1.rn = 1
            LEFT JOIN PositiveAttributes p2
                ON p2.riven_id = r.id AND p2.rn = 2
            LEFT JOIN PositiveAttributes p3
                ON p3.riven_id = r.id AND p3.rn = 3
        ");

            // Restore first negative attribute
            $this->addSql("
            UPDATE r
            SET attr_neg = ra.value
            FROM riven r
            OUTER APPLY (
                SELECT TOP (1) value
                FROM riven_attribute
                WHERE riven_id = r.id
                  AND type = 'negative'
                ORDER BY id
            ) ra
        ");

            $this->addSql("DROP TABLE riven_attribute");
        }
    }
