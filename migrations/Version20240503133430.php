<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240503133430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE av_categories_av_travels (av_categories_id INT NOT NULL, av_travels_id INT NOT NULL, INDEX IDX_665316B783CD7443 (av_categories_id), INDEX IDX_665316B7AA5FD4DF (av_travels_id), PRIMARY KEY(av_categories_id, av_travels_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE av_travels_av_countries (av_travels_id INT NOT NULL, av_countries_id INT NOT NULL, INDEX IDX_6840E8FFAA5FD4DF (av_travels_id), INDEX IDX_6840E8FFC52EA420 (av_countries_id), PRIMARY KEY(av_travels_id, av_countries_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE av_categories_av_travels ADD CONSTRAINT FK_665316B783CD7443 FOREIGN KEY (av_categories_id) REFERENCES av_categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE av_categories_av_travels ADD CONSTRAINT FK_665316B7AA5FD4DF FOREIGN KEY (av_travels_id) REFERENCES av_travels (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE av_travels_av_countries ADD CONSTRAINT FK_6840E8FFAA5FD4DF FOREIGN KEY (av_travels_id) REFERENCES av_travels (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE av_travels_av_countries ADD CONSTRAINT FK_6840E8FFC52EA420 FOREIGN KEY (av_countries_id) REFERENCES av_countries (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE av_booking ADD av_status_id INT NOT NULL, ADD av_travels_id INT NOT NULL');
        $this->addSql('ALTER TABLE av_booking ADD CONSTRAINT FK_AF706EAD1B54B76E FOREIGN KEY (av_status_id) REFERENCES av_status (id)');
        $this->addSql('ALTER TABLE av_booking ADD CONSTRAINT FK_AF706EADAA5FD4DF FOREIGN KEY (av_travels_id) REFERENCES av_travels (id)');
        $this->addSql('CREATE INDEX IDX_AF706EAD1B54B76E ON av_booking (av_status_id)');
        $this->addSql('CREATE INDEX IDX_AF706EADAA5FD4DF ON av_booking (av_travels_id)');
        $this->addSql('ALTER TABLE av_forms ADD av_booking_id INT NOT NULL, ADD av_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE av_forms ADD CONSTRAINT FK_301ECC951C9A3CB9 FOREIGN KEY (av_booking_id) REFERENCES av_booking (id)');
        $this->addSql('ALTER TABLE av_forms ADD CONSTRAINT FK_301ECC95E81250E6 FOREIGN KEY (av_user_id) REFERENCES av_user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_301ECC951C9A3CB9 ON av_forms (av_booking_id)');
        $this->addSql('CREATE INDEX IDX_301ECC95E81250E6 ON av_forms (av_user_id)');
        $this->addSql('ALTER TABLE av_travels ADD av_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE av_travels ADD CONSTRAINT FK_2883A8A4E81250E6 FOREIGN KEY (av_user_id) REFERENCES av_user (id)');
        $this->addSql('CREATE INDEX IDX_2883A8A4E81250E6 ON av_travels (av_user_id)');
        $this->addSql('ALTER TABLE av_user ADD is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE av_categories_av_travels DROP FOREIGN KEY FK_665316B783CD7443');
        $this->addSql('ALTER TABLE av_categories_av_travels DROP FOREIGN KEY FK_665316B7AA5FD4DF');
        $this->addSql('ALTER TABLE av_travels_av_countries DROP FOREIGN KEY FK_6840E8FFAA5FD4DF');
        $this->addSql('ALTER TABLE av_travels_av_countries DROP FOREIGN KEY FK_6840E8FFC52EA420');
        $this->addSql('DROP TABLE av_categories_av_travels');
        $this->addSql('DROP TABLE av_travels_av_countries');
        $this->addSql('ALTER TABLE av_booking DROP FOREIGN KEY FK_AF706EAD1B54B76E');
        $this->addSql('ALTER TABLE av_booking DROP FOREIGN KEY FK_AF706EADAA5FD4DF');
        $this->addSql('DROP INDEX IDX_AF706EAD1B54B76E ON av_booking');
        $this->addSql('DROP INDEX IDX_AF706EADAA5FD4DF ON av_booking');
        $this->addSql('ALTER TABLE av_booking DROP av_status_id, DROP av_travels_id');
        $this->addSql('ALTER TABLE av_forms DROP FOREIGN KEY FK_301ECC951C9A3CB9');
        $this->addSql('ALTER TABLE av_forms DROP FOREIGN KEY FK_301ECC95E81250E6');
        $this->addSql('DROP INDEX UNIQ_301ECC951C9A3CB9 ON av_forms');
        $this->addSql('DROP INDEX IDX_301ECC95E81250E6 ON av_forms');
        $this->addSql('ALTER TABLE av_forms DROP av_booking_id, DROP av_user_id');
        $this->addSql('ALTER TABLE av_travels DROP FOREIGN KEY FK_2883A8A4E81250E6');
        $this->addSql('DROP INDEX IDX_2883A8A4E81250E6 ON av_travels');
        $this->addSql('ALTER TABLE av_travels DROP av_user_id');
        $this->addSql('ALTER TABLE av_user DROP is_verified');
    }
}
