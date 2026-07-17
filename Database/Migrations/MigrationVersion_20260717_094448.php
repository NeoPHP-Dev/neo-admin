<?php
declare(strict_types=1);

/**
 * Migration: add_avatar_first_last_name
 * Generated: 2026-07-17 09:44:48
 */
final class MigrationVersion_20260717_094448
{
    public function up(\Neo\Core\Database\DatabaseManager $db): void
    {
        if (!$this->columnExists($db, 'administrator', 'avatar')) {
            $db->execute('ALTER TABLE `administrator` ADD COLUMN `avatar` varchar(255)');
        }

        if (!$this->columnExists($db, 'administrator', 'firstname')) {
            $db->execute('ALTER TABLE `administrator` ADD COLUMN `firstname` varchar(50)');
        }

        if (!$this->columnExists($db, 'administrator', 'lastname')) {
            $db->execute('ALTER TABLE `administrator` ADD COLUMN `lastname` varchar(80)');
        }
    }

    public function down(\Neo\Core\Database\DatabaseManager $db): void
    {
        if ($this->columnExists($db, 'administrator', 'lastname')) {
            $db->execute('ALTER TABLE `administrator` DROP COLUMN `lastname`');
        }
        if ($this->columnExists($db, 'administrator', 'firstname')) {
            $db->execute('ALTER TABLE `administrator` DROP COLUMN `firstname`');
        }
        if ($this->columnExists($db, 'administrator', 'avatar')) {
            $db->execute('ALTER TABLE `administrator` DROP COLUMN `avatar`');
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