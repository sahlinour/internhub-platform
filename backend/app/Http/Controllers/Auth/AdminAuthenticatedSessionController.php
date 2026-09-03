<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class AdminAuthenticatedSessionController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Admin/Auth/Login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::guard('admin')->attempt(
            $credentials,
            $request->boolean('remember')
        )) {
            throw ValidationException::withMessages([
                'email' => 'Invalid credentials.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::guard('admin')->user();

        if ($user->role !== 'Admin') {
            Auth::guard('admin')->logout();

            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Administrator access only.',
            ]);
        }

        return redirect()->route('admin.dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}