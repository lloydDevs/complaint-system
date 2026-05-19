<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            // Attempt to authenticate credentials
            $request->authenticate();

            // If it passes, regenerate session to prevent session fixation
            $request->session()->regenerate();

            // Log successful login
            ActivityLog::create([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
                'action' => 'Login',
                'description' => 'User successfully logged into the DA-CARE MIMAROPA portal.',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->intended(route('admin.dashboard', absolute: false));

        } catch (ValidationException $e) {

            // Log the UNSUCCESSFUL login attempt
            ActivityLog::create([
                'user_id' => null, // No user ID since authentication failed
                'user_name' => 'Guest / Unauthenticated',
                'action' => 'Failed Login',
                // Record the exact input email string securely
                'description' => 'Failed login attempt using email: '.$request->input('email'),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Rethrow the validation exception so Laravel displays errors to the user
            throw $e;
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Capture user details right before logging out destroys the session context
        $userId = auth()->id();
        $userName = auth()->user()?->name;

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Log logout event
        ActivityLog::create([
            'user_id' => $userId,
            'user_name' => $userName,
            'action' => 'Logout',
            'description' => 'User successfully logged out of the session.',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect('/');
    }
}
