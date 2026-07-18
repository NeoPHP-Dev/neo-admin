<?php
declare(strict_types=1);

/**
 * Migration: add_administrator_role_id
 * Generated: 2026-07-17 19:47:35
 */
final class MigrationVersion_20260717_194735
{
    public function up(\Neo\Core\Database\DatabaseManager $db): void
    {
        if (!$this->columnExists($db, 'administrator', 'role_id')) {
            $db->execute('ALTER TABLE `administrator` ADD COLUMN `role_id` int NOT NULL');
        }
    }

    public function down(\Neo\Core\Database\DatabaseManager $db): void
    {
        if ($this->columnExists($db, 'administrator', 'role_id')) {
            $db->execute('ALTER TABLE `administrator` DROP COLUMN `role_id`');
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