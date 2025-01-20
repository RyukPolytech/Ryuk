<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250120095245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE death ADD deathcountry_id INT NOT NULL, ADD deathcause_id INT NOT NULL, DROP deathcountry, DROP deathcause, CHANGE birthcountry birthcountry_id INT NOT NULL');
        $this->addSql('ALTER TABLE death ADD CONSTRAINT FK_E747D52E12B6D5C3 FOREIGN KEY (birthcountry_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE death ADD CONSTRAINT FK_E747D52E13745A08 FOREIGN KEY (deathcountry_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE death ADD CONSTRAINT FK_E747D52EFB4C5F83 FOREIGN KEY (deathcause_id) REFERENCES death_cause (id)');
        $this->addSql('CREATE INDEX IDX_E747D52E12B6D5C3 ON death (birthcountry_id)');
        $this->addSql('CREATE INDEX IDX_E747D52E13745A08 ON death (deathcountry_id)');
        $this->addSql('CREATE INDEX IDX_E747D52EFB4C5F83 ON death (deathcause_id)');
        $this->addSql('ALTER TABLE department ADD country_id INT NOT NULL');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18AF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_CD1DE18AF92F3E70 ON department (country_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE death DROP FOREIGN KEY FK_E747D52E12B6D5C3');
        $this->addSql('ALTER TABLE death DROP FOREIGN KEY FK_E747D52E13745A08');
        $this->addSql('ALTER TABLE death DROP FOREIGN KEY FK_E747D52EFB4C5F83');
        $this->addSql('DROP INDEX IDX_E747D52E12B6D5C3 ON death');
        $this->addSql('DROP INDEX IDX_E747D52E13745A08 ON death');
        $this->addSql('DROP INDEX IDX_E747D52EFB4C5F83 ON death');
        $this->addSql('ALTER TABLE death ADD birthcountry INT NOT NULL, ADD deathcountry INT DEFAULT NULL, ADD deathcause INT DEFAULT NULL, DROP birthcountry_id, DROP deathcountry_id, DROP deathcause_id');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18AF92F3E70');
        $this->addSql('DROP INDEX IDX_CD1DE18AF92F3E70 ON department');
        $this->addSql('ALTER TABLE department DROP country_id');
    }
}
