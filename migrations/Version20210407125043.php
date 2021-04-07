<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210407125043 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscriptionparRestauration (idinscription INT NOT NULL, idrestauration INT NOT NULL, INDEX IDX_4287A00898518679 (idinscription), INDEX IDX_4287A008CF2461F8 (idrestauration), PRIMARY KEY(idinscription, idrestauration)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscriptionparRestauration ADD CONSTRAINT FK_4287A00898518679 FOREIGN KEY (idinscription) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE inscriptionparRestauration ADD CONSTRAINT FK_4287A008CF2461F8 FOREIGN KEY (idrestauration) REFERENCES restauration (id)');
        $this->addSql('DROP TABLE restauration_inscription');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE restauration_inscription (restauration_id INT NOT NULL, inscription_id INT NOT NULL, INDEX IDX_F7964D7C7C6CB929 (restauration_id), INDEX IDX_F7964D7C5DAC5993 (inscription_id), PRIMARY KEY(restauration_id, inscription_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE restauration_inscription ADD CONSTRAINT FK_F7964D7C5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restauration_inscription ADD CONSTRAINT FK_F7964D7C7C6CB929 FOREIGN KEY (restauration_id) REFERENCES restauration (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE inscriptionparRestauration');
    }
}
