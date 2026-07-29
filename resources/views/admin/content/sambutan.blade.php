@extends('layouts.admin')

@section('title', 'Kelola Sambutan Kepala Desa')

@section('content')

<div class="max-w-3xl">
    <div class="mb-8">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-50 text-sky-800 text-xs font-extrabold tracking-wider uppercase border border-sky-200/70 mb-2">
            <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            <span>Sambutan Pimpinan</span>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Sambutan Kepala Desa Bawangan</h2>
        <p class="text-xs text-slate-600 font-medium mt-1">Kelola isi pesan dan sambutan resmi Kepala Desa untuk ditampilkan pada halaman utama website.</p>
    </div>

    <form action="{{ route('admin.content.sambutan.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200/80">
                <h3 class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>Formulir Sambutan Kepala Desa</span>
                </h3>
            </div>

            <div class="p-6 space-y-6">
                <div>
                    <label for="welcome_title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Judul Card Sambutan</label>
                    <input type="text" id="welcome_title" name="welcome_title" value="{{ old('welcome_title', $profile->welcome_title ?? 'Sambutan Kepala Desa') }}" class="w-full px-4 py-3 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-xs font-medium text-slate-900 outline-none transition-colors shadow-xs" placeholder="Sambutan Kepala Desa">
                    @error('welcome_title')
                        <p class="text-xs text-rose-600 mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="welcome_speech" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Isi Pesan / Sambutan <span class="text-rose-500">*</span></label>
                    <textarea id="welcome_speech" name="welcome_speech" rows="10" required class="w-full px-4 py-3 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-xs font-medium text-slate-900 outline-none transition-colors resize-y leading-relaxed shadow-xs" placeholder="Tuliskan isi sambutan Kepala Desa di sini...">{{ old('welcome_speech', $profile->welcome_speech ?? "Assalamu'alaikum Wr. Wb. Selamat datang di Website Resmi Desa Bawangan. Kami berkomitmen untuk memberikan pelayanan terbaik bagi seluruh warga dan masyarakat umum.\n\nMelalui website ini, kami berusaha mewujudkan transparansi informasi dan pelayanan publik yang semakin baik. Semoga website ini bermanfaat bagi kita semua.\n\nWassalamu'alaikum Wr. Wb.") }}</textarea>
                    @error('welcome_speech')
                        <p class="text-xs text-rose-600 mt-1 font-bold">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-slate-500 mt-1.5 font-medium">Gunakan baris baru (enter) untuk memisahkan antar paragraf dalam sambutan.</p>
                </div>
            </div>
        </div>

        {{-- Preview Panel --}}
        <div class="mt-6 bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-sky-50/80 border-b border-sky-100 flex items-center justify-between">
                <h3 class="font-extrabold text-sky-800 text-xs uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>Pratinjau Sambutan Saat Ini</span>
                </h3>
                <a href="{{ route('admin.leaders.index') }}" class="text-[11px] font-bold text-sky-700 hover:text-sky-800 underline">Kelola Foto & Nama Kades →</a>
            </div>
            <div class="p-6">
                <div class="flex flex-col sm:flex-row gap-6 items-start">
                    {{-- Mini Photo + Name Preview (Left Side) --}}
                    <div class="sm:w-36 shrink-0 text-center mx-auto sm:mx-0">
                        <div class="aspect-[3/4] rounded-2xl overflow-hidden bg-gradient-to-br from-sky-100 to-emerald-100 shadow-md border border-slate-200 mb-2.5">
                            @if ($kades && $kades->photo)
                                <img src="{{ asset('storage/' . $kades->photo) }}" alt="{{ $kades->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center p-3 text-center">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-sky-500 to-emerald-500 flex items-center justify-center text-white text-xl font-bold shadow-sm">
                                        {{ $kades ? strtoupper(substr($kades->name, 0, 1)) : 'K' }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <p class="text-xs font-bold text-slate-800 line-clamp-1">{{ $kades->name ?? 'Kepala Desa' }}</p>
                        <p class="text-[11px] text-sky-600 font-semibold mt-0.5 line-clamp-1">{{ $kades->position ?? 'Kepala Desa Bawangan' }}</p>
                    </div>

                    {{-- Teks Preview (Right Side) --}}
                    <div class="flex-1 bg-slate-50/70 rounded-2xl p-4 border border-slate-200/80 w-full">
                        <div class="text-slate-700 text-xs leading-relaxed whitespace-pre-line font-medium">
                            {{ $profile->welcome_speech ?? "Assalamu'alaikum Wr. Wb. Selamat datang di Website Resmi Desa Bawangan. Kami berkomitmen untuk memberikan pelayanan terbaik bagi seluruh warga dan masyarakat umum.\n\nMelalui website ini, kami berusaha mewujudkan transparansi informasi dan pelayanan publik yang semakin baik. Semoga website ini bermanfaat bagi kita semua.\n\nWassalamu'alaikum Wr. Wb." }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex items-center gap-4">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl font-extrabold text-xs bg-gradient-to-r from-sky-700 to-emerald-600 hover:from-sky-800 hover:to-emerald-700 text-white shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                <span>Simpan Sambutan Kades</span>
            </button>
            <a href="{{ route('home') }}#profil" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl text-xs font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 transition-colors shadow-xs cursor-pointer">
                <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Pratinjau Portal Utama</span>
            </a>
        </div>
    </form>
</div>

@endsection
