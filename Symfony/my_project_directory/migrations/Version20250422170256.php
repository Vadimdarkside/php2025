<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250422170256 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, phone VARCHAR(20) DEFAULT NULL, registration_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE enrollments (id INT AUTO_INCREMENT NOT NULL, client_id_id INT NOT NULL, program_id_id INT NOT NULL, start_date DATE NOT NULL, status VARCHAR(50) NOT NULL, INDEX IDX_CCD8C132DC2902E0 (client_id_id), INDEX IDX_CCD8C132E12DEDA1 (program_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE payments (id INT AUTO_INCREMENT NOT NULL, client_id_id INT NOT NULL, amount NUMERIC(7, 2) NOT NULL, payment_date DATE NOT NULL, method VARCHAR(50) NOT NULL, INDEX IDX_65D29B32DC2902E0 (client_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE trainers (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, specialty VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE workout_programs (id INT AUTO_INCREMENT NOT NULL, trainer_id INT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, duration DOUBLE PRECISION NOT NULL, INDEX IDX_293888F3FB08EDF6 (trainer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE enrollments ADD CONSTRAINT FK_CCD8C132DC2902E0 FOREIGN KEY (client_id_id) REFERENCES clients (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE enrollments ADD CONSTRAINT FK_CCD8C132E12DEDA1 FOREIGN KEY (program_id_id) REFERENCES workout_programs (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payments ADD CONSTRAINT FK_65D29B32DC2902E0 FOREIGN KEY (client_id_id) REFERENCES clients (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE workout_programs ADD CONSTRAINT FK_293888F3FB08EDF6 FOREIGN KEY (trainer_id) REFERENCES trainers (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE enrollments DROP FOREIGN KEY FK_CCD8C132DC2902E0
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE enrollments DROP FOREIGN KEY FK_CCD8C132E12DEDA1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payments DROP FOREIGN KEY FK_65D29B32DC2902E0
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE workout_programs DROP FOREIGN KEY FK_293888F3FB08EDF6
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE clients
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE enrollments
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE payments
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE trainers
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE workout_programs
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
