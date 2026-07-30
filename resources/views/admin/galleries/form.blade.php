@extends('layouts.admin')

@section('title', $gallery ? 'Edit Foto Kegiatan' : 'Tambah Foto Kegiatan')

@section('content')

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-sky-600 hover:text-sky-700 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Galeri</span>
        </a>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $gallery ? 'Edit Foto Kegiatan' : 'Tambah Foto Kegiatan' }}</h2>
        <p class="text-xs text-slate-600 font-medium mt-1">Lengkapi data foto dokumentasi kegiatan Desa Bawangan di bawah ini.</p>
    </div>
</div>

<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 sm:p-8 max-w-3xl">
    <form action="{{ $gallery ? route('admin.galleries.update', $gallery) : route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if($gallery)
            @method('PUT')
        @endif

        {{-- Judul Kegiatan --}}
        <div>
            <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Judul Kegiatan <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="title" id="title" value="{{ old('title', $gallery->title ?? '') }}" required placeholder="Contoh: Gotong Royong Kerja Bakti Dusun Bawangan" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 font-semibold @error('title') border-rose-400 bg-rose-50/50 @enderror">
            @error('title')
                <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid sm:grid-cols-2 gap-6">
            {{-- Kategori --}}
            <div>
                <label for="category" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Kategori Kegiatan
                </label>
                <input type="text" name="category" id="category" value="{{ old('category', $gallery->category ?? '') }}" placeholder="Contoh: Gotong Royong / Keagamaan / Kemasyarakatan" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 font-semibold @error('category') border-rose-400 bg-rose-50/50 @enderror">
                @error('category')
                    <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Kegiatan --}}
            <div>
                <label for="date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Tanggal Pelaksanaan
                </label>
                <input type="date" name="date" id="date" value="{{ old('date', isset($gallery->date) ? $gallery->date->format('Y-m-d') : '') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 font-semibold @error('date') border-rose-400 bg-rose-50/50 @enderror">
                @error('date')
                    <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Deskripsi Kegiatan --}}
        <div>
            <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Deskripsi / Keterangan Kegiatan
            </label>
            <textarea name="description" id="description" rows="3" placeholder="Penjelasan singkat mengenai pelaksanaan kegiatan tersebut..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 font-medium @error('description') border-rose-400 bg-rose-50/50 @enderror">{{ old('description', $gallery->description ?? '') }}</textarea>
            @error('description')
                <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- Foto Kegiatan --}}
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Foto Kegiatan {{ $gallery ? '(Opsional jika tidak diganti)' : '*' }}
            </label>
            
            @if($gallery && $gallery->image)
                <div class="mb-3 flex items-center gap-4 p-3 bg-slate-50 border border-slate-200 rounded-2xl">
                    <div class="w-20 h-16 rounded-xl overflow-hidden bg-slate-200 border border-slate-300 shrink-0">
                        <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover">
                    </div>
                    <div class="text-xs">
                        <p class="font-bold text-slate-800">Foto Saat Ini</p>
                        <p class="text-slate-500 text-[11px] mt-0.5">Unggah foto baru di bawah untuk mengganti.</p>
                    </div>
                </div>
            @endif

            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/webp" {{ $gallery ? '' : 'required' }} class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-700 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-600 file:text-white hover:file:bg-sky-700 cursor-pointer @error('image') border-rose-400 bg-rose-50/50 @enderror">
            <p class="text-[11px] text-slate-500 mt-1">Format disarankan: JPG, PNG, WEBP (Maksimal 4 MB)</p>
            @error('image')
                <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid sm:grid-cols-2 gap-6">
            {{-- Urutan Tampil --}}
            <div>
                <label for="sort_order" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Urutan Tampil
                </label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $gallery->sort_order ?? $nextSortOrder ?? 1) }}" min="0" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 font-semibold @error('sort_order') border-rose-400 bg-rose-50/50 @enderror">
                <p class="text-[11px] text-slate-500 mt-1">Semakin kecil angkanya, semakin awal tampil.</p>
                @error('sort_order')
                    <p class="text-rose-500 text-xs font-semibold mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status Aktif --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Status Publikasi
                </label>
                <label class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-100/60 transition-colors">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $gallery->is_active ?? true) ? 'checked' : '' }} class="w-4 h-4 text-sky-600 rounded border-slate-300 focus:ring-sky-500">
                    <div>
                        <span class="text-xs font-bold text-slate-800 block">Tampilkan di Galeri</span>
                        <span class="text-[11px] text-slate-500 block">Foto kegiatan akan dapat dilihat publik.</span>
                    </div>
                </label>
            </div>
        </div>

        {{-- Submit Buttons --}}
        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.galleries.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold rounded-2xl transition-all">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-sky-700 to-emerald-600 hover:from-sky-800 hover:to-emerald-700 text-white text-xs font-extrabold rounded-2xl shadow-md hover:shadow-lg transition-all cursor-pointer">
                {{ $gallery ? 'Simpan Perubahan' : 'Tambah Foto Kegiatan' }}
            </button>
        </div>
    </form>
</div>

@endsection
