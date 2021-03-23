<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210323160738 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vacation ADD dateheuredebut DATETIME NOT NULL, ADD dateheurefin DATETIME NOT NULL, DROP date_heure_debut, DROP date_heure_fin');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vacation ADD date_heure_debut DATETIME NOT NULL, ADD date_heure_fin DATETIME NOT NULL, DROP dateheuredebut, DROP dateheurefin');
    }
}
