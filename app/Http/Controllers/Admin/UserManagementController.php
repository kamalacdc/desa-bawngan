<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    /**
     * Display a listing of admin users.
     */
    public function index()
    {
        $query = User::whereIn('role', ['super_admin', 'admin']);

        if (\Illuminate\Support\Facades\DB::connection()->getDriverName() === 'mysql' || \Illuminate\Support\Facades\DB::connection()->getDriverName() === 'mariadb') {
            $query->orderByRaw("FIELD(role, 'super_admin', 'admin')");
        } else {
            $query->orderBy('role', 'desc');
        }

        $users = $query->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new admin user.
     */
    public function create()
    {
        return view('admin.users.form', ['user' => null]);
    }

    /**
     * Store a newly created admin user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'role' => ['required', Rule::in(['admin'])],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib dipilih.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user = User::create($validated);

        ActivityLog::log('user_create', "Super Admin membuat akun pengguna baru: \"{$user->name}\" ({$user->role})", $user);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun admin berhasil dibuat.');
    }

    /**
     * Show the form for editing an admin user.
     */
    public function edit(User $user)
    {
        // Prevent editing peer Super Admin accounts
        if ($user->isSuperAdmin() && $user->id !== Auth::id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Akun sesama Super Admin tidak dapat diubah dari manajemen pengguna.');
        }

        return view('admin.users.form', compact('user'));
    }

    /**
     * Update the specified admin user.
     */
    public function update(Request $request, User $user)
    {
        // Prevent updating peer Super Admin accounts
        if ($user->isSuperAdmin() && $user->id !== Auth::id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Akun sesama Super Admin tidak dapat diubah dari manajemen pengguna.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'role' => ['required', Rule::in(['super_admin', 'admin'])],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib dipilih.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // Only update password if provided
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        ActivityLog::log('user_update', "Super Admin memperbarui data akun: \"{$user->name}\"", $user);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun admin berhasil diperbarui.');
    }

    /**
     * Remove the specified admin user.
     */
    public function destroy(User $user)
    {
        // Prevent deleting any Super Admin account
        if ($user->isSuperAdmin()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Akun Super Admin tidak dapat dihapus.');
        }

        $name = $user->name;
        $user->delete();

        ActivityLog::log('user_delete', "Super Admin menghapus akun pengguna: \"{$name}\"");

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun admin berhasil dihapus.');
    }
}
