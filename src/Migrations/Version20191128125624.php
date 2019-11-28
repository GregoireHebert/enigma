<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191128125624 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE cart (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, total INTEGER NOT NULL, status_id INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE cart_selection (cart_id INTEGER NOT NULL, selection_id INTEGER NOT NULL, PRIMARY KEY(cart_id, selection_id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C5B2B48E48EFE78 ON cart_selection (selection_id)');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price INTEGER NOT NULL, category_id INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE product_customer (product_id INTEGER NOT NULL, customer_id INTEGER NOT NULL, PRIMARY KEY(product_id, customer_id))');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09F85E0677 ON customer (username)');
        $this->addSql('CREATE TABLE selection (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, quantity INTEGER NOT NULL, product_id INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE cart_status (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, level VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_selection');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_customer');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE selection');
        $this->addSql('DROP TABLE cart_status');
    }
}
