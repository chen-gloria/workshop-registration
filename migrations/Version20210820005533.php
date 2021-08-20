<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210820005533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, image_filename VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_user (program_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_8075834E3EB8070A (program_id), INDEX IDX_8075834EA76ED395 (user_id), PRIMARY KEY(program_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE program_user ADD CONSTRAINT FK_8075834E3EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_user ADD CONSTRAINT FK_8075834EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workshop ADD program_id INT NOT NULL');
        $this->addSql('ALTER TABLE workshop ADD CONSTRAINT FK_9B6F02C43EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('CREATE INDEX IDX_9B6F02C43EB8070A ON workshop (program_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE program_user DROP FOREIGN KEY FK_8075834E3EB8070A');
        $this->addSql('ALTER TABLE workshop DROP FOREIGN KEY FK_9B6F02C43EB8070A');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE program_user');
        $this->addSql('DROP INDEX IDX_9B6F02C43EB8070A ON workshop');
        $this->addSql('ALTER TABLE workshop DROP program_id');
    }
}
