<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SettingsController extends Controller
{
    /**
     * Display the settings dashboard.
     * View path: resources/views/admin/settings/index.blade.php
     */
    public function index()
    {
        $admins = User::where('is_admin', true)
            ->leftJoin('sessions', 'users.id', '=', 'sessions.user_id')
            ->select('users.*', DB::raw('MAX(sessions.last_activity) as session_activity'))
            ->groupBy('users.id')
            ->get();

        return view('admin.settings.index', compact('admins'));
    }

    /**
     * Create a new administrator account.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true, // Explicitly setting the admin flag
        ]);

        // Log when a new admin is provisioned
        ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'action' => 'Manage Admin',
            'description' => "Provisioned a new administrator account for {$admin->name} ({$admin->email}).",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', 'Administrator account provisioned.');
    }

    /**
     * Remove an administrator.
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()->withErrors(['error' => 'Self-deletion is prohibited.']);
        }

        // Cache the target admin's information right before deleting them
        $targetName = $user->name;
        $targetEmail = $user->email;

        $user->delete();

        // Log when an admin account's access is revoked
        ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'action' => 'Manage Admin',
            'description' => "Revoked administrative access and deleted account for {$targetName} ({$targetEmail}).",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->back()->with('success', 'Access revoked.');
    }
}
