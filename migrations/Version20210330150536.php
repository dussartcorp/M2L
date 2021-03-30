<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330150536 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, adresse1 VARCHAR(60) NOT NULL, adresse2 VARCHAR(60) DEFAULT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(60) NOT NULL, tel VARCHAR(14) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qualite (id INT AUTO_INCREMENT NOT NULL, libelle_qualite VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE licencie ADD idQualite INT NOT NULL, ADD idClub INT NOT NULL, CHANGE numLicence numLicence VARCHAR(11) NOT NULL');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612780A3CAD FOREIGN KEY (idQualite) REFERENCES qualite (id)');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612CB1366EC FOREIGN KEY (idClub) REFERENCES club (id)');
        $this->addSql('CREATE INDEX IDX_3B755612780A3CAD ON licencie (idQualite)');
        $this->addSql('CREATE INDEX IDX_3B755612CB1366EC ON licencie (idClub)');
        $this->addSql('DROP INDEX UNIQ_8D93D64992056FEF ON user');
        $this->addSql('ALTER TABLE user ADD num_licence VARCHAR(11) NOT NULL, DROP numLicence');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D8A9FCA1 ON user (num_licence)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612CB1366EC');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612780A3CAD');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE qualite');
        $this->addSql('DROP INDEX IDX_3B755612780A3CAD ON licencie');
        $this->addSql('DROP INDEX IDX_3B755612CB1366EC ON licencie');
        $this->addSql('ALTER TABLE licencie DROP idQualite, DROP idClub, CHANGE numLicence numLicence VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_8D93D649D8A9FCA1 ON user');
        $this->addSql('ALTER TABLE user ADD numLicence VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP num_licence');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64992056FEF ON user (numLicence)');
    }
}
