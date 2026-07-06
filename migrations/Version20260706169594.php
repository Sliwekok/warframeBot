<?php

    declare(strict_types=1);

    namespace DoctrineMigrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    /**
     * Auto-generated Migration: Please modify to your needs!
     */
    final class Version20260706169594 extends AbstractMigration
    {
        public function up(Schema $schema): void
        {
            $this->addSql('ALTER TABLE riven ADD created_at DATETIME NULL');
            $this->addSql('ALTER TABLE riven ADD updated_at DATETIME NULL');
            $this->addSql('ALTER TABLE riven_attribute ADD created_at DATETIME2 NULL');
            $this->addSql('ALTER TABLE riven_attribute ADD updated_at DATETIME2 NULL');
            $this->addSql('ALTER TABLE riven ADD is_read int NOT NULL DEFAULT 0');
        }

        public function down(Schema $schema): void
        {
           // Drop new columns
            $this->addSql('ALTER TABLE riven DROP COLUMN created_at');
            $this->addSql('ALTER TABLE riven DROP COLUMN updated_at');
            $this->addSql('ALTER TABLE riven_attribute DROP COLUMN created_at');
            $this->addSql('ALTER TABLE riven_attribute DROP COLUMN updated_at');
            $this->addSql('ALTER TABLE riven DROP COLUMN is_read');

        }
    }
