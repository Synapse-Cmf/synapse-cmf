<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160322154708 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE synapse_component (id INT AUTO_INCREMENT NOT NULL, zone_id INT DEFAULT NULL, component_type_id VARCHAR(255) NOT NULL, data LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6D0897829F2C3FAB (zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE synapse_template (id INT AUTO_INCREMENT NOT NULL, content_type_name VARCHAR(255) NOT NULL, content_type_id VARCHAR(255) NOT NULL, template_type_id VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE synapse_zone (id INT AUTO_INCREMENT NOT NULL, template_id INT DEFAULT NULL, zone_type_id VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_3B5DDAF75DA0FB8 (template_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE synapse_component ADD CONSTRAINT FK_6D0897829F2C3FAB FOREIGN KEY (zone_id) REFERENCES synapse_zone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE synapse_zone ADD CONSTRAINT FK_3B5DDAF75DA0FB8 FOREIGN KEY (template_id) REFERENCES synapse_template (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE synapse_zone DROP FOREIGN KEY FK_3B5DDAF75DA0FB8');
        $this->addSql('ALTER TABLE synapse_component DROP FOREIGN KEY FK_6D0897829F2C3FAB');
        $this->addSql('DROP TABLE synapse_component');
        $this->addSql('DROP TABLE synapse_template');
        $this->addSql('DROP TABLE synapse_zone');
    }
}
