<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221009163221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD match_id VARCHAR(255) NOT NULL, ADD participants LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD game_creation BIGINT NOT NULL, ADD game_duration INT NOT NULL, ADD game_end_timestamp BIGINT NOT NULL, ADD game_id BIGINT NOT NULL, ADD game_mode VARCHAR(255) NOT NULL, ADD game_type VARCHAR(255) NOT NULL, ADD game_version VARCHAR(255) NOT NULL, ADD map_id INT NOT NULL, ADD platform_id VARCHAR(255) NOT NULL, ADD queue_id INT NOT NULL, ADD teams LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD tournament_code VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP match_id, DROP participants, DROP game_creation, DROP game_duration, DROP game_end_timestamp, DROP game_id, DROP game_mode, DROP game_type, DROP game_version, DROP map_id, DROP platform_id, DROP queue_id, DROP teams, DROP tournament_code');
    }
}
