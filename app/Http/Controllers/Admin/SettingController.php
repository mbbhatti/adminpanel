<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class SettingController extends Controller
{
    /**
     * @var SettingRepository
     */
    protected $setting;

    /**
     * MenuController constructor.
     *
     * @param SettingRepository $setting
     */
    public function __construct(SettingRepository $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Show settings.
     *
     * @return View
     */
    public function show()
    {
        $data = $this->setting->getAllSettings();
        $settings = [];
        $settings['General'] = [];
        foreach ($data as $d) {
            if ($d->group == '' || $d->group == 'General') {
                $settings['General'][] = $d;
            } else {
                $settings[$d->group][] = $d;
            }
        }
        if (count($settings['General']) == 0) {
            unset($settings['General']);
        }

        $groupsData = $this->setting->getGroups();
        $groups = [];
        foreach ($groupsData as $group) {
            if ($group->group != '') {
                $groups[$group->group] = $group->group;
            }
        }
        $active = (request()->session()->has('setting_tab'))
            ? request()->session()->get('setting_tab')
            : old('setting_tab', key($settings));

        /*$types = [
            '' => 'Choose Type',
            'text' => 'Textbox',
            'text_area' => 'Textarea',
            'rich_text_box' => 'Rich Textbox',
            'code_editor' => 'Code Editor',
            'checkbox' => 'Checkbox',
            'radio_btn' => 'Radio Button',
            'select_dropdown' => 'Select Dropdown',
            'file' => 'File',
            'image' => 'Image'
        ];*/

        $types = [
            '' => 'Choose Type',
            'text' => 'Textbox',
            'text_area' => 'Textarea',
            'rich_text_box' => 'Rich Textbox',
            'checkbox' => 'Checkbox',
            'file' => 'File',
            'image' => 'Image'
        ];

        return view(
            'Admin\Setting\general\show',
            compact('settings', 'groups', 'active', 'types')
        );
    }

    /**
     * Validate incoming request.
     *
     * @param  array  $data use for request data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'key' =>  'required|string|unique:settings,key'
        ];

        return Validator::make($data, $rules);
    }

    /**
     * Create setting field.
     *
     * @param Request $request
     * @return RedirectResponse| Redirector
     */
    public function create(Request $request)
    {
        // Get data
        $data = $request->all();
        $key = implode('.', [Str::slug($data['group']), $data['key']]);
        $data['key'] = $key;

        // Validation
        $validator = $this->validator($data);
        if ($validator->fails()) {
            return redirect('admin/settings')->withErrors($validator);
        }

        request()->flashOnly('setting_tab');
        if ($this->setting->saveSetting($data)) {
            return redirect()->back()->with('success', 'Successfully created setting.');
        }

        return redirect()->back()->with('error', 'Setting request has error!');
    }

    public function update(Request $request)
    {
        $this->setting->updateSetting($request);
        request()->flashOnly('setting_tab');

        return redirect()->back()->with('success', 'Successfully saved setting.');
    }

    public function moveUp($id)
    {
        $response = $this->setting->move($id, 'up');
        if ($response == false) {
            return redirect()->back()->with('error', 'This is already at the top of the list');
        }

        request()->session()->flash('setting_tab', $response);

        return redirect()->back()->with('success', 'Order has been moved up');

    }

    public function moveDown($id)
    {
        $response = $this->setting->move($id, 'down');
        if ($response == false) {
            return redirect()->back()->with('error', 'This is already at the bottom of the list');
        }

        request()->session()->flash('setting_tab', $response);

        return redirect()->back()->with('success', 'Order has been moved down');
    }

    /**
     * Delete menu.
     *
     * @param int $id
     * @return RedirectResponse | Redirector
     */
    public function delete($id)
    {
        $setting = $this->setting->getGroupById($id);
        request()->session()->flash('setting_tab', $setting->group);

        if ($this->setting->deleteSettingRow($id)) {
            return redirect('admin/settings')->with('success', 'Successfully deleted setting.');
        }

        return redirect('admin/menus')->withErrors(['Setting key does not exist!']);
    }

    public function deleteValue($id)
    {
        $response = $this->setting->deleteValue($id);
        request()->session()->flash('setting_tab', $response);

        return redirect('admin/settings')->with('success', 'Successfully removed value.');
    }
}

