<?php
declare(strict_types=1);

/**
 * Migration: add_last_logged_at
 * Generated: 2026-07-18 07:46:25
 */
final class MigrationVersion_20260718_074625
{
    public function up(\Neo\Core\Database\DatabaseManager $db): void
    {
        if (!$this->columnExists($db, 'administrator', 'last_logged_at')) {
            $db->execute('ALTER TABLE `administrator` ADD COLUMN `last_logged_at` datetime');
        }

        if (!$this->columnExists($db, 'administrator_role', 'textColor')) {
            $db->execute('ALTER TABLE `administrator_role` ADD COLUMN `textColor` varchar(10) NOT NULL');
        }

        if (!$this->columnExists($db, 'administrator_role', 'backgroundColor')) {
            $db->execute('ALTER TABLE `administrator_role` ADD COLUMN `backgroundColor` varchar(10) NOT NULL');
        }
    }

    public function down(\Neo\Core\Database\DatabaseManager $db): void
    {
        if ($this->columnExists($db, 'administrator_role', 'backgroundColor')) {
            $db->execute('ALTER TABLE `administrator_role` DROP COLUMN `backgroundColor`');
        }
        if ($this->columnExists($db, 'administrator_role', 'textColor')) {
            $db->execute('ALTER TABLE `administrator_role` DROP COLUMN `textColor`');
        }
        if ($this->columnExists($db, 'administrator', 'last_logged_at')) {
            $db->execute('ALTER TABLE `administrator` DROP COLUMN `last_logged_at`');
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