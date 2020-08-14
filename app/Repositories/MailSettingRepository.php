<?php

namespace App\Repositories;

use App\Setting;

class MailSettingRepository implements MailSettingRepositoryInterface
{
    /**
     * Get Mail Setting.
     *
     * @return object
     */
    public function getMailSettings(): object
    {
        return Setting::where('group', 'mail')->get();
    }

    /**
     * Create | update mail setting.
     *
     * @param object $request
     * @return bool|int
     */
    public function saveSetting(object $request): int
    {
        $data = $request->all();
        foreach ($data as $key => $field) {
            if (!in_array($key, ['_method', '_token'])) {
                $slug = implode('.', ['mail', $key]);
                $setting = Setting::firstOrNew(['key' => $slug]);
                $setting->key = $slug;
                $setting->display_name = implode(' ', ['Mail', ucfirst($key)]);
                $setting->value = $request->get($key) ?? '';
                $setting->details = '';
                $setting->type = 'text';
                $setting->order = 0;
                $setting->group = 'mail';
                $setting->save();
            }
        }

        return true;
    }
}

