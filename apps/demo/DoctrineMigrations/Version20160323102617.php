<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160323102617 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE INDEX component_type_index ON synapse_component (component_type_id)');
        $this->addSql('CREATE INDEX template_type_index ON synapse_template (template_type_id)');
        $this->addSql('CREATE INDEX content_index ON synapse_template (content_type_name, content_type_id)');
        $this->addSql('CREATE INDEX zone_type_index ON synapse_zone (zone_type_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX component_type_index ON synapse_component');
        $this->addSql('DROP INDEX template_type_index ON synapse_template');
        $this->addSql('DROP INDEX content_index ON synapse_template');
        $this->addSql('DROP INDEX zone_type_index ON synapse_zone');
    }
}
