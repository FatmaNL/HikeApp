<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210326201655 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D40F35151');
        $this->addSql('DROP INDEX IDX_6EEAA67D40F35151 ON commande');
        $this->addSql('ALTER TABLE commande DROP user_cin');
        $this->addSql('ALTER TABLE user DROP status');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD user_cin INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D40F35151 FOREIGN KEY (user_cin) REFERENCES user (cin)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D40F35151 ON commande (user_cin)');
        $this->addSql('ALTER TABLE user ADD status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
