<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeacherProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show teacher profile
    public function showProfile(): View
    {
        $teacher = Auth::user();
        return view('teacher.profile', compact('teacher'));
    }

    // Show edit form
    public function editProfile(): View
    {
        $teacher = Auth::user();
        return view('teacher.edit', compact('teacher')); // Blade is teacher/edit.blade.php
    }

    // Update profile
    public function updateProfile(Request $request): RedirectResponse
    {
        $teacher = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->id,
            'subject_specialization' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->subject_specialization = $request->subject_specialization;

        if ($request->password) {
            $teacher->password = Hash::make($request->password);
        }

        $teacher->save();

        return redirect()->route('teacher.profile')->with('success', 'Profile updated successfully.');
    }

    // Delete profile
    public function destroyProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $teacher = Auth::user();
        Auth::logout();
        $teacher->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Account deleted successfully.');
    }
}
