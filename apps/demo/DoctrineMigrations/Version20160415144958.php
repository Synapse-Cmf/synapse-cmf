<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160415144958 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE synapse_page (id INT AUTO_INCREMENT NOT NULL, root_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, meta LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', open_graph LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', lft INT NOT NULL, rgt INT NOT NULL, lvl INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8FBCACD0B548B0F (path), INDEX IDX_8FBCACD079066886 (root_id), INDEX IDX_8FBCACD0727ACA70 (parent_id), INDEX path_index (path), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE synapse_page ADD CONSTRAINT FK_8FBCACD079066886 FOREIGN KEY (root_id) REFERENCES synapse_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE synapse_page ADD CONSTRAINT FK_8FBCACD0727ACA70 FOREIGN KEY (parent_id) REFERENCES synapse_page (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE synapse_page DROP FOREIGN KEY FK_8FBCACD079066886');
        $this->addSql('ALTER TABLE synapse_page DROP FOREIGN KEY FK_8FBCACD0727ACA70');
        $this->addSql('DROP TABLE synapse_page');
    }
}
