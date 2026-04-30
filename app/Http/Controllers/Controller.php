<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function requireAuth()
    {
        if (! session()->has('auth_user')) {
            return redirect()->route('login');
        }

        return null;
    }

    protected function currentUser(): ?array
    {
        return session('auth_user');
    }

    protected function currentRole(): string
    {
        return strtolower(session('auth_user.level') ?? session('auth_user')['level'] ?? '');
    }

    protected function requireRole(array $roles, string $redirectRoute = 'barang.dashboard')
    {
        $currentRole = $this->currentRole();

        if (! in_array($currentRole, array_map('strtolower', $roles), true)) {
            return redirect()->route($redirectRoute)->with('error', 'Akses ditolak.');
        }

        return null;
    }
}
