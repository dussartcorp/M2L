<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210323141456 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier CHANGE nb_place_maxi nbPlaceMaxi INT NOT NULL');
        $this->addSql('ALTER TABLE categorie_chambre CHANGE libelle_categorie libelleCategorie VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE hotel CHANGE nom_hotel nomHotel VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE inscription CHANGE date_inscription dateInscription DATE NOT NULL');
        $this->addSql('ALTER TABLE licencie CHANGE num_licence numLicence VARCHAR(255) NOT NULL, CHANGE date_adhesion dateAdhesion DATE NOT NULL');
        $this->addSql('ALTER TABLE nuite DROP FOREIGN KEY FK_8D4CB7155DEB5F8');
        $this->addSql('DROP INDEX IDX_8D4CB7155DEB5F8 ON nuite');
        $this->addSql('ALTER TABLE nuite ADD categorieChambre VARCHAR(255) NOT NULL, DROP categorie_chambre_id, CHANGE date_nuitee dateNuitee DATETIME NOT NULL');
        $this->addSql('ALTER TABLE proposer CHANGE tarif_nuite tarifNuite NUMERIC(5, 2) NOT NULL');
        $this->addSql('ALTER TABLE restauration CHANGE date_restauration dateRestauration DATETIME NOT NULL, CHANGE types_repas typesRepas VARCHAR(15) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_8D93D649D8A9FCA1 ON user');
        $this->addSql('ALTER TABLE user CHANGE num_licence numLicence VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64992056FEF ON user (numLicence)');
        $this->addSql('ALTER TABLE vacation ADD dateHeureDebut DATE NOT NULL, ADD dateHeureFin DATE NOT NULL, DROP date_heure_debut, DROP date_heure_fin');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier CHANGE nbplacemaxi nb_place_maxi INT NOT NULL');
        $this->addSql('ALTER TABLE categorie_chambre CHANGE libellecategorie libelle_categorie VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE hotel CHANGE nomhotel nom_hotel VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE inscription CHANGE dateinscription date_inscription DATE NOT NULL');
        $this->addSql('ALTER TABLE licencie CHANGE numlicence num_licence VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE dateadhesion date_adhesion DATE NOT NULL');
        $this->addSql('ALTER TABLE nuite ADD categorie_chambre_id INT DEFAULT NULL, DROP categorieChambre, CHANGE datenuitee date_nuitee DATETIME NOT NULL');
        $this->addSql('ALTER TABLE nuite ADD CONSTRAINT FK_8D4CB7155DEB5F8 FOREIGN KEY (categorie_chambre_id) REFERENCES categorie_chambre (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D4CB7155DEB5F8 ON nuite (categorie_chambre_id)');
        $this->addSql('ALTER TABLE proposer CHANGE tarifnuite tarif_nuite NUMERIC(5, 2) NOT NULL');
        $this->addSql('ALTER TABLE restauration CHANGE daterestauration date_restauration DATETIME NOT NULL, CHANGE typesrepas types_repas VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_8D93D64992056FEF ON user');
        $this->addSql('ALTER TABLE user CHANGE numlicence num_licence VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D8A9FCA1 ON user (num_licence)');
        $this->addSql('ALTER TABLE vacation ADD date_heure_debut DATE NOT NULL, ADD date_heure_fin DATE NOT NULL, DROP dateHeureDebut, DROP dateHeureFin');
    }
}
