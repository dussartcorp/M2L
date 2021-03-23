<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210323154713 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription CHANGE dateInscription dateInscription DATETIME NOT NULL');
        $this->addSql('ALTER TABLE vacation ADD date_heure_debut DATETIME NOT NULL, ADD date_heure_fin DATETIME NOT NULL, DROP dateHeureDebut, DROP dateHeureFin');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription CHANGE dateInscription dateInscription DATE NOT NULL');
        $this->addSql('ALTER TABLE vacation ADD dateHeureDebut DATE NOT NULL, ADD dateHeureFin DATE NOT NULL, DROP date_heure_debut, DROP date_heure_fin');
    }
}
