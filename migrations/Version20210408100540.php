<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210408100540 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE licencie CHANGE idcompte idcompte INT DEFAULT NULL');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612AB4BFFCC FOREIGN KEY (idcompte) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B755612AB4BFFCC ON licencie (idcompte)');
        $this->addSql('ALTER TABLE restauration CHANGE typesRepas typesRepas enum(\'Midi\', \'Soir\')');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612AB4BFFCC');
        $this->addSql('DROP INDEX UNIQ_3B755612AB4BFFCC ON licencie');
        $this->addSql('ALTER TABLE licencie CHANGE idcompte idcompte VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE restauration CHANGE typesRepas typesRepas VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
