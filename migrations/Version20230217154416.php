<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217154416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carrito (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, lista_prod LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE preguntas (id INT AUTO_INCREMENT NOT NULL, usuario_id_id INT NOT NULL, productos_id_id INT NOT NULL, texto VARCHAR(255) NOT NULL, fecha DATE NOT NULL, INDEX IDX_38794855629AF449 (usuario_id_id), INDEX IDX_3879485550468E6D (productos_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE productos (id INT AUTO_INCREMENT NOT NULL, nombre_prod VARCHAR(255) NOT NULL, cantidad INT NOT NULL, genero VARCHAR(1) NOT NULL, precio DOUBLE PRECISION NOT NULL, descuento DOUBLE PRECISION NOT NULL, talla VARCHAR(4) NOT NULL, tipo VARCHAR(255) NOT NULL, fotoprod VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prueba (id INT AUTO_INCREMENT NOT NULL, prueba VARCHAR(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE respuestas (id INT AUTO_INCREMENT NOT NULL, preguntas_id_id INT NOT NULL, texto VARCHAR(255) NOT NULL, fecha DATE NOT NULL, INDEX IDX_5CD06EB1FDF3A339 (preguntas_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, fechanac DATE NOT NULL, num_tar VARCHAR(50) NOT NULL, titular VARCHAR(255) NOT NULL, cod_seg VARCHAR(4) NOT NULL, direccion VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D6493A909126 (nombre), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuarios (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(150) NOT NULL, apellidos VARCHAR(255) NOT NULL, contrasena VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, fecha_nacimiento DATE DEFAULT NULL, num_tarjeta VARCHAR(255) DEFAULT NULL, titular VARCHAR(255) DEFAULT NULL, cod_seguridad INT DEFAULT NULL, direccion VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
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
        $this->addSql('DROP TABLE carrito');
        $this->addSql('DROP TABLE preguntas');
        $this->addSql('DROP TABLE productos');
        $this->addSql('DROP TABLE prueba');
        $this->addSql('DROP TABLE respuestas');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE usuarios');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
