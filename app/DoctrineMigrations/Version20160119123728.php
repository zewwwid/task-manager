<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160119123728 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX documents_filename_idx ON documents');
        $this->addSql('DROP INDEX clients_email_idx ON clients');
        //$this->addSql('ALTER TABLE clients CHANGE status `status` ENUM(\'Действующий\', \'Потенциальный\', \'Прошлый\')');
        $this->addSql('CREATE UNIQUE INDEX clients_email_idx ON clients (email)');
        $this->addSql('DROP INDEX tasks_name_idx ON tasks');
        $this->addSql('DROP INDEX tasks_status_idx ON tasks');
        //$this->addSql('ALTER TABLE tasks CHANGE status `status` ENUM(\'Новая\', \'В работе\', \'Закрыта\')');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX clients_email_idx ON clients');
        //$this->addSql('ALTER TABLE clients CHANGE status status VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE INDEX clients_email_idx ON clients (email)');
        $this->addSql('CREATE INDEX documents_filename_idx ON documents (filename)');
        //$this->addSql('ALTER TABLE tasks CHANGE status status VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE INDEX tasks_name_idx ON tasks (name)');
        $this->addSql('CREATE INDEX tasks_status_idx ON tasks (status)');
    }
}
