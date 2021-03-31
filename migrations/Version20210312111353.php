<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312111353 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit ADD idlignecommande INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27FCA16EE2 FOREIGN KEY (idlignecommande) REFERENCES lignecommande (idlignecommande)');
        $this->addSql('CREATE INDEX IDX_29A5EC27FCA16EE2 ON produit (idlignecommande)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27FCA16EE2');
        $this->addSql('DROP INDEX IDX_29A5EC27FCA16EE2 ON produit');
        $this->addSql('ALTER TABLE produit DROP idlignecommande');
    }
}
