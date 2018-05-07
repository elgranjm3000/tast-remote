<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180425033601 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE taskboard (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(60) NOT NULL, descripcion VARCHAR(120) NOT NULL, fechacreacion DATETIME NOT NULL, fechacomienzo DATETIME NOT NULL, fechafin DATETIME DEFAULT NULL, userid INT DEFAULT NULL, idtask INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(60) NOT NULL, descripcion VARCHAR(120) NOT NULL, estado VARCHAR(2) NOT NULL, fechacreacion DATETIME NOT NULL, fechacomienzo DATETIME DEFAULT NULL, fechafin DATETIME DEFAULT NULL, tiempo VARCHAR(60) NOT NULL, iduser INT NOT NULL, idfile INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, files VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, ext VARCHAR(255) NOT NULL, size VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE taskboard');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE files');
    }
}
