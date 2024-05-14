<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513134625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE av_travels_av_categories (av_travels_id INT NOT NULL, av_categories_id INT NOT NULL, INDEX IDX_BFA350B3AA5FD4DF (av_travels_id), INDEX IDX_BFA350B383CD7443 (av_categories_id), PRIMARY KEY(av_travels_id, av_categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE av_travels_av_categories ADD CONSTRAINT FK_BFA350B3AA5FD4DF FOREIGN KEY (av_travels_id) REFERENCES av_travels (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE av_travels_av_categories ADD CONSTRAINT FK_BFA350B383CD7443 FOREIGN KEY (av_categories_id) REFERENCES av_categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE av_categories_av_travels DROP FOREIGN KEY FK_665316B783CD7443');
        $this->addSql('ALTER TABLE av_categories_av_travels DROP FOREIGN KEY FK_665316B7AA5FD4DF');
        $this->addSql('DROP TABLE av_categories_av_travels');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE av_categories_av_travels (av_categories_id INT NOT NULL, av_travels_id INT NOT NULL, INDEX IDX_665316B783CD7443 (av_categories_id), INDEX IDX_665316B7AA5FD4DF (av_travels_id), PRIMARY KEY(av_categories_id, av_travels_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE av_categories_av_travels ADD CONSTRAINT FK_665316B783CD7443 FOREIGN KEY (av_categories_id) REFERENCES av_categories (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE av_categories_av_travels ADD CONSTRAINT FK_665316B7AA5FD4DF FOREIGN KEY (av_travels_id) REFERENCES av_travels (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE av_travels_av_categories DROP FOREIGN KEY FK_BFA350B3AA5FD4DF');
        $this->addSql('ALTER TABLE av_travels_av_categories DROP FOREIGN KEY FK_BFA350B383CD7443');
        $this->addSql('DROP TABLE av_travels_av_categories');
    }
}
