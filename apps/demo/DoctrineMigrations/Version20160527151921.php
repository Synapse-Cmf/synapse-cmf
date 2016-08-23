<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160527151921 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE synapse_file (id INT AUTO_INCREMENT NOT NULL, store_path VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE synapse_image_formatted (id INT AUTO_INCREMENT NOT NULL, file_id INT DEFAULT NULL, image_id INT DEFAULT NULL, format VARCHAR(255) NOT NULL, origin LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_66DDACA193CB796C (file_id), INDEX IDX_66DDACA13DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE synapse_image (id INT AUTO_INCREMENT NOT NULL, file_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, tags LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', headline VARCHAR(255) DEFAULT NULL, alt VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_781B405993CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE synapse_image_formatted ADD CONSTRAINT FK_66DDACA193CB796C FOREIGN KEY (file_id) REFERENCES synapse_file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE synapse_image_formatted ADD CONSTRAINT FK_66DDACA13DA5256D FOREIGN KEY (image_id) REFERENCES synapse_image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE synapse_image ADD CONSTRAINT FK_781B405993CB796C FOREIGN KEY (file_id) REFERENCES synapse_file (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE synapse_image_formatted DROP FOREIGN KEY FK_66DDACA193CB796C');
        $this->addSql('ALTER TABLE synapse_image DROP FOREIGN KEY FK_781B405993CB796C');
        $this->addSql('ALTER TABLE synapse_image_formatted DROP FOREIGN KEY FK_66DDACA13DA5256D');
        $this->addSql('DROP TABLE synapse_file');
        $this->addSql('DROP TABLE synapse_image_formatted');
        $this->addSql('DROP TABLE synapse_image');
    }
}
