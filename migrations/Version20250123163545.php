<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250123163545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE death CHANGE death_department death_department_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE death ADD CONSTRAINT FK_E747D52EF915D187 FOREIGN KEY (death_department_id) REFERENCES department (id)');
        $this->addSql('CREATE INDEX IDX_E747D52EF915D187 ON death (death_department_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE death DROP FOREIGN KEY FK_E747D52EF915D187');
        $this->addSql('DROP INDEX IDX_E747D52EF915D187 ON death');
        $this->addSql('ALTER TABLE death CHANGE death_department_id death_department INT DEFAULT NULL');
    }
}
