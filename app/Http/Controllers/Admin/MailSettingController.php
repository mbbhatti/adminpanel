<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\MailSettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class MailSettingController extends Controller
{
    /**
     * @var MailSettingRepository
     */
    protected $mailSetting;

    /**
     * MenuController constructor.
     *
     * @param MailSettingRepository $mailSetting
     */
    public function __construct(MailSettingRepository $mailSetting)
    {
        $this->mailSetting = $mailSetting;
    }

    /**
     * Show mail setting.
     *
     * @return View
     */
    public function show()
    {
        $data = $this->mailSetting->getMailSettings();
        $mail = [];
        foreach ($data as $d) {
            $key = explode('.',$d->key)[1];
            $mail[$key] = $d->value;
        }

        return view('Admin\Setting\mail\show', compact('mail'));
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
            'server' => 'required',
            'port' => 'required',
            'login' => 'required',
            'password' => 'required'
        ];

        return Validator::make($data, $rules);
    }

    /**
     * Update email setting
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request)
    {
        // Validation
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect('admin/settings/mail')->withErrors($validator);
        }

        // Save or update record
        if ($this->mailSetting->saveSetting($request)) {
            return redirect()->back()->with('success', 'Successfully updated mail setting.');
        }

        return redirect()->back()->with('error', 'Setting request has error!');
    }

    public function sendEmail(Request $request)
    {
        // Set basic email parameters
        emailSetting();

        $data = [
            'to' => $request->get('email'),
            'subject' => $request->get('subject'),
            'content' => $request->get('message'),
            'fromEmail' => getenv('MAIL_FROM_ADDRESS'),
            'fromName' => getenv('MAIL_FROM_NAME')
        ];

        // Send Email
        Mail::to($request->get('email'))->send(new \App\Mail\Mail($data));

        return redirect()->back()->with('success', 'Email send Successfully.');
    }
}

