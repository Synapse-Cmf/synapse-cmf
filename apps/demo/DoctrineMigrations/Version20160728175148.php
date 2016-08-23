<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160728175148 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX content_index ON synapse_template');
        $this->addSql('ALTER TABLE synapse_template CHANGE content_type_id content_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX content_index ON synapse_template (content_type_name, content_id, template_type_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX content_index ON synapse_template');
        $this->addSql('ALTER TABLE synapse_template CHANGE content_id content_type_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX content_index ON synapse_template (content_type_name, content_type_id, template_type_id)');
    }
}
