<?php

namespace App\Repositories;

interface MailSettingRepositoryInterface
{
    /**
     * Get Mail Setting.
     *
     * @return object
     */
    public function getMailSettings(): object;

    /**
     * Create | update mail setting.
     *
     * @param object $request
     * @return bool|int
     */
    public function saveSetting(object $request): int;
}

