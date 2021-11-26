<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211126144542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE live (id INT AUTO_INCREMENT NOT NULL, artist_id INT DEFAULT NULL, nom_projet VARCHAR(255) NOT NULL, date DATE NOT NULL, date_timestamp INT NOT NULL, salle VARCHAR(255) NOT NULL, INDEX IDX_530F2CAFB7970CF8 (artist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE live ADD CONSTRAINT FK_530F2CAFB7970CF8 FOREIGN KEY (artist_id) REFERENCES artiste (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE live');
    }
}
