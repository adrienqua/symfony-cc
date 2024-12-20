<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241220161004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE album ADD cover_image VARCHAR(255) DEFAULT NULL, ADD track_amount INT NOT NULL');
        $this->addSql('ALTER TABLE artist ADD birth_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD biography VARCHAR(500) DEFAULT NULL, ADD picture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE playlist ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL, ADD image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE album DROP cover_image, DROP track_amount');
        $this->addSql('ALTER TABLE artist DROP birth_date, DROP biography, DROP picture');
        $this->addSql('ALTER TABLE playlist DROP created_at, DROP updated_at, DROP image');
    }
}
