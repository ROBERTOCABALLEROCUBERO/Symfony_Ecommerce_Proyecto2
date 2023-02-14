<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214181750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE preguntas (id INT AUTO_INCREMENT NOT NULL, usuario_id_id INT NOT NULL, productos_id_id INT NOT NULL, texto VARCHAR(255) NOT NULL, fecha DATE NOT NULL, INDEX IDX_38794855629AF449 (usuario_id_id), INDEX IDX_3879485550468E6D (productos_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE respuestas (id INT AUTO_INCREMENT NOT NULL, preguntas_id_id INT NOT NULL, texto VARCHAR(255) NOT NULL, fecha DATE NOT NULL, INDEX IDX_5CD06EB1FDF3A339 (preguntas_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE preguntas ADD CONSTRAINT FK_38794855629AF449 FOREIGN KEY (usuario_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE preguntas ADD CONSTRAINT FK_3879485550468E6D FOREIGN KEY (productos_id_id) REFERENCES productos (id)');
        $this->addSql('ALTER TABLE respuestas ADD CONSTRAINT FK_5CD06EB1FDF3A339 FOREIGN KEY (preguntas_id_id) REFERENCES preguntas (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preguntas DROP FOREIGN KEY FK_38794855629AF449');
        $this->addSql('ALTER TABLE preguntas DROP FOREIGN KEY FK_3879485550468E6D');
        $this->addSql('ALTER TABLE respuestas DROP FOREIGN KEY FK_5CD06EB1FDF3A339');
        $this->addSql('DROP TABLE preguntas');
        $this->addSql('DROP TABLE respuestas');
    }
}
