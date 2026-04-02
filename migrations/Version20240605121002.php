<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605121002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist (id SERIAL NOT NULL, name VARCHAR(64) NOT NULL, description TEXT NOT NULL, picture VARCHAR(255) NOT NULL, video VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, spotify VARCHAR(255) DEFAULT NULL, snapchat VARCHAR(255) DEFAULT NULL, tiktok VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE contact (id SERIAL NOT NULL, name VARCHAR(64) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, content TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, treatment VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE customer (id SERIAL NOT NULL, firstname VARCHAR(64) NOT NULL, lastname VARCHAR(64) NOT NULL, birthdate DATE NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(20) NOT NULL, postcode INT NOT NULL, town VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, adress VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE customer_ticket (customer_id INT NOT NULL, ticket_id INT NOT NULL, PRIMARY KEY(customer_id, ticket_id))');
        $this->addSql('CREATE INDEX IDX_266571F29395C3F3 ON customer_ticket (customer_id)');
        $this->addSql('CREATE INDEX IDX_266571F2700047D2 ON customer_ticket (ticket_id)');
        $this->addSql('CREATE TABLE genre (id SERIAL NOT NULL, name VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE genre_artist (genre_id INT NOT NULL, artist_id INT NOT NULL, PRIMARY KEY(genre_id, artist_id))');
        $this->addSql('CREATE INDEX IDX_EAEAA6A74296D31F ON genre_artist (genre_id)');
        $this->addSql('CREATE INDEX IDX_EAEAA6A7B7970CF8 ON genre_artist (artist_id)');
        $this->addSql('CREATE TABLE slot (id SERIAL NOT NULL, artist_id INT NOT NULL, stage_id INT DEFAULT NULL, date DATE DEFAULT NULL, hour VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, day VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC0E2067B7970CF8 ON slot (artist_id)');
        $this->addSql('CREATE INDEX IDX_AC0E20672298D193 ON slot (stage_id)');
        $this->addSql('CREATE TABLE sponsor (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE stage (id SERIAL NOT NULL, name VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ticket (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, quantity INT DEFAULT NULL, fee VARCHAR(64) DEFAULT NULL, duration INT DEFAULT NULL, type VARCHAR(64) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(64) NOT NULL, lastname VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('ALTER TABLE customer_ticket ADD CONSTRAINT FK_266571F29395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customer_ticket ADD CONSTRAINT FK_266571F2700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE genre_artist ADD CONSTRAINT FK_EAEAA6A74296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE genre_artist ADD CONSTRAINT FK_EAEAA6A7B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE slot ADD CONSTRAINT FK_AC0E2067B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE slot ADD CONSTRAINT FK_AC0E20672298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer_ticket DROP CONSTRAINT FK_266571F29395C3F3');
        $this->addSql('ALTER TABLE customer_ticket DROP CONSTRAINT FK_266571F2700047D2');
        $this->addSql('ALTER TABLE genre_artist DROP CONSTRAINT FK_EAEAA6A74296D31F');
        $this->addSql('ALTER TABLE genre_artist DROP CONSTRAINT FK_EAEAA6A7B7970CF8');
        $this->addSql('ALTER TABLE slot DROP CONSTRAINT FK_AC0E2067B7970CF8');
        $this->addSql('ALTER TABLE slot DROP CONSTRAINT FK_AC0E20672298D193');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_ticket');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE genre_artist');
        $this->addSql('DROP TABLE slot');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE "user"');
    }
}
