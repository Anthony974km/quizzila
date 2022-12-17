<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221216072034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE resultat (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, reponse_id INT NOT NULL, INDEX IDX_E7DB5DE219EB6921 (client_id), INDEX IDX_E7DB5DE2CF18BB82 (reponse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE219EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE resultat ADD CONSTRAINT FK_E7DB5DE2CF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id)');
        $this->addSql('ALTER TABLE reponse ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE219EB6921');
        $this->addSql('ALTER TABLE resultat DROP FOREIGN KEY FK_E7DB5DE2CF18BB82');
        $this->addSql('DROP TABLE resultat');
        $this->addSql('ALTER TABLE reponse DROP created_at, DROP updated_at');
    }
}
