<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160113063904 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE INDEX documents_filename_idx ON documents (filename)');
        $this->addSql('CREATE INDEX clients_fullname_idx ON clients (fullname)');
        $this->addSql('CREATE INDEX clients_email_idx ON clients (email)');
        $this->addSql('CREATE INDEX clients_phone_idx ON clients (phone)');
        $this->addSql('CREATE INDEX clients_status_idx ON clients (status)');
        $this->addSql('CREATE INDEX tasks_name_idx ON tasks (name)');
        $this->addSql('CREATE INDEX tasks_status_idx ON tasks (status)');
        $this->addSql('CREATE INDEX administrators_fullname_idx ON administrators (fullname)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX administrators_fullname_idx ON administrators');
        $this->addSql('DROP INDEX clients_fullname_idx ON clients');
        $this->addSql('DROP INDEX clients_email_idx ON clients');
        $this->addSql('DROP INDEX clients_phone_idx ON clients');
        $this->addSql('DROP INDEX clients_status_idx ON clients');
        $this->addSql('DROP INDEX documents_filename_idx ON documents');
        $this->addSql('DROP INDEX tasks_name_idx ON tasks');
        $this->addSql('DROP INDEX tasks_status_idx ON tasks');
    }
}
