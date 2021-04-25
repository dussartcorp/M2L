<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210425182430 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Atelier (id INT AUTO_INCREMENT NOT NULL, idvacation INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, nbPlaceMaxi INT NOT NULL, INDEX IDX_2E0621BF490F9778 (idvacation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Themesparatelier (idatelier INT NOT NULL, idtheme INT NOT NULL, INDEX IDX_C40773933EBF4A4D (idatelier), INDEX IDX_C407739341708B11 (idtheme), PRIMARY KEY(idatelier, idtheme)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Categoriechambre (id INT AUTO_INCREMENT NOT NULL, libelleCategorie VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Club (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, adresse1 VARCHAR(60) NOT NULL, adresse2 VARCHAR(60) DEFAULT NULL, cp VARCHAR(6) NOT NULL, ville VARCHAR(60) NOT NULL, tel VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Hotel (id INT AUTO_INCREMENT NOT NULL, nomHotel VARCHAR(100) NOT NULL, adresse1 VARCHAR(50) NOT NULL, adresse2 VARCHAR(50) DEFAULT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(30) NOT NULL, tel VARCHAR(255) NOT NULL, mail VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Inscription (id INT AUTO_INCREMENT NOT NULL, idcompte INT DEFAULT NULL, dateInscription DATETIME NOT NULL, UNIQUE INDEX UNIQ_D80C7901AB4BFFCC (idcompte), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE InscriptionparAtelier (idinscription INT NOT NULL, idatelier INT NOT NULL, INDEX IDX_7F8556F898518679 (idinscription), INDEX IDX_7F8556F83EBF4A4D (idatelier), PRIMARY KEY(idinscription, idatelier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE InscriptionparRestauration (idinscription INT NOT NULL, idrestauration INT NOT NULL, INDEX IDX_CD5210B998518679 (idinscription), INDEX IDX_CD5210B9CF2461F8 (idrestauration), PRIMARY KEY(idinscription, idrestauration)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Licencie (id INT AUTO_INCREMENT NOT NULL, idcompte INT DEFAULT NULL, numLicence VARCHAR(12) NOT NULL, nom VARCHAR(70) NOT NULL, prenom VARCHAR(70) NOT NULL, adresse1 VARCHAR(255) NOT NULL, adresse2 VARCHAR(255) DEFAULT NULL, cp VARCHAR(6) NOT NULL, ville VARCHAR(80) NOT NULL, tel VARCHAR(14) NOT NULL, mail VARCHAR(100) NOT NULL, dateAdhesion DATE NOT NULL, idQualite INT NOT NULL, idClub INT NOT NULL, UNIQUE INDEX UNIQ_C2033444AB4BFFCC (idcompte), INDEX IDX_C2033444780A3CAD (idQualite), INDEX IDX_C2033444CB1366EC (idClub), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Nuitee (id INT AUTO_INCREMENT NOT NULL, idhotel INT DEFAULT NULL, inscriptions_id INT NOT NULL, dateNuitee DATETIME NOT NULL, idcategorieChambre VARCHAR(255) NOT NULL, INDEX IDX_8526D730D55632C0 (idhotel), INDEX IDX_8526D7308E2AD382 (inscriptions_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Proposer (id INT AUTO_INCREMENT NOT NULL, tarifNuitee NUMERIC(5, 2) NOT NULL, idcategorie VARCHAR(255) NOT NULL, idhotel VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Qualite (id INT AUTO_INCREMENT NOT NULL, libellequalite VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Restauration (id INT AUTO_INCREMENT NOT NULL, typesRepas enum(\'Midi\', \'Soir\'), dateRestauration DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Theme (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE User (id INT AUTO_INCREMENT NOT NULL, num_licence VARCHAR(11) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, conf_password VARCHAR(255) NOT NULL, activation_token VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_2DA17977D8A9FCA1 (num_licence), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Vacation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(70) NOT NULL, dateheuredebut DATETIME NOT NULL, dateheurefin DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Atelier ADD CONSTRAINT FK_2E0621BF490F9778 FOREIGN KEY (idvacation) REFERENCES Vacation (id)');
        $this->addSql('ALTER TABLE Themesparatelier ADD CONSTRAINT FK_C40773933EBF4A4D FOREIGN KEY (idatelier) REFERENCES Atelier (id)');
        $this->addSql('ALTER TABLE Themesparatelier ADD CONSTRAINT FK_C407739341708B11 FOREIGN KEY (idtheme) REFERENCES Theme (id)');
        $this->addSql('ALTER TABLE Inscription ADD CONSTRAINT FK_D80C7901AB4BFFCC FOREIGN KEY (idcompte) REFERENCES User (id)');
        $this->addSql('ALTER TABLE InscriptionparAtelier ADD CONSTRAINT FK_7F8556F898518679 FOREIGN KEY (idinscription) REFERENCES Inscription (id)');
        $this->addSql('ALTER TABLE InscriptionparAtelier ADD CONSTRAINT FK_7F8556F83EBF4A4D FOREIGN KEY (idatelier) REFERENCES Atelier (id)');
        $this->addSql('ALTER TABLE InscriptionparRestauration ADD CONSTRAINT FK_CD5210B998518679 FOREIGN KEY (idinscription) REFERENCES Inscription (id)');
        $this->addSql('ALTER TABLE InscriptionparRestauration ADD CONSTRAINT FK_CD5210B9CF2461F8 FOREIGN KEY (idrestauration) REFERENCES Restauration (id)');
        $this->addSql('ALTER TABLE Licencie ADD CONSTRAINT FK_C2033444AB4BFFCC FOREIGN KEY (idcompte) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Licencie ADD CONSTRAINT FK_C2033444780A3CAD FOREIGN KEY (idQualite) REFERENCES Qualite (id)');
        $this->addSql('ALTER TABLE Licencie ADD CONSTRAINT FK_C2033444CB1366EC FOREIGN KEY (idClub) REFERENCES Club (id)');
        $this->addSql('ALTER TABLE Nuitee ADD CONSTRAINT FK_8526D730D55632C0 FOREIGN KEY (idhotel) REFERENCES Hotel (id)');
        $this->addSql('ALTER TABLE Nuitee ADD CONSTRAINT FK_8526D7308E2AD382 FOREIGN KEY (inscriptions_id) REFERENCES Inscription (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Themesparatelier DROP FOREIGN KEY FK_C40773933EBF4A4D');
        $this->addSql('ALTER TABLE InscriptionparAtelier DROP FOREIGN KEY FK_7F8556F83EBF4A4D');
        $this->addSql('ALTER TABLE Licencie DROP FOREIGN KEY FK_C2033444CB1366EC');
        $this->addSql('ALTER TABLE Nuitee DROP FOREIGN KEY FK_8526D730D55632C0');
        $this->addSql('ALTER TABLE InscriptionparAtelier DROP FOREIGN KEY FK_7F8556F898518679');
        $this->addSql('ALTER TABLE InscriptionparRestauration DROP FOREIGN KEY FK_CD5210B998518679');
        $this->addSql('ALTER TABLE Nuitee DROP FOREIGN KEY FK_8526D7308E2AD382');
        $this->addSql('ALTER TABLE Licencie DROP FOREIGN KEY FK_C2033444780A3CAD');
        $this->addSql('ALTER TABLE InscriptionparRestauration DROP FOREIGN KEY FK_CD5210B9CF2461F8');
        $this->addSql('ALTER TABLE Themesparatelier DROP FOREIGN KEY FK_C407739341708B11');
        $this->addSql('ALTER TABLE Inscription DROP FOREIGN KEY FK_D80C7901AB4BFFCC');
        $this->addSql('ALTER TABLE Licencie DROP FOREIGN KEY FK_C2033444AB4BFFCC');
        $this->addSql('ALTER TABLE Atelier DROP FOREIGN KEY FK_2E0621BF490F9778');
        $this->addSql('DROP TABLE Atelier');
        $this->addSql('DROP TABLE Themesparatelier');
        $this->addSql('DROP TABLE Categoriechambre');
        $this->addSql('DROP TABLE Club');
        $this->addSql('DROP TABLE Hotel');
        $this->addSql('DROP TABLE Inscription');
        $this->addSql('DROP TABLE InscriptionparAtelier');
        $this->addSql('DROP TABLE InscriptionparRestauration');
        $this->addSql('DROP TABLE Licencie');
        $this->addSql('DROP TABLE Nuitee');
        $this->addSql('DROP TABLE Proposer');
        $this->addSql('DROP TABLE Qualite');
        $this->addSql('DROP TABLE Restauration');
        $this->addSql('DROP TABLE Theme');
        $this->addSql('DROP TABLE User');
        $this->addSql('DROP TABLE Vacation');
    }
}
