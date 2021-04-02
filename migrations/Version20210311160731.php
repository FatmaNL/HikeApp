<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210311160731 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forum ADD user_cin INT DEFAULT NULL');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECD40F35151 FOREIGN KEY (user_cin) REFERENCES user (cin)');
        $this->addSql('CREATE INDEX IDX_852BBECD40F35151 ON forum (user_cin)');
        $this->addSql('ALTER TABLE reponse ADD forum_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC729CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC729CCBAD0 ON reponse (forum_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forum DROP FOREIGN KEY FK_852BBECD40F35151');
        $this->addSql('DROP INDEX IDX_852BBECD40F35151 ON forum');
        $this->addSql('ALTER TABLE forum DROP user_cin');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC729CCBAD0');
        $this->addSql('DROP INDEX IDX_5FB6DEC729CCBAD0 ON reponse');
        $this->addSql('ALTER TABLE reponse DROP forum_id');
    }
}
