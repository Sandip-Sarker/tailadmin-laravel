<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }


    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if (! session('otp_verified')) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'OTP verification required.'
                ]);
        }

        $user = User::where(
            'email',
            session('reset_email')
        )->first();

        if (! $user) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'User not found.'
                ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        session()->forget([
            'reset_email',
            'otp_verified',
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Password changed successfully.');
    }
}
