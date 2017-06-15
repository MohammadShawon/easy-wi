<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;

// Trait
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

// Password Broker Facade
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails;

    /**
     * Shows form to request password reset
     *
     * @return object
     */
    public function showLinkRequestForm()
    {
        return view('global.passwords.email');
    }

    /**
     * Password Broker for Seller Model
     *
     * @return object
     */
    public function broker()
    {
        return Password::broker('admins');
    }
}
