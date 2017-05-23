<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\ResetsPasswords;

// Auth Facade
use Illuminate\Support\Facades\Auth;

// Password Broker Facade
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{

    // trait for handling reset Password
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/global';

    /**
     * Show form to seller where they can reset password
     *
     * @return object
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('global.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * returns Password broker of seller
     *
     * @return object
     */
    public function broker()
    {
        return Password::broker('admins');
    }

    /**
     * returns authentication guard of seller
     *
     * @return object
     */
    protected function guard()
    {
        return Auth::guard('web_admin');
    }
}
