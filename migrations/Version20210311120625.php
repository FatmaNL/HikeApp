<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210311120625 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE refcommande refcommande VARCHAR(255) NOT NULL, CHANGE etat etat VARCHAR(250) NOT NULL');
        $this->addSql('ALTER TABLE sentier ADD randonnee_id INT DEFAULT NULL, ADD no VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sentier ADD CONSTRAINT FK_3B0D0A9BC8C97C3C FOREIGN KEY (randonnee_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_3B0D0A9BC8C97C3C ON sentier (randonnee_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande CHANGE refcommande refcommande INT AUTO_INCREMENT NOT NULL, CHANGE etat etat VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sentier DROP FOREIGN KEY FK_3B0D0A9BC8C97C3C');
        $this->addSql('DROP INDEX IDX_3B0D0A9BC8C97C3C ON sentier');
        $this->addSql('ALTER TABLE sentier DROP randonnee_id, DROP no');
    }
}
