<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Show user login page.
     *
     * @return View
     */
    public function show()
    {
        if (Auth::user()) {
            return redirect()->route('dashboard');
        }

        return view('Admin\Auth\login');
    }

    /**
     * Validate incoming request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // validate rules for the inputs
        return Validator::make($data, [
            'email'    => 'required|email',
            'password' => 'required|alphaNum|min:6'
        ]);
    }

    /**
     * User login.
     *
     * @param Request $request
     * @return RedirectResponse | Redirector
     */
    public function login(Request $request)
    {
        // Form data validation
        $validator = $this->validator($request->all());

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput($request->except(['password']));
        } else {

            // create our user data for the authentication
            $user = [
                'email'     => $request->get('email'),
                'password'  => $request->get('password')
            ];
            $remember = $request->has('remember') ? true : false;

            // attempt to do the login
            if (auth()->attempt($user, $remember)) {

                // validation successful!
                return redirect('admin/dashboard');

            } else {

                // validation not successful, send back to form
                return redirect('admin/login')->with('error','Username or password is incorrect');

            }
        }
    }

    /**
     * User logout.
     *
     * @return RedirectResponse | Redirector
     */
    public function logout()
    {
        Auth::logout();

        return redirect('admin/login');
    }
}

