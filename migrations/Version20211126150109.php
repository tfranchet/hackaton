<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211126150109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artiste_live (artiste_id INT NOT NULL, live_id INT NOT NULL, INDEX IDX_CBC7482C21D25844 (artiste_id), INDEX IDX_CBC7482C1DEBA901 (live_id), PRIMARY KEY(artiste_id, live_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artiste_live ADD CONSTRAINT FK_CBC7482C21D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artiste_live ADD CONSTRAINT FK_CBC7482C1DEBA901 FOREIGN KEY (live_id) REFERENCES live (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artiste DROP date');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE artiste_live');
        $this->addSql('ALTER TABLE artiste ADD date LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci` COMMENT \'(DC2Type:json)\'');
    }
}
