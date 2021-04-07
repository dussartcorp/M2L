<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210407124707 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE restauration_inscription (restauration_id INT NOT NULL, inscription_id INT NOT NULL, INDEX IDX_F7964D7C7C6CB929 (restauration_id), INDEX IDX_F7964D7C5DAC5993 (inscription_id), PRIMARY KEY(restauration_id, inscription_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE restauration_inscription ADD CONSTRAINT FK_F7964D7C7C6CB929 FOREIGN KEY (restauration_id) REFERENCES restauration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restauration_inscription ADD CONSTRAINT FK_F7964D7C5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restauration DROP FOREIGN KEY FK_898B1EF198518679');
        $this->addSql('DROP INDEX IDX_898B1EF198518679 ON restauration');
        $this->addSql('ALTER TABLE restauration DROP idinscription');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE restauration_inscription');
        $this->addSql('ALTER TABLE restauration ADD idinscription INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restauration ADD CONSTRAINT FK_898B1EF198518679 FOREIGN KEY (idinscription) REFERENCES inscription (id)');
        $this->addSql('CREATE INDEX IDX_898B1EF198518679 ON restauration (idinscription)');
    }
}
