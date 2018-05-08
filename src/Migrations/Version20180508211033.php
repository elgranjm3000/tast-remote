<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180508211033 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE usuarios (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(60) NOT NULL, apellido VARCHAR(60) NOT NULL, usuario VARCHAR(120) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuarios_task (task_id INT NOT NULL, usuarios_id INT NOT NULL, INDEX IDX_62EB046D8DB60186 (task_id), INDEX IDX_62EB046DF01D3B25 (usuarios_id), PRIMARY KEY(task_id, usuarios_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE usuarios_task ADD CONSTRAINT FK_62EB046D8DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuarios_task ADD CONSTRAINT FK_62EB046DF01D3B25 FOREIGN KEY (usuarios_id) REFERENCES usuarios (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE usuarios_task DROP FOREIGN KEY FK_62EB046DF01D3B25');
        $this->addSql('DROP TABLE usuarios');
        $this->addSql('DROP TABLE usuarios_task');
    }
}
