<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210303150142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE client DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE client ADD cin VARCHAR(255) NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD age INT NOT NULL, ADD sexe VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL, ADD tel VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD motdepasse VARCHAR(255) NOT NULL, ADD role VARCHAR(255) NOT NULL, DROP id');
        $this->addSql('ALTER TABLE client ADD PRIMARY KEY (cin)');
        $this->addSql('ALTER TABLE commande CHANGE refcommande refcommande VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD id INT AUTO_INCREMENT NOT NULL, DROP cin, DROP nom, DROP prenom, DROP age, DROP sexe, DROP adresse, DROP tel, DROP email, DROP motdepasse, DROP role, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE commande CHANGE refcommande refcommande VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
