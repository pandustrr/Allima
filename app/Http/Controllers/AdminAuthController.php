<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;


class AdminAuthController extends Controller
{
    /**
     * Menampilkan form login admin
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Pastikan username lowercase
        $credentials['username'] = strtolower($credentials['username']);

        Log::debug('Login attempt for admin:', $credentials);

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            Log::info('Admin logged in: ' . $credentials['username']);
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Login berhasil!');
        }

        Log::warning('Failed login attempt for admin: ' . $credentials['username']);
        return back()->withErrors([
            'username' => 'Username atau password tidak valid.',
        ])->onlyInput('username');
    }

    /**
     * Proses logout admin
     */
    public function logout(Request $request)
    {
        // Log aktivitas logout
        if (Auth::guard('admin')->check()) {
            Log::channel('admin')->info('Admin logged out', [
                'username' => Auth::guard('admin')->user()->username,
                'ip' => $request->ip()
            ]);
        }

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login')
            ->with('status', 'Anda telah logout.');
    }
}
