<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210305065812 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (idcategorie INT AUTO_INCREMENT NOT NULL, nomcategorie VARCHAR(255) NOT NULL, PRIMARY KEY(idcategorie)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (refcommande INT AUTO_INCREMENT NOT NULL, user_cin INT DEFAULT NULL, datecommande DATE NOT NULL, etat VARCHAR(255) NOT NULL, INDEX IDX_6EEAA67D40F35151 (user_cin), PRIMARY KEY(refcommande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, depart VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, nbparticipant INT NOT NULL, datedebut DATE NOT NULL, datefin DATE NOT NULL, prix DOUBLE PRECISION NOT NULL, programme VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, infos VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, circuit VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (reffacture INT AUTO_INCREMENT NOT NULL, datefacture DATE NOT NULL, montant INT NOT NULL, PRIMARY KEY(reffacture)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lignecommande (idlignecommande INT AUTO_INCREMENT NOT NULL, qtecommande INT NOT NULL, PRIMARY KEY(idlignecommande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lignefacture (idlignefacture INT AUTO_INCREMENT NOT NULL, nomfacture VARCHAR(255) NOT NULL, descriptionfacture VARCHAR(255) NOT NULL, montantlignefacture INT NOT NULL, qteproduits INT NOT NULL, PRIMARY KEY(idlignefacture)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (numlivraison INT AUTO_INCREMENT NOT NULL, datelivraison DATE NOT NULL, PRIMARY KEY(numlivraison)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur (cin INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, age INT NOT NULL, sexe VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, PRIMARY KEY(cin)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (idparticipation INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(idparticipation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (numproduit INT AUTO_INCREMENT NOT NULL, nomproduit VARCHAR(255) NOT NULL, quantite INT NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(numproduit)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sentier (idsentier INT AUTO_INCREMENT NOT NULL, duree VARCHAR(255) NOT NULL, distance VARCHAR(255) NOT NULL, difficulte VARCHAR(255) NOT NULL, departsentier VARCHAR(255) NOT NULL, destinationsentier VARCHAR(255) NOT NULL, PRIMARY KEY(idsentier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, volumemax INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (cin INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, age INT NOT NULL, sexe VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, motdepasse VARCHAR(255) NOT NULL, role VARCHAR(255) , PRIMARY KEY(cin)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D40F35151 FOREIGN KEY (user_cin) REFERENCES user (cin)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D40F35151');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE lignecommande');
        $this->addSql('DROP TABLE lignefacture');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE livreur');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE sentier');
        $this->addSql('DROP TABLE transport');
        $this->addSql('DROP TABLE user');
    }
}
