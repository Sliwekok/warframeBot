<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723110903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notifications ADD riven_id INT');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT FK_6000B0D364BE8534 FOREIGN KEY (riven_id) REFERENCES riven (id)');
        $this->addSql('CREATE INDEX IDX_6000B0D364BE8534 ON notifications (riven_id)');
    }

    public function down(Schema $schema): void
    {
    }
}
