<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (session()->has('auth_user')) {
            return redirect()->route('barang.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'npk' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'password' => 'required|string|min:6',
        ]);

        $userQuery = User::query();
        if (Schema::hasColumn('users', 'npk')) {
            $userQuery->where('npk', $validated['npk']);
        } else {
            $userQuery->where('email', $validated['npk']);
        }

        $user = $userQuery->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['npk' => 'NPK, Jabatan, atau Password tidak sesuai.'])->withInput();
        }

        if (Schema::hasColumn('users', 'jabatan') && strtolower($user->jabatan) !== strtolower($validated['jabatan'])) {
            return back()->withErrors(['jabatan' => 'Jabatan tidak sesuai dengan data pengguna.'])->withInput();
        }

        session(['auth_user' => [
            'id' => $user->id,
            'name' => $user->name,
            'npk' => $user->npk,
            'jabatan' => $user->jabatan,
            'level' => strtolower($user->level),            'theme' => Schema::hasColumn('users', 'theme') ? ($user->theme ?? 'dark') : 'dark',
            'language' => Schema::hasColumn('users', 'language') ? ($user->language ?? 'id') : 'id',        ]]);

        return redirect()->route('barang.dashboard');
    }

    public function logout()
    {
        session()->forget('auth_user');
        return redirect()->route('login')->with('success', 'Berhasil keluar dari aplikasi.');
    }
}
