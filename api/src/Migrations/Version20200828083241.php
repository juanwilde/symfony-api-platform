<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200828083241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates `category` table and its relationships';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE `category` (
                id CHAR(36) NOT NULL PRIMARY KEY,
                name VARCHAR(50) NOT NULL,
                type VARCHAR(8) NOT NULL,
                owner_id CHAR(36) NOT NULL,
                group_id CHAR(36) DEFAULT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                INDEX IDX_category_owner_id (owner_id),
                INDEX IDX_category_group_id (group_id),
                CONSTRAINT FK_category_owner_id FOREIGN KEY (owner_id) REFERENCES `user` (id) ON UPDATE CASCADE ON DELETE CASCADE,
                CONSTRAINT FK_category_group_id FOREIGN KEY (group_id) REFERENCES `user_group` (id) ON UPDATE CASCADE ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `category`');
    }
}
