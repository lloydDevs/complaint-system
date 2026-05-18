<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Log the profile update event
        ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'action' => 'Profile Updated',
            'description' => 'User updated their account credentials/profile settings.',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Cache user identities right before deletion removes the database records
        $userId = $user->id;
        $userName = $user->name;
        $userEmail = $user->email;

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Log the account deletion
        ActivityLog::create([
            'user_id' => null, // Set to null since database item is gone, keeping structural constraints intact
            'user_name' => $userName,
            'action' => 'Delete Account',
            'description' => "Account belonging to {$userName} ({$userEmail}) was permanently deleted from the system.",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return Redirect::to('/');
    }
}
