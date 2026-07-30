@extends('layouts.admin')

@section('title', $user ? 'Edit Akun Admin' : 'Tambah Akun Admin')

@section('content')
<div class="max-w-xl">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-sky-600 transition-colors font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Manajemen Akun
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-100 to-emerald-100 text-sky-600 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">{{ $user ? 'Edit Akun' : 'Buat Akun Baru' }}</h3>
                <p class="text-xs text-slate-500">{{ $user ? 'Perbarui informasi akun admin' : 'Buat akun admin baru untuk mengakses panel' }}</p>
            </div>
        </div>

        <form action="{{ $user ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST" class="space-y-6">
            @csrf
            @if($user) @method('PUT') @endif

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" required
                    value="{{ old('name', $user->name ?? '') }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-sky-400 focus:ring-2 focus:ring-sky-100 text-sm transition-colors @error('name') border-rose-400 bg-rose-50 @enderror"
                    placeholder="Masukkan nama lengkap">
                @error('name')
                    <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email <span class="text-rose-500">*</span></label>
                <input type="email" name="email" id="email" required
                    value="{{ old('email', $user->email ?? '') }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-sky-400 focus:ring-2 focus:ring-sky-100 text-sm transition-colors @error('email') border-rose-400 bg-rose-50 @enderror"
                    placeholder="contoh@email.com">
                @error('email')
                    <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="jabatan" class="block text-sm font-semibold text-slate-700 mb-2">Jabatan</label>
                <input type="text" name="jabatan" id="jabatan"
                    value="{{ old('jabatan', $user->jabatan ?? '') }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-sky-400 focus:ring-2 focus:ring-sky-100 text-sm transition-colors @error('jabatan') border-rose-400 bg-rose-50 @enderror"
                    placeholder="Contoh: Operator Desa">
                @error('jabatan')
                    <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-semibold text-slate-700 mb-2">Role <span class="text-rose-500">*</span></label>
                <select name="role" id="role" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-sky-400 focus:ring-2 focus:ring-sky-100 text-sm transition-colors @error('role') border-rose-400 bg-rose-50 @enderror">
                    <option value="">Pilih Role</option>
                    <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin Staff</option>
                    {{-- <option value="super_admin" {{ old('role', $user->role ?? '') === 'super_admin' ? 'selected' : '' }}>Super Admin</option> --}}
                </select>
                @error('role')
                    <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="border-t border-slate-100 pt-6">
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                    Password {{ $user ? '(Opsional — kosongkan jika tidak ingin diubah)' : '' }} <span class="text-rose-500">{{ $user ? '' : '*' }}</span>
                </label>
                <div class="relative">
                    <input type="password" name="password" id="password" {{ $user ? '' : 'required' }}
                        class="w-full pl-4 pr-11 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-sky-400 focus:ring-2 focus:ring-sky-100 text-sm transition-colors outline-none @error('password') border-rose-400 bg-rose-50 @enderror"
                        placeholder="Minimal 8 karakter">
                    <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer focus:outline-none" title="Tampilkan/Sembunyikan Kata Sandi">
                        <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg class="w-5 h-5 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.018 10.018 0 014.122-.973c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"/></svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full pl-4 pr-11 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-sky-400 focus:ring-2 focus:ring-sky-100 text-sm transition-colors outline-none"
                        placeholder="Ulangi password">
                    <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer focus:outline-none" title="Tampilkan/Sembunyikan Kata Sandi">
                        <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg class="w-5 h-5 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.018 10.018 0 014.122-.973c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"/></svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-sky-600/20 transition-colors flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ $user ? 'Simpan Perubahan' : 'Buat Akun' }}
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 text-slate-500 hover:text-slate-700 text-sm font-semibold transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;
        const eyeIcon = btn.querySelector('.eye-icon');
        const eyeSlashIcon = btn.querySelector('.eye-slash-icon');
        
        if (input.type === 'password') {
            input.type = 'text';
            if (eyeIcon) eyeIcon.classList.add('hidden');
            if (eyeSlashIcon) eyeSlashIcon.classList.remove('hidden');
        } else {
            input.type = 'password';
            if (eyeIcon) eyeIcon.classList.remove('hidden');
            if (eyeSlashIcon) eyeSlashIcon.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection
