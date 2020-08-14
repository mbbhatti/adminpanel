<?php

namespace App\Repositories;

interface SettingRepositoryInterface
{
    /**
     * Get Settings.
     *
     * @return object
     */
    public function getAllSettings(): object;

    /**
     * Get Groups
     *
     * @return object
     */
    public function getGroups(): object;

    /**
     * Get Group by id
     *
     * @param int $id
     * @return object
     */
    public function getGroupById(int $id): object;

    /**
     * Get Groups
     *
     * @param string $group
     * @return object
     */
    public function getMaxOrderByGroup(string $group): object;

    /**
     * Create Setting.
     *
     * @param object $request
     * @return int
     */
    public function saveSetting(object $request): int;

    /**
     * Update setting record.
     *
     * @param object $request
     * @return bool
     */
    public function updateSetting(object $request): bool;

    /**
     * Delete setting row.
     *
     * @param int $id
     * @return bool
     */
    public function deleteSettingRow(int $id): bool;

    /**
     * Empty field value
     *
     * @param int $id
     * @return string
     */
    public function deleteValue(int $id): string;

    /**
     * Get previous record order
     *
     * @param int $order
     * @param string $group
     * @return object
     */
    public function getPreviousOrder(int $order, string $group): object;

    /**
     * Get next record order
     *
     * @param int $order
     * @param string $group
     * @return object
     */
    public function getNextOrder(int $order, string $group): object;

    /**
     * Move field order
     *
     * @param int $id
     * @param string $type
     * @return bool
     */
    public function move(int $id, string $type): bool;
}

