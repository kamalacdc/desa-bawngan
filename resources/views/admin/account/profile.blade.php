@extends('layouts.admin')

@section('title', 'Kelola Profil & Keamanan')

@section('content')

<div class="max-w-4xl space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-50 text-sky-800 text-xs font-extrabold tracking-wider uppercase border border-sky-200/70 mb-2">
                <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>Pengaturan Akun</span>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Kelola Profil & Keamanan</h2>
            <p class="text-xs text-slate-600 font-medium mt-1">Perbarui foto profil, biodata diri, dan kata sandi akun administrator Anda.</p>
        </div>
    </div>

    {{-- Header Profile Banner Card --}}
    <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-sky-950 to-slate-900 text-white rounded-3xl p-6 sm:p-8 shadow-md border border-slate-800">
        <div class="absolute right-0 top-0 -mt-10 -mr-10 w-72 h-72 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative flex flex-col sm:flex-row items-center sm:items-start gap-6 text-center sm:text-left">
            <div class="relative group shrink-0">
                <div class="w-24 h-24 rounded-3xl bg-gradient-to-tr from-sky-500 to-emerald-500 p-1 shadow-lg shadow-sky-950/40">
                    <div class="w-full h-full rounded-[22px] bg-slate-900 overflow-hidden flex items-center justify-center font-extrabold text-3xl text-white">
                        @if($user->avatar)
                            <img id="headerAvatarPreview" src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <span id="headerAvatarInitial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="space-y-2 flex-1 min-w-0">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                    <h3 class="text-2xl font-black tracking-tight text-white truncate">{{ $user->name }}</h3>
                    @if($user->isSuperAdmin())
                        <span class="px-3 py-1 rounded-full text-[11px] font-extrabold tracking-wider uppercase bg-amber-400/20 text-amber-300 border border-amber-400/30 shadow-xs">Super Admin</span>
                    @else
                        <span class="px-3 py-1 rounded-full text-[11px] font-extrabold tracking-wider uppercase bg-sky-400/20 text-sky-300 border border-sky-400/30 shadow-xs">Staf Admin</span>
                    @endif
                </div>
                
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-y-1 gap-x-4 text-xs">
                    <p class="text-sky-200/90 font-medium flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>{{ $user->email }}</span>
                    </p>
                    <p class="text-slate-300 font-semibold flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Jabatan: <strong class="text-white">{{ $user->jabatan ?? 'Administrator Portal' }}</strong></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Section 1: Information & Profile Photo --}}
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8 space-y-6">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center border border-sky-100 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Informasi Diri & Foto Profil</h3>
                <p class="text-xs text-slate-500 font-medium">Perbarui biodata dan foto profil resmi akun administrator Anda.</p>
            </div>
        </div>

        <form action="{{ route('admin.account.update-profile') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Avatar Upload Field --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Foto Profil Akun
                </label>
                
                <div class="flex flex-col sm:flex-row sm:items-center gap-5 p-4 bg-slate-50 border border-slate-200/80 rounded-2xl">
                    <div class="relative w-20 h-20 rounded-2xl overflow-hidden bg-slate-200 border border-slate-300 shrink-0 shadow-inner flex items-center justify-center font-black text-slate-500 text-2xl">
                        <img id="formAvatarPreview" src="{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}" class="w-full h-full object-cover {{ $user->avatar ? '' : 'hidden' }}">
                        <span id="formAvatarInitial" class="{{ $user->avatar ? 'hidden' : '' }}">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    
                    <div class="flex-1 space-y-2">
                        <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewAvatar(this)" class="w-full text-xs text-slate-700 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-sky-600 file:text-white hover:file:bg-sky-700 cursor-pointer">
                        <p class="text-[11px] text-slate-500 font-medium">Format yang didukung: JPG, PNG, WEBP (Maksimal 2 MB)</p>
                    </div>

                    @if($user->avatar)
                    <button type="button" onclick="document.getElementById('removeAvatarForm').submit();" class="px-4 py-2 rounded-xl text-xs font-extrabold text-rose-600 hover:bg-rose-100/70 bg-rose-50 border border-rose-200 transition-colors shrink-0 cursor-pointer flex items-center gap-2" title="Hapus Foto Profil">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>Hapus Foto</span>
                    </button>
                    @endif
                </div>
                @error('avatar')
                    <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                {{-- Nama Lengkap --}}
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required placeholder="Nama lengkap administrator" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 font-semibold @error('name') border-rose-400 bg-rose-50/50 @enderror">
                    @error('name')
                        <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required placeholder="email@domain.id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 font-semibold @error('email') border-rose-400 bg-rose-50/50 @enderror">
                    @error('email')
                        <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                {{-- Jabatan --}}
                <div>
                    <label for="jabatan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Jabatan / Posisi Admin
                    </label>
                    <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $user->jabatan) }}" placeholder="Contoh: Sekretaris Desa / Staf IT" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 font-semibold @error('jabatan') border-rose-400 bg-rose-50/50 @enderror">
                    @error('jabatan')
                        <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role (Readonly Badge Info) --}}
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Hak Akses Sistem
                    </label>
                    <div class="px-4 py-3 bg-slate-100 border border-slate-200 rounded-2xl flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $user->isSuperAdmin() ? 'bg-amber-500' : 'bg-sky-500' }}"></span>
                        <span class="text-xs font-bold text-slate-800">{{ $user->roleLabel() }}</span>
                        <span class="text-[11px] text-slate-500 font-medium ml-auto">(Hak akses tidak dapat diubah sendiri)</span>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-sky-700 to-emerald-600 hover:from-sky-800 hover:to-emerald-700 text-white text-xs font-extrabold rounded-2xl shadow-md hover:shadow-lg transition-all cursor-pointer flex items-center gap-2" style="background-color: #0369a1 !important; color: #ffffff !important;">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-white font-extrabold">Simpan Perubahan Profil</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Section 2: Security & Password --}}
    <div id="password" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8 space-y-6 scroll-mt-6">
        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Ubah Password Akun</h3>
                <p class="text-xs text-slate-500 font-medium">Perbarui kata sandi secara berkala untuk menjaga keamanan akun Anda.</p>
            </div>
        </div>

        <form action="{{ route('admin.account.update-password') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Current Password --}}
            <div>
                <label for="current_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Password Saat Ini <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <input type="password" name="current_password" id="current_password" required placeholder="Masukkan password lama Anda" class="w-full pl-4 pr-11 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 font-medium @error('current_password') border-rose-400 bg-rose-50/50 @enderror">
                    <button type="button" onclick="togglePasswordVisibility('current_password', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer focus:outline-none" title="Tampilkan/Sembunyikan Kata Sandi">
                        <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg class="w-4 h-4 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.018 10.018 0 014.122-.973c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"/></svg>
                    </button>
                </div>
                @error('current_password')
                    <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-6">
                {{-- New Password --}}
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Password Baru <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter" class="w-full pl-4 pr-11 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 font-medium @error('password') border-rose-400 bg-rose-50/50 @enderror">
                        <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer focus:outline-none" title="Tampilkan/Sembunyikan Kata Sandi">
                            <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg class="w-4 h-4 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.018 10.018 0 014.122-.973c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Konfirmasi Password Baru <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ulangi password baru" class="w-full pl-4 pr-11 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 font-medium">
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer focus:outline-none" title="Tampilkan/Sembunyikan Kata Sandi">
                            <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg class="w-4 h-4 eye-slash-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.018 10.018 0 014.122-.973c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-sky-700 to-emerald-600 hover:from-sky-800 hover:to-emerald-700 text-white text-xs font-extrabold rounded-2xl shadow-md hover:shadow-lg transition-all cursor-pointer flex items-center gap-2" style="background-color: #0369a1 !important; color: #ffffff !important;">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-white font-extrabold">Simpan Password Baru</span>
                </button>
            </div>
        </form>
    </div>

</div>

{{-- Hidden Form for Avatar Removal --}}
@if($user->avatar)
<form id="removeAvatarForm" action="{{ route('admin.account.remove-avatar') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endif

@push('scripts')
<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const formImg = document.getElementById('formAvatarPreview');
                const formInitial = document.getElementById('formAvatarInitial');
                const headerImg = document.getElementById('headerAvatarPreview');
                const headerInitial = document.getElementById('headerAvatarInitial');
                
                if (formImg) {
                    formImg.src = e.target.result;
                    formImg.classList.remove('hidden');
                }
                if (formInitial) formInitial.classList.add('hidden');
                
                if (headerImg) {
                    headerImg.src = e.target.result;
                    headerImg.classList.remove('hidden');
                } else if (headerInitial) {
                    headerInitial.parentElement.innerHTML = `<img id="headerAvatarPreview" src="${e.target.result}" class="w-full h-full object-cover">`;
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

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
