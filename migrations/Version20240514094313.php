<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514094313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE av_booking ADD CONSTRAINT FK_AF706EADD91A3A FOREIGN KEY (av_forms_id) REFERENCES av_forms (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AF706EADD91A3A ON av_booking (av_forms_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE av_booking DROP FOREIGN KEY FK_AF706EADD91A3A');
        $this->addSql('DROP INDEX UNIQ_AF706EADD91A3A ON av_booking');
    }
}
