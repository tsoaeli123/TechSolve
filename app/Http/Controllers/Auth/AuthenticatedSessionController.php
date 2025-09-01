<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
    public function store(Request $request): RedirectResponse
    {
        // Validate input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Find the user by email
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email.']);
        }

        // Role-based password check
        if ($user->role === 'admin') {
            // Plain password for admin
            if ($credentials['password'] !== $user->password) {
                return back()->withErrors(['password' => 'Incorrect password for admin.']);
            }
        } else {
            // Hashed password for teacher/student
            if (!Hash::check($credentials['password'], $user->password)) {
                return back()->withErrors(['password' => 'Incorrect password.']);
            }

            // Optional: Only allow active users to log in
            if ($user->status !== 'Active') {
                return back()->withErrors(['email' => 'Your account is pending admin approval.']);
            }
        }

        // Log in the user
        Auth::login($user);

        $request->session()->regenerate();

        // Redirect based on role
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
