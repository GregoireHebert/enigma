<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191128130403 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE order_status (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart ADD order_status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7D7707B45 FOREIGN KEY (order_status_id) REFERENCES order_status (id)');
        $this->addSql('CREATE INDEX IDX_BA388B7D7707B45 ON cart (order_status_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7D7707B45');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP INDEX IDX_BA388B7D7707B45 ON cart');
        $this->addSql('ALTER TABLE cart DROP order_status_id');
    }
}
