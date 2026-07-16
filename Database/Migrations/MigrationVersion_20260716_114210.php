<?php
declare(strict_types=1);

/**
 * Migration: schema_update
 * Generated: 2026-07-16 11:42:10
 */
final class MigrationVersion_20260716_114210
{
    public function up(\Neo\Core\Database\DatabaseManager $db): void
    {
        if (!$this->tableExists($db, 'administrator')) {
            $db->execute('CREATE TABLE IF NOT EXISTS `administrator` (
        `id` int NOT NULL AUTO_INCREMENT,
        `username` varchar(150) NOT NULL,
        `password` varchar(255) NOT NULL,
        `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `deleted_at` datetime,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');
        }
    }

    public function down(\Neo\Core\Database\DatabaseManager $db): void
    {
        if ($this->tableExists($db, 'administrator')) {
            $db->execute('DROP TABLE IF EXISTS `administrator`');
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