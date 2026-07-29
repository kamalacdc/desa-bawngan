@extends('layouts.admin')

@section('title', 'Kelola Visi & Misi Desa')

@section('content')

<div class="max-w-3xl">
    <div class="mb-8">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-50 text-sky-800 text-xs font-extrabold tracking-wider uppercase border border-sky-200/70 mb-2">
            <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            <span>Panduan Strategis</span>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Visi & Misi Desa Bawangan</h2>
        <p class="text-xs text-slate-600 font-medium mt-1">Kelola konten Pernyataan Visi dan Poin Misi Desa Bawangan untuk publikasi portal.</p>
    </div>

    <form action="{{ route('admin.content.visi-misi.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200/80">
                <h3 class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>Pernyataan Visi & Misi</span>
                </h3>
            </div>

            <div class="p-6 space-y-6">
                <div>
                    <label for="vision" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Visi Desa <span class="text-rose-500">*</span></label>
                    <textarea id="vision" name="vision" rows="4" required class="w-full px-4 py-3 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-xs font-medium text-slate-900 outline-none transition-colors resize-none shadow-xs leading-relaxed" placeholder="Tuliskan visi desa...">{{ old('vision', $profile->vision) }}</textarea>
                    @error('vision')
                        <p class="text-xs text-rose-600 mt-1 font-bold">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-slate-500 mt-1.5 font-medium">Cita-cita atau pandangan jangka panjang pembangunan Desa Bawangan.</p>
                </div>

                <div>
                    <label for="mission" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Misi Pembangunan Desa <span class="text-rose-500">*</span></label>
                    <textarea id="mission" name="mission" rows="8" required class="w-full px-4 py-3 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-xs font-medium text-slate-900 outline-none transition-colors resize-y shadow-xs leading-relaxed" placeholder="Tuliskan poin-poin misi desa...">{{ old('mission', $profile->mission) }}</textarea>
                    @error('mission')
                        <p class="text-xs text-rose-600 mt-1 font-bold">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-slate-500 mt-1.5 font-medium">Gunakan baris baru untuk setiap nomor/poin program kerja misi desa.</p>
                </div>
            </div>
        </div>

        {{-- Preview Panel --}}
        <div class="mt-6 bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-sky-50/80 border-b border-sky-100">
                <h3 class="font-extrabold text-sky-800 text-xs uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>Pratinjau Visi & Misi Saat Ini</span>
                </h3>
            </div>
            <div class="p-6">
                <div class="mb-5">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Visi Desa</h4>
                    <blockquote class="text-slate-900 text-xs font-bold italic border-l-4 border-sky-600 pl-4 py-1">"{{ $profile->vision ?? 'Belum diisi' }}"</blockquote>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Misi Pembangunan</h4>
                    <div class="text-xs text-slate-700 font-medium leading-relaxed whitespace-pre-line">{{ $profile->mission ?? 'Belum diisi' }}</div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex items-center gap-4">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl font-extrabold text-xs bg-gradient-to-r from-sky-700 to-emerald-600 hover:from-sky-800 hover:to-emerald-700 text-white shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                <span>Simpan Visi & Misi</span>
            </button>
            <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl text-xs font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 transition-colors shadow-xs cursor-pointer">
                <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Pratinjau Portal Utama</span>
            </a>
        </div>
    </form>
</div>

@endsection

