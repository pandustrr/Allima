<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        // Tambahkan password sementara untuk setiap user
        $users->getCollection()->transform(function ($user) {
            $user->tempPassword = $this->getTemporaryPassword($user);
            return $user;
        });

        return view('admin.users.index', compact('users'));
    }

    private function getTemporaryPassword(User $user)
    {
        // Ambil dari session atau return null jika tidak ada
        return session('user_'.$user->id.'_password');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Simpan password asli ke session sebelum di-hash
        session(['user_new_password' => $request->password]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        // Pindahkan ke session user yang baru dibuat
        session(['user_'.$user->id.'_password' => session('user_new_password')]);
        session()->forget('user_new_password');

        return redirect()
            ->route('admin.users.index')
            ->with([
                'success' => 'User berhasil ditambahkan!',
            ]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'tempPassword' => session('user_'.$user->id.'_password')
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = ['username' => $request->username];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            session(['user_'.$user->id.'_password' => $request->password]);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        // Hapus session password saat user dihapus
        session()->forget('user_'.$user->id.'_password');

        $user->delete();
        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}
