<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the profile page with tabs.
     */
    public function index(Request $request): View
    {
        return view('pages.profile', [
            'user'  => $request->user(),
            'title' => 'Profile',
        ]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

 
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete the old avatar from storage (public disk)
            Helper::storageDeleteFile($user->avatar);

            // Store the new avatar using the helper
            $user->avatar = Helper::fileUploadStorage(
                $request->file('avatar'),
                'avatars',
                $user->name
            );
        }

        // Handle thumbnail (thi) upload
        if ($request->hasFile('thi')) {
            // Delete the old thi image from storage (public disk)
            Helper::storageDeleteFile($user->thi);

            // Store the new thi image using the helper
            $user->thi = Helper::fileUploadStorage(
                $request->file('thi'),
                'thumbnails',
                $user->name
            );
        }

        // Update name and email
        $user->fill($request->only('name', 'email'));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::back()->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
