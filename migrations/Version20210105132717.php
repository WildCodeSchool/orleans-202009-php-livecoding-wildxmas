<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105132717 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gift_list_gift (gift_list_id INT NOT NULL, gift_id INT NOT NULL, INDEX IDX_77FDEB8E51F42524 (gift_list_id), INDEX IDX_77FDEB8E97A95A83 (gift_id), PRIMARY KEY(gift_list_id, gift_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gift_list_gift ADD CONSTRAINT FK_77FDEB8E51F42524 FOREIGN KEY (gift_list_id) REFERENCES gift_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gift_list_gift ADD CONSTRAINT FK_77FDEB8E97A95A83 FOREIGN KEY (gift_id) REFERENCES gift (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE gift_list_gift');
    }
}
