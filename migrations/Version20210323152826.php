<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210323152826 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE atelier (id INT AUTO_INCREMENT NOT NULL, idvacation INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, nbPlaceMaxi INT NOT NULL, INDEX IDX_E1BB1823490F9778 (idvacation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE themesparatelier (idatelier INT NOT NULL, idtheme INT NOT NULL, INDEX IDX_D33808EE3EBF4A4D (idatelier), INDEX IDX_D33808EE41708B11 (idtheme), PRIMARY KEY(idatelier, idtheme)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoriechambre (id INT AUTO_INCREMENT NOT NULL, libelleCategorie VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, nomHotel VARCHAR(30) NOT NULL, adresse1 VARCHAR(50) NOT NULL, adresse2 VARCHAR(50) DEFAULT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(30) NOT NULL, tel VARCHAR(255) NOT NULL, mail VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, idcompte INT DEFAULT NULL, dateInscription DATE NOT NULL, UNIQUE INDEX UNIQ_5E90F6D6AB4BFFCC (idcompte), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscriptionparAtelier (idinscription INT NOT NULL, idatelier INT NOT NULL, INDEX IDX_E84D732098518679 (idinscription), INDEX IDX_E84D73203EBF4A4D (idatelier), PRIMARY KEY(idinscription, idatelier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE licencie (id INT AUTO_INCREMENT NOT NULL, numLicence VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, adresse1 VARCHAR(255) NOT NULL, adresse2 VARCHAR(255) DEFAULT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(50) NOT NULL, tel INT NOT NULL, mail VARCHAR(30) NOT NULL, dateAdhesion DATE NOT NULL, idcompte VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nuite (id INT AUTO_INCREMENT NOT NULL, idhotel INT DEFAULT NULL, idinscription INT DEFAULT NULL, dateNuitee DATETIME NOT NULL, idcategorieChambre VARCHAR(255) NOT NULL, INDEX IDX_8D4CB715D55632C0 (idhotel), INDEX IDX_8D4CB71598518679 (idinscription), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposer (id INT AUTO_INCREMENT NOT NULL, tarifNuite NUMERIC(5, 2) NOT NULL, idcategorie VARCHAR(255) NOT NULL, idhotel VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restauration (id INT AUTO_INCREMENT NOT NULL, idinscription INT DEFAULT NULL, dateRestauration DATETIME NOT NULL, typesRepas VARCHAR(15) NOT NULL, INDEX IDX_898B1EF198518679 (idinscription), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, numLicence VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D64992056FEF (numLicence), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vacation (id INT AUTO_INCREMENT NOT NULL, dateHeureDebut DATE NOT NULL, dateHeureFin DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE atelier ADD CONSTRAINT FK_E1BB1823490F9778 FOREIGN KEY (idvacation) REFERENCES vacation (id)');
        $this->addSql('ALTER TABLE themesparatelier ADD CONSTRAINT FK_D33808EE3EBF4A4D FOREIGN KEY (idatelier) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE themesparatelier ADD CONSTRAINT FK_D33808EE41708B11 FOREIGN KEY (idtheme) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6AB4BFFCC FOREIGN KEY (idcompte) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscriptionparAtelier ADD CONSTRAINT FK_E84D732098518679 FOREIGN KEY (idinscription) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE inscriptionparAtelier ADD CONSTRAINT FK_E84D73203EBF4A4D FOREIGN KEY (idatelier) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE nuite ADD CONSTRAINT FK_8D4CB715D55632C0 FOREIGN KEY (idhotel) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE nuite ADD CONSTRAINT FK_8D4CB71598518679 FOREIGN KEY (idinscription) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE restauration ADD CONSTRAINT FK_898B1EF198518679 FOREIGN KEY (idinscription) REFERENCES inscription (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE themesparatelier DROP FOREIGN KEY FK_D33808EE3EBF4A4D');
        $this->addSql('ALTER TABLE inscriptionparAtelier DROP FOREIGN KEY FK_E84D73203EBF4A4D');
        $this->addSql('ALTER TABLE nuite DROP FOREIGN KEY FK_8D4CB715D55632C0');
        $this->addSql('ALTER TABLE inscriptionparAtelier DROP FOREIGN KEY FK_E84D732098518679');
        $this->addSql('ALTER TABLE nuite DROP FOREIGN KEY FK_8D4CB71598518679');
        $this->addSql('ALTER TABLE restauration DROP FOREIGN KEY FK_898B1EF198518679');
        $this->addSql('ALTER TABLE themesparatelier DROP FOREIGN KEY FK_D33808EE41708B11');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6AB4BFFCC');
        $this->addSql('ALTER TABLE atelier DROP FOREIGN KEY FK_E1BB1823490F9778');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP TABLE themesparatelier');
        $this->addSql('DROP TABLE categoriechambre');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE inscriptionparAtelier');
        $this->addSql('DROP TABLE licencie');
        $this->addSql('DROP TABLE nuite');
        $this->addSql('DROP TABLE proposer');
        $this->addSql('DROP TABLE restauration');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vacation');
    }
}
