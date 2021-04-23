<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210423123254 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier RENAME INDEX idx_e1bb1823490f9778 TO IDX_2E0621BF490F9778');
        $this->addSql('ALTER TABLE inscription RENAME INDEX uniq_5e90f6d6ab4bffcc TO UNIQ_D80C7901AB4BFFCC');
        $this->addSql('ALTER TABLE licencie CHANGE idcompte idcompte INT DEFAULT NULL');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_C2033444AB4BFFCC FOREIGN KEY (idcompte) REFERENCES User (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C2033444AB4BFFCC ON licencie (idcompte)');
        $this->addSql('ALTER TABLE licencie RENAME INDEX idx_3b755612780a3cad TO IDX_C2033444780A3CAD');
        $this->addSql('ALTER TABLE licencie RENAME INDEX idx_3b755612cb1366ec TO IDX_C2033444CB1366EC');
        $this->addSql('ALTER TABLE nuite RENAME INDEX idx_8d4cb715d55632c0 TO IDX_4C8D9811D55632C0');
        $this->addSql('ALTER TABLE nuite RENAME INDEX idx_8d4cb71598518679 TO IDX_4C8D981198518679');
        $this->addSql('ALTER TABLE restauration CHANGE typesRepas typesRepas enum(\'Midi\', \'Soir\'), CHANGE dateRestauration dateRestauration DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_8d93d649d8a9fca1 TO UNIQ_2DA17977D8A9FCA1');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Atelier RENAME INDEX idx_2e0621bf490f9778 TO IDX_E1BB1823490F9778');
        $this->addSql('ALTER TABLE Inscription RENAME INDEX uniq_d80c7901ab4bffcc TO UNIQ_5E90F6D6AB4BFFCC');
        $this->addSql('ALTER TABLE Licencie DROP FOREIGN KEY FK_C2033444AB4BFFCC');
        $this->addSql('DROP INDEX UNIQ_C2033444AB4BFFCC ON Licencie');
        $this->addSql('ALTER TABLE Licencie CHANGE idcompte idcompte VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE Licencie RENAME INDEX idx_c2033444cb1366ec TO IDX_3B755612CB1366EC');
        $this->addSql('ALTER TABLE Licencie RENAME INDEX idx_c2033444780a3cad TO IDX_3B755612780A3CAD');
        $this->addSql('ALTER TABLE Nuite RENAME INDEX idx_4c8d981198518679 TO IDX_8D4CB71598518679');
        $this->addSql('ALTER TABLE Nuite RENAME INDEX idx_4c8d9811d55632c0 TO IDX_8D4CB715D55632C0');
        $this->addSql('ALTER TABLE Restauration CHANGE typesRepas typesRepas VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE dateRestauration dateRestauration VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE User RENAME INDEX uniq_2da17977d8a9fca1 TO UNIQ_8D93D649D8A9FCA1');
    }
}
