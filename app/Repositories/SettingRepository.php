<?php

namespace App\Repositories;

use App\Setting;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Storage;

class SettingRepository implements SettingRepositoryInterface
{
    /**
     * @var Helper
     */
    protected $helper;

    /**
     * SettingRepository constructor.
     * @param Helper $helper
     */
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Get Settings.
     *
     * @return object
     */
    public function getAllSettings(): object
    {
        return Setting::where('group', '!=', 'mail')->orderBy('order', 'ASC')->get();
    }

    /**
     * Get Groups
     *
     * @return object
     */
    public function getGroups(): object
    {
        return Setting::select('group')->distinct()->get();
    }

    /**
     * Get Group by id
     *
     * @param int $id
     * @return object
     */
    public function getGroupById(int $id): object
    {
        return Setting::find($id);
    }

    /**
     * Get Groups
     *
     * @param string $group
     * @return object
     */
    public function getMaxOrderByGroup(string $group): object
    {
        $order = Setting::select('order')
            ->where('group', Str::slug($group))
            ->orderBy('order', 'DESC')
            ->first();

        return $order->order;
    }

    /**
     * Create Setting.
     *
     * @param object $request
     * @return int
     */
    public function saveSetting(object $request): int
    {
        $order = $this->getMaxOrderByGroup($request['group']);
        $setting = Setting::firstOrNew(['key' => $request['key']]);
        $setting->key = $request['key'];
        $setting->display_name = $request['display_name'];
        $setting->value = $request['value'] ?? '';
        $setting->details = $request['details'] ?? '';
        $setting->type = $request['type'];
        $setting->order = $order + 1;
        $setting->group = $request['group'];
        $setting->save();

        return $setting->id;
    }

    /**
     * Update setting record.
     *
     * @param object $request
     * @return bool
     */
    public function updateSetting(object $request): bool
    {
        $settings = Setting::all()->where('group', '!=' , 'mail');
        foreach ($settings as $setting) {
            $content =  $this->helper->getContentBasedOnType($request, 'settings', (object) [
                'type'    => $setting->type,
                'field'   => str_replace('.', '_', $setting->key),
                'group'   => $setting->group,
            ], $setting->details);

            if ($setting->type == 'image' && $content == null) {
                continue;
            }

            if ($setting->type == 'file' && $content == null) {
                continue;
            }

            $key = preg_replace('/^'.Str::slug($setting->group).'./i', '', $setting->key);

            $setting->group = $request->input(str_replace('.', '_', $setting->key).'_group');
            $setting->key = implode('.', [Str::slug($setting->group), $key]);
            $setting->value = $content;
            $setting->save();
        }

        return true;
    }

    /**
     * Delete setting row.
     *
     * @param int $id
     * @return bool
     */
    public function deleteSettingRow(int $id): bool
    {
        return Setting::where('id', $id)->delete();
    }

    /**
     * Empty field value
     *
     * @param int $id
     * @return string
     */
    public function deleteValue(int $id): string
    {
        $setting = Setting::find($id);
        $group = $setting->group;
        if (isset($setting->id)) {
            // If the type is an image... Then delete it
            if ($setting->type == 'image') {
                if (Storage::disk(config('storage.disk'))->exists($setting->value)) {
                    Storage::disk(config('storage.disk'))->delete($setting->value);
                }
            }
            $setting->value = '';
            $setting->save();
        }

        return $group;
    }

    /**
     * Get previous record order
     *
     * @param int $order
     * @param string $group
     * @return object
     */
    public function getPreviousOrder(int $order, string $group): object
    {
        return Setting::where('order', '<', $order)
            ->where('group', $group)
            ->orderBy('order', 'DESC')
            ->first();
    }

    /**
     * Get next record order
     *
     * @param int $order
     * @param string $group
     * @return object
     */
    public function getNextOrder(int $order, string $group): object
    {
        return Setting::where('order', '>', $order)
            ->where('group', $group)
            ->orderBy('order', 'ASC')
            ->first();
    }

    /**
     * Move field order
     *
     * @param int $id
     * @param string $type
     * @return bool
     */
    public function move(int $id, string $type): bool
    {
        $setting = $this->getGroupById($id);
        $order = $setting->order;
        $group = $setting->group;

        if ($type == 'up') {
            $previousSetting = $this->getPreviousOrder($order, $group);
        } else {
            $previousSetting = $this->getNextOrder($order, $group);
        }

        if (isset($previousSetting->order)) {
            $setting->order = $previousSetting->order;
            $setting->save();
            $previousSetting->order = $order;
            $previousSetting->save();

            return $group;
        }

        return false;
    }
}

