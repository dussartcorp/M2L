<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210425151621 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription ADD idinscription INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D698518679 FOREIGN KEY (idinscription) REFERENCES nuite (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D698518679 ON inscription (idinscription)');
        $this->addSql('ALTER TABLE nuite DROP FOREIGN KEY FK_8D4CB71598518679');
        $this->addSql('DROP INDEX IDX_8D4CB71598518679 ON nuite');
        $this->addSql('ALTER TABLE nuite DROP idinscription');
        $this->addSql('ALTER TABLE restauration CHANGE typesRepas typesRepas enum(\'Midi\', \'Soir\')');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D698518679');
        $this->addSql('DROP INDEX IDX_5E90F6D698518679 ON inscription');
        $this->addSql('ALTER TABLE inscription DROP idinscription');
        $this->addSql('ALTER TABLE nuite ADD idinscription INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nuite ADD CONSTRAINT FK_8D4CB71598518679 FOREIGN KEY (idinscription) REFERENCES inscription (id)');
        $this->addSql('CREATE INDEX IDX_8D4CB71598518679 ON nuite (idinscription)');
        $this->addSql('ALTER TABLE restauration CHANGE typesRepas typesRepas VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
