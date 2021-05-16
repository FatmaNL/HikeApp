<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331222940 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (idcategorie INT AUTO_INCREMENT NOT NULL, nomcategorie VARCHAR(255) NOT NULL, PRIMARY KEY(idcategorie)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (refcommande VARCHAR(255) NOT NULL, user_cin INT DEFAULT NULL, datecommande DATE NOT NULL, etat VARCHAR(250) NOT NULL, INDEX IDX_6EEAA67D40F35151 (user_cin), PRIMARY KEY(refcommande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, transport_id INT NOT NULL, depart VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, nbparticipant INT NOT NULL, dateevenement DATE NOT NULL, duree INT NOT NULL, prix DOUBLE PRECISION NOT NULL, programme VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, infos VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, circuit VARCHAR(255) DEFAULT NULL, nomevenement VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B26681E9909C13F (transport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (reffacture INT AUTO_INCREMENT NOT NULL, datefacture DATE NOT NULL, montant INT NOT NULL, PRIMARY KEY(reffacture)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lignecommande (idlignecommande INT AUTO_INCREMENT NOT NULL, qtecommande INT NOT NULL, PRIMARY KEY(idlignecommande)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lignefacture (idlignefacture INT AUTO_INCREMENT NOT NULL, nomfacture VARCHAR(255) NOT NULL, descriptionfacture VARCHAR(255) NOT NULL, montantlignefacture INT NOT NULL, qteproduits INT NOT NULL, PRIMARY KEY(idlignefacture)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (numlivraison INT AUTO_INCREMENT NOT NULL, datelivraison DATE NOT NULL, PRIMARY KEY(numlivraison)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur (cin INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, age INT NOT NULL, sexe VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, PRIMARY KEY(cin)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, lat DOUBLE PRECISION NOT NULL, lng DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, location_statut SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (idparticipation INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, evenement_id INT NOT NULL, INDEX IDX_AB55E24F19EB6921 (client_id), INDEX IDX_AB55E24FFD02F13 (evenement_id), PRIMARY KEY(idparticipation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (numproduit INT AUTO_INCREMENT NOT NULL, nomproduit VARCHAR(255) NOT NULL, quantite INT NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(numproduit)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sentier (idsentier INT AUTO_INCREMENT NOT NULL, nomsentier VARCHAR(255) NOT NULL, duree VARCHAR(255) NOT NULL, distance VARCHAR(255) NOT NULL, difficulte VARCHAR(255) NOT NULL, departsentier VARCHAR(255) NOT NULL, destinationsentier VARCHAR(255) NOT NULL, PRIMARY KEY(idsentier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenements_sentiers (idsentier INT NOT NULL, idrandonnee INT NOT NULL, INDEX IDX_A9172222E40958F5 (idsentier), INDEX IDX_A9172222B56A006A (idrandonnee), PRIMARY KEY(idsentier, idrandonnee)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, volumemax INT NOT NULL, nombre_transports INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (cin INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, age INT NOT NULL, sexe VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, motdepasse VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(cin)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D40F35151 FOREIGN KEY (user_cin) REFERENCES user (cin)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E9909C13F FOREIGN KEY (transport_id) REFERENCES transport (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F19EB6921 FOREIGN KEY (client_id) REFERENCES user (cin)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE evenements_sentiers ADD CONSTRAINT FK_A9172222E40958F5 FOREIGN KEY (idsentier) REFERENCES sentier (idsentier)');
        $this->addSql('ALTER TABLE evenements_sentiers ADD CONSTRAINT FK_A9172222B56A006A FOREIGN KEY (idrandonnee) REFERENCES evenement (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FFD02F13');
        $this->addSql('ALTER TABLE evenements_sentiers DROP FOREIGN KEY FK_A9172222B56A006A');
        $this->addSql('ALTER TABLE evenements_sentiers DROP FOREIGN KEY FK_A9172222E40958F5');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E9909C13F');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D40F35151');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F19EB6921');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE lignecommande');
        $this->addSql('DROP TABLE lignefacture');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE livreur');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE sentier');
        $this->addSql('DROP TABLE evenements_sentiers');
        $this->addSql('DROP TABLE transport');
        $this->addSql('DROP TABLE user');
    }
}
