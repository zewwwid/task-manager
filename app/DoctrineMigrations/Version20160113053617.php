<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160113053617 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE documents (task INT DEFAULT NULL, client INT DEFAULT NULL, administrator INT DEFAULT NULL, `id` INT AUTO_INCREMENT NOT NULL, `filename` VARCHAR(255) NOT NULL, INDEX IDX_A2B07288527EDB25 (task), INDEX IDX_A2B07288C7440455 (client), INDEX IDX_A2B0728858DF0651 (administrator), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clients (`id` INT AUTO_INCREMENT NOT NULL, `fullname` VARCHAR(255) NOT NULL, `email` VARCHAR(64) NOT NULL, `phone` VARCHAR(20) DEFAULT NULL, `status` ENUM(\'Действующий\', \'Потенциальный\', \'Прошлый\'), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasks (responsible INT DEFAULT NULL, `id` INT AUTO_INCREMENT NOT NULL, `name` VARCHAR(255) NOT NULL, `text` LONGTEXT DEFAULT NULL, `status` ENUM(\'Новая\', \'В работе\', \'Закрыта\'), INDEX IDX_5058659797E625E8 (responsible), PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE administrators (`id` INT AUTO_INCREMENT NOT NULL, `fullname` VARCHAR(255) NOT NULL, PRIMARY KEY(`id`)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B07288527EDB25 FOREIGN KEY (task) REFERENCES tasks (id)');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B07288C7440455 FOREIGN KEY (client) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B0728858DF0651 FOREIGN KEY (administrator) REFERENCES administrators (id)');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_5058659797E625E8 FOREIGN KEY (responsible) REFERENCES administrators (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B07288C7440455');
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B07288527EDB25');
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B0728858DF0651');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_5058659797E625E8');
        $this->addSql('DROP TABLE documents');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE administrators');
    }
}
