<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
  
    public function verifyOtpPage(Request $request): View
    {
        return view('pages.auth.verify-otp', ['title' => 'Reset Password']);
    }
    
    public function create(Request $request): View
    {
        return view('pages.auth.confirm-password', ['title' => 'Comfirm Password']);
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $email = session('reset_email');

        if (!$email) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Your session has expired. Please request a new OTP.'
                ]);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'User not found.'
                ]);
        }

        $verify = (new Otp())->validate(
            $user->email,
            $request->otp
        );

        if (!$verify->status) {
            return back()->withErrors([
                'otp' => 'Invalid or expired OTP.'
            ]);
        }

        session([
            'otp_verified' => true,
        ]);

        return redirect()->route('password.reset');
    }
}
