<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210403024028 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement ADD image VARCHAR(255) NOT NULL, ADD updated_at DATE NOT NULL');
        $this->addSql('ALTER TABLE evenements_sentiers DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE evenements_sentiers ADD PRIMARY KEY (idrandonnee, idsentier)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP image, DROP updated_at');
        $this->addSql('ALTER TABLE evenements_sentiers DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE evenements_sentiers ADD PRIMARY KEY (idsentier, idrandonnee)');
    }
}
