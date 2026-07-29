@extends('layouts.admin')

@section('title', 'Kelola Profil Desa')

@section('content')

<div class="max-w-3xl">
    <div class="mb-8">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-50 text-sky-800 text-xs font-extrabold tracking-wider uppercase border border-sky-200/70 mb-2">
            <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V5m0 6h4m-4 0H9"/></svg>
            <span>Identitas Desa</span>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Profil Informasi Desa</h2>
        <p class="text-xs text-slate-600 font-medium mt-1">Kelola informasi umum Desa Bawangan seperti nama, luas wilayah, alamat balai desa, nomor telepon, dan email.</p>
    </div>

    <form action="{{ route('admin.content.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden mb-6">
            <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200/80">
                <h3 class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V5m0 6h4m-4 0H9"/></svg>
                    <span>Informasi Umum Desa</span>
                </h3>
            </div>

            <div class="p-6 space-y-6">
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Resmi Desa <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $profile->name) }}" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-xs font-semibold text-slate-900 outline-none transition-colors shadow-xs" placeholder="Contoh: Desa Bawangan">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="area" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Luas Wilayah</label>
                    <input type="text" id="area" name="area" value="{{ old('area', $profile->area) }}" class="w-full px-4 py-2.5 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-xs font-semibold text-slate-900 outline-none transition-colors shadow-xs" placeholder="Contoh: 124 Ha">
                    @error('area')
                        <p class="text-xs text-rose-600 mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Lengkap Kantor Desa</label>
                    <textarea id="address" name="address" rows="3" class="w-full px-4 py-2.5 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-xs font-semibold text-slate-900 outline-none transition-colors resize-none shadow-xs" placeholder="Tuliskan alamat lengkap balai / kantor desa...">{{ old('address', $profile->address) }}</textarea>
                    @error('address')
                        <p class="text-xs text-rose-600 mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">No. Telepon / Kontak Resmi</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $profile->phone) }}" class="w-full px-4 py-2.5 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-xs font-semibold text-slate-900 outline-none transition-colors shadow-xs" placeholder="Contoh: 081234567890">
                        @error('phone')
                            <p class="text-xs text-rose-600 mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Email Layanan Desa</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $profile->email) }}" class="w-full px-4 py-2.5 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-xs font-semibold text-slate-900 outline-none transition-colors shadow-xs" placeholder="Contoh: pemdes@bawangan.id">
                        @error('email')
                            <p class="text-xs text-rose-600 mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Preview Panel --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-sky-50/80 border-b border-sky-100">
                <h3 class="font-extrabold text-sky-800 text-xs uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>Pratinjau Data Profil</span>
                </h3>
            </div>
            <div class="p-6 space-y-2 text-xs text-slate-700 font-medium">
                <div><strong class="text-slate-900">Nama Desa:</strong> {{ $profile->name ?? 'Desa Bawangan' }}</div>
                <div><strong class="text-slate-900">Luas Wilayah:</strong> {{ $profile->area ?? 'Belum diisi' }}</div>
                <div><strong class="text-slate-900">Alamat:</strong> {{ $profile->address ?? 'Belum diisi' }}</div>
                <div><strong class="text-slate-900">No. Telepon:</strong> {{ $profile->phone ?? 'Belum diisi' }}</div>
                <div><strong class="text-slate-900">Email:</strong> {{ $profile->email ?? 'Belum diisi' }}</div>
            </div>
        </div>

        <div class="mt-8 flex items-center gap-4">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl font-extrabold text-xs bg-gradient-to-r from-sky-700 to-emerald-600 hover:from-sky-800 hover:to-emerald-700 text-white shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                <span>Simpan Informasi Profil</span>
            </button>
            <a href="{{ route('home') }}#profil" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl text-xs font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 transition-colors shadow-xs cursor-pointer">
                <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Pratinjau Portal Utama</span>
            </a>
        </div>
    </form>
</div>

@endsection

