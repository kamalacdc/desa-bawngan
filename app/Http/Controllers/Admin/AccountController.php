<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    /**
     * Show the unified profile & security management page.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('admin.account.profile', compact('user'));
    }

    /**
     * Show the change password page (redirects to unified profile page).
     */
    public function showChangePassword()
    {
        return redirect()->to(route('admin.account.profile') . '#password');
    }

    /**
     * Update user profile information (name, email, jabatan, avatar).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'avatar.image' => 'File foto profil harus berupa gambar.',
            'avatar.mimes' => 'Format foto yang diperbolehkan: JPG, JPEG, PNG, WEBP.',
            'avatar.max' => 'Ukuran file foto profil maksimal 2MB.',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        ActivityLog::log('profile_update', "Pengguna memperbarui profil akun: \"{$user->name}\"", $user);

        return redirect()
            ->route('admin.account.profile')
            ->with('success', 'Profil dan foto akun berhasil diperbarui.');
    }

    /**
     * Remove user avatar photo.
     */
    public function removeAvatar()
    {
        $user = Auth::user();

        if ($user->avatar) {
            if (Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->update(['avatar' => null]);
            ActivityLog::log('profile_avatar_remove', 'Pengguna menghapus foto profil akun.', $user);
        }

        return redirect()
            ->route('admin.account.profile')
            ->with('success', 'Foto profil berhasil dihapus.');
    }

    /**
     * Update the authenticated user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password baru minimal 8 karakter.',
        ]);

        Auth::user()->update([
            'password' => $request->password,
        ]);

        ActivityLog::log('change_password', 'Pengguna mengubah password akun pribadi.');

        return redirect()
            ->to(route('admin.account.profile') . '#password')
            ->with('success', 'Password berhasil diperbarui!');
    }
}
