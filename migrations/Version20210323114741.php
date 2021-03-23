<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210323114741 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_chambre (id INT AUTO_INCREMENT NOT NULL, libelle_categorie VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, nom_hotel VARCHAR(30) NOT NULL, adresse1 VARCHAR(50) NOT NULL, adresse2 VARCHAR(50) DEFAULT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(30) NOT NULL, tel INT NOT NULL, mail VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nuite (id INT AUTO_INCREMENT NOT NULL, hotel_id INT DEFAULT NULL, categorie_chambre_id INT DEFAULT NULL, date_nuitee DATETIME NOT NULL, INDEX IDX_8D4CB7153243BB18 (hotel_id), INDEX IDX_8D4CB7155DEB5F8 (categorie_chambre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposer (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, hotel_id INT DEFAULT NULL, tarif_nuite NUMERIC(5, 2) NOT NULL, INDEX IDX_21866C15BCF5E72D (categorie_id), INDEX IDX_21866C153243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restauration (id INT AUTO_INCREMENT NOT NULL, date_restauration DATETIME NOT NULL, types_repas VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nuite ADD CONSTRAINT FK_8D4CB7153243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE nuite ADD CONSTRAINT FK_8D4CB7155DEB5F8 FOREIGN KEY (categorie_chambre_id) REFERENCES categorie_chambre (id)');
        $this->addSql('ALTER TABLE proposer ADD CONSTRAINT FK_21866C15BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_chambre (id)');
        $this->addSql('ALTER TABLE proposer ADD CONSTRAINT FK_21866C153243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE inscription ADD restaurations_id INT DEFAULT NULL, ADD nuites_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6A5BF49F0 FOREIGN KEY (restaurations_id) REFERENCES restauration (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6A9DD7CE0 FOREIGN KEY (nuites_id) REFERENCES nuite (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6A5BF49F0 ON inscription (restaurations_id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6A9DD7CE0 ON inscription (nuites_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nuite DROP FOREIGN KEY FK_8D4CB7155DEB5F8');
        $this->addSql('ALTER TABLE proposer DROP FOREIGN KEY FK_21866C15BCF5E72D');
        $this->addSql('ALTER TABLE nuite DROP FOREIGN KEY FK_8D4CB7153243BB18');
        $this->addSql('ALTER TABLE proposer DROP FOREIGN KEY FK_21866C153243BB18');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6A9DD7CE0');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6A5BF49F0');
        $this->addSql('DROP TABLE categorie_chambre');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE nuite');
        $this->addSql('DROP TABLE proposer');
        $this->addSql('DROP TABLE restauration');
        $this->addSql('DROP INDEX IDX_5E90F6D6A5BF49F0 ON inscription');
        $this->addSql('DROP INDEX IDX_5E90F6D6A9DD7CE0 ON inscription');
        $this->addSql('ALTER TABLE inscription DROP restaurations_id, DROP nuites_id');
    }
}
