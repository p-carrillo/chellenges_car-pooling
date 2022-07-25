<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220725104636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id INTEGER NOT NULL, seats INTEGER NOT NULL, seats_available INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE journey (id INTEGER NOT NULL, car_id INTEGER DEFAULT NULL, people INTEGER NOT NULL, date_request DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C816C6A2C3C6F69F ON journey (car_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE journey');
    }
}
