<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210328154239 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participation ADD client_id INT NOT NULL, ADD evenement_id INT NOT NULL');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F19EB6921 FOREIGN KEY (client_id) REFERENCES user (cin)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_AB55E24F19EB6921 ON participation (client_id)');
        $this->addSql('CREATE INDEX IDX_AB55E24FFD02F13 ON participation (evenement_id)');
        $this->addSql('ALTER TABLE transport DROP FOREIGN KEY FK_66AB212E3CC6385');
        $this->addSql('DROP INDEX IDX_66AB212E3CC6385 ON transport');
        $this->addSql('ALTER TABLE transport CHANGE camping_id event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transport ADD CONSTRAINT FK_66AB212E71F7E88B FOREIGN KEY (event_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_66AB212E71F7E88B ON transport (event_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F19EB6921');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FFD02F13');
        $this->addSql('DROP INDEX IDX_AB55E24F19EB6921 ON participation');
        $this->addSql('DROP INDEX IDX_AB55E24FFD02F13 ON participation');
        $this->addSql('ALTER TABLE participation DROP client_id, DROP evenement_id');
        $this->addSql('ALTER TABLE transport DROP FOREIGN KEY FK_66AB212E71F7E88B');
        $this->addSql('DROP INDEX IDX_66AB212E71F7E88B ON transport');
        $this->addSql('ALTER TABLE transport CHANGE event_id camping_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transport ADD CONSTRAINT FK_66AB212E3CC6385 FOREIGN KEY (camping_id) REFERENCES evenement (id)');
        $this->addSql('CREATE INDEX IDX_66AB212E3CC6385 ON transport (camping_id)');
    }
}
