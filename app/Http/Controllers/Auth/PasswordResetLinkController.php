<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Models\User;
use App\Helpers\SendOtp;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('pages.auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Email not found'
                ]);
        }

        SendOtp::send($user, 'forgot_password');

        session([
            'reset_email' => $user->email
        ]);

        return redirect()->route('verify.otp')->with(
            'status',
            'OTP sent to your email successfully.'
        );
    }
}
