<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\User;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware());
    }
    
    protected function validateSendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['phone' => 'required']);
    }
    
    protected function getSendResetLinkEmailCredentials(Request $request)
    {
        $user = User::where('phone', $request->input('phone'))->first();
        return ['email' => $user->email];
    }
}
