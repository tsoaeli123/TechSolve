<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:teacher,student'],
            'subject_specialization' => ['required_if:role,teacher', 'nullable', 'string', 'max:255'],
            'class_grade' => ['required_if:role,student', 'nullable', 'string', 'max:255'],
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'subject_specialization' => $request->role === 'teacher' ? $request->subject_specialization : null,
            'class_grade' => $request->role === 'student' ? $request->class_grade : null,
            'status' => 'Inactive', // admin approval required
        ]);

        // Trigger registered event
        event(new Registered($user));

        // Redirect with message
        return redirect()->route('login')
            ->with('message', 'Your account has been created and is pending admin approval.');
    }
}
