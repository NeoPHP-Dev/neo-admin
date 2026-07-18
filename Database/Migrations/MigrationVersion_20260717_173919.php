<?php
declare(strict_types=1);

/**
 * Migration: add_administrator_role_table
 * Generated: 2026-07-17 17:39:19
 */
final class MigrationVersion_20260717_173919
{
    public function up(\Neo\Core\Database\DatabaseManager $db): void
    {
        if (!$this->tableExists($db, 'administrator_role')) {
            $db->execute('CREATE TABLE IF NOT EXISTS `administrator_role` (
        `id` int NOT NULL AUTO_INCREMENT,
        `label` varchar(100) NOT NULL,
        `description` text NOT NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `deleted_at` datetime,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');
        }
    }

    public function down(\Neo\Core\Database\DatabaseManager $db): void
    {
        if ($this->tableExists($db, 'administrator_role')) {
            $db->execute('DROP TABLE IF EXISTS `administrator_role`');
        }
    }

    private function tableExists(\Neo\Core\Database\DatabaseManager $db, string $table): bool
    {
        $row = $db->fetch(
            'SELECT 1 FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table',
            ['table' => $table]
        );

        return $row !== null;
    }

    private function columnExists(\Neo\Core\Database\DatabaseManager $db, string $table, string $column): bool
    {
        $row = $db->fetch(
            'SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table AND COLUMN_NAME = :column',
            ['table' => $table, 'column' => $column]
        );

        return $row !== null;
    }
}