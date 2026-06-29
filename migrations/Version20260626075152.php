<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260626075152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {

        $this->addSql('ALTER TABLE items_tradable ADD wiki_link NVARCHAR(4000)');
        $this->addSql('ALTER TABLE items_tradable ADD description NVARCHAR(4000)');
        $this->addSql('ALTER TABLE items_tradable ADD icon NVARCHAR(4000)');
    }

    public function down(Schema $schema): void
    {

        $this->addSql('ALTER TABLE items_tradable DROP COLUMN wiki_link');
        $this->addSql('ALTER TABLE items_tradable DROP COLUMN description');
        $this->addSql('ALTER TABLE items_tradable DROP COLUMN icon');
    }
}
