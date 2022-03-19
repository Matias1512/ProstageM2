<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220319174345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entreprise CHANGE nom nom VARCHAR(300) NOT NULL, CHANGE adresse adresse VARCHAR(300) NOT NULL, CHANGE activite activite VARCHAR(300) NOT NULL');
        $this->addSql('ALTER TABLE formation DROP description, CHANGE nom_long nom_long VARCHAR(300) NOT NULL, CHANGE nom_court nom_court VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE stage DROP nom, DROP detail, CHANGE titre titre VARCHAR(300) NOT NULL, CHANGE email email VARCHAR(100) NOT NULL, CHANGE mission mission VARCHAR(1000) NOT NULL');
        $this->addSql('ALTER TABLE stage_formation DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE stage_formation ADD CONSTRAINT FK_734BDB9E2298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage_formation ADD CONSTRAINT FK_734BDB9E5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage_formation ADD PRIMARY KEY (stage_id, formation_id)');
        $this->addSql('ALTER TABLE stage_formation RENAME INDEX idx_b4f70d1c2298d193 TO IDX_734BDB9E2298D193');
        $this->addSql('ALTER TABLE stage_formation RENAME INDEX idx_b4f70d1c5200282e TO IDX_734BDB9E5200282E');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE entreprise CHANGE nom nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresse adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE activite activite VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE formation ADD description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom_court nom_court VARCHAR(300) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom_long nom_long VARCHAR(300) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE stage ADD nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD detail VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE titre titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mission mission VARCHAR(300) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE stage_formation DROP FOREIGN KEY FK_734BDB9E2298D193');
        $this->addSql('ALTER TABLE stage_formation DROP FOREIGN KEY FK_734BDB9E5200282E');
        $this->addSql('ALTER TABLE stage_formation DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE stage_formation ADD PRIMARY KEY (formation_id, stage_id)');
        $this->addSql('ALTER TABLE stage_formation RENAME INDEX idx_734bdb9e2298d193 TO IDX_B4F70D1C2298D193');
        $this->addSql('ALTER TABLE stage_formation RENAME INDEX idx_734bdb9e5200282e TO IDX_B4F70D1C5200282E');
    }
}
