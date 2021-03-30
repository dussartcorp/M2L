<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330153032 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D64992056FEF ON user');
        $this->addSql('ALTER TABLE user ADD num_licence VARCHAR(9) NOT NULL, DROP numLicence');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D8A9FCA1 ON user (num_licence)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D649D8A9FCA1 ON user');
        $this->addSql('ALTER TABLE user ADD numLicence VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP num_licence');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64992056FEF ON user (numLicence)');
    }
}
