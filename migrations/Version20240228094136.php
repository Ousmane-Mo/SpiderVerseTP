<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228094136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movies (id INT AUTO_INCREMENT NOT NULL, moviename VARCHAR(255) NOT NULL, yearreleased VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movies_users (movies_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_6F6187E853F590A4 (movies_id), INDEX IDX_6F6187E867B3B43D (users_id), PRIMARY KEY(movies_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quotes (id INT AUTO_INCREMENT NOT NULL, characters_id INT NOT NULL, quote LONGTEXT NOT NULL, INDEX IDX_A1B588C5C70F0E28 (characters_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, realname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movies_users ADD CONSTRAINT FK_6F6187E853F590A4 FOREIGN KEY (movies_id) REFERENCES movies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movies_users ADD CONSTRAINT FK_6F6187E867B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quotes ADD CONSTRAINT FK_A1B588C5C70F0E28 FOREIGN KEY (characters_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movies_users DROP FOREIGN KEY FK_6F6187E853F590A4');
        $this->addSql('ALTER TABLE movies_users DROP FOREIGN KEY FK_6F6187E867B3B43D');
        $this->addSql('ALTER TABLE quotes DROP FOREIGN KEY FK_A1B588C5C70F0E28');
        $this->addSql('DROP TABLE movies');
        $this->addSql('DROP TABLE movies_users');
        $this->addSql('DROP TABLE quotes');
        $this->addSql('DROP TABLE users');
    }
}
