<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200826091310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates `user_group`, `user_group_user` tables and its relationships';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE `user_group` (
                id CHAR(36) NOT NULL PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                owner_id CHAR(36) NOT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                INDEX IDX_user_group_name (name),
                INDEX IDX_user_group_owner_id (owner_id),
                CONSTRAINT FK_user_group_owner_id FOREIGN KEY (owner_id) REFERENCES `user` (id) ON UPDATE CASCADE ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );

        $this->addSql('CREATE TABLE `user_group_user` (
                user_id CHAR(36) NOT NULL,
                group_id CHAR(36) NOT NULL,
                UNIQUE U_user_id_group_id (user_id, group_id),
                CONSTRAINT FK_user_group_user_user_id FOREIGN KEY (user_id) REFERENCES `user` (id) ON UPDATE CASCADE ON DELETE CASCADE,
                CONSTRAINT FK_user_group_user_group_id FOREIGN KEY (group_id) REFERENCES `user_group` (id) ON UPDATE CASCADE ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `user_group_user`');
        $this->addSql('DROP TABLE `user_group`');
    }
}
