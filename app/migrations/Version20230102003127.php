<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20230102003127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create customer table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, pushy_token VARCHAR(255) DEFAULT NULL, locale VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE customer');
    }
}
