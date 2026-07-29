@extends('layouts.admin')

@section('title', 'Kelola Sejarah Desa')

@section('content')

<div class="max-w-3xl">
    <div class="mb-8">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-50 text-sky-800 text-xs font-extrabold tracking-wider uppercase border border-sky-200/70 mb-2">
            <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Sejarah & Origin</span>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Sejarah Desa Bawangan</h2>
        <p class="text-xs text-slate-600 font-medium mt-1">Kelola narasi latar belakang dan sejarah perkembangan Desa Bawangan untuk publikasi portal.</p>
    </div>

    <form action="{{ route('admin.content.sejarah.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200/80">
                <h3 class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Konten Narasi Sejarah Desa</span>
                </h3>
            </div>

            <div class="p-6 space-y-6">
                <div>
                    <label for="history" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Narasi Lengkap Sejarah <span class="text-rose-500">*</span></label>
                    <textarea id="history" name="history" rows="10" required class="w-full px-4 py-3 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-xs font-medium text-slate-900 outline-none transition-colors resize-y leading-relaxed shadow-xs" placeholder="Tuliskan latar belakang dan sejarah terbentuknya Desa Bawangan...">{{ old('history', $profile->history) }}</textarea>
                    @error('history')
                        <p class="text-xs text-rose-600 mt-1 font-bold">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-slate-500 mt-1.5 font-medium">Jelaskan asal-usul nama desa, pendiri desa, serta momentum sejarah penting dalam perkembangan desa.</p>
                </div>
            </div>
        </div>

        {{-- Preview Panel --}}
        <div class="mt-6 bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-sky-50/80 border-b border-sky-100">
                <h3 class="font-extrabold text-sky-800 text-xs uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>Pratinjau Narasi Sejarah Saat Ini</span>
                </h3>
            </div>
            <div class="p-6">
                <p class="text-slate-700 text-xs leading-relaxed whitespace-pre-line font-medium">{{ $profile->history ?? 'Belum ada data sejarah desa.' }}</p>
            </div>
        </div>

        <div class="mt-8 flex items-center gap-4">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl font-extrabold text-xs bg-gradient-to-r from-sky-700 to-emerald-600 hover:from-sky-800 hover:to-emerald-700 text-white shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                <span>Simpan Narasi Sejarah</span>
            </button>
            <a href="{{ route('home') }}#profil" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl text-xs font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 transition-colors shadow-xs cursor-pointer">
                <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Pratinjau Portal Utama</span>
            </a>
        </div>
    </form>
</div>

@endsection

