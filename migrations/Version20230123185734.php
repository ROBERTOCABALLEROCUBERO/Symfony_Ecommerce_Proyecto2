<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230123185734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, estatus VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_item ADD nombre_producto_id INT NOT NULL, ADD order_ref_id INT NOT NULL, DROP nombre_producto');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09BDD94959 FOREIGN KEY (nombre_producto_id) REFERENCES productos (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09E238517C FOREIGN KEY (order_ref_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_52EA1F09BDD94959 ON order_item (nombre_producto_id)');
        $this->addSql('CREATE INDEX IDX_52EA1F09E238517C ON order_item (order_ref_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09E238517C');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09BDD94959');
        $this->addSql('DROP INDEX IDX_52EA1F09BDD94959 ON order_item');
        $this->addSql('DROP INDEX IDX_52EA1F09E238517C ON order_item');
        $this->addSql('ALTER TABLE order_item ADD nombre_producto VARCHAR(255) NOT NULL, DROP nombre_producto_id, DROP order_ref_id');
    }
}
