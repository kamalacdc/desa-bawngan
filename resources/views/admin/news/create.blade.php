@extends('layouts.admin')

@section('title', 'Tulis Berita Baru')

@section('content')

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.news.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center text-slate-500 hover:text-sky-600 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h2 class="text-xl font-bold text-slate-800">Formulir Berita</h2>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-4xl">
        @csrf

        <div class="grid sm:grid-cols-2 gap-6">
            <div class="sm:col-span-2">
                <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Berita <span class="text-rose-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-colors bg-slate-50 focus:bg-white text-slate-800" placeholder="Masukkan judul berita yang menarik">
                @error('title')<p class="mt-1 text-sm text-rose-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-bold text-slate-700 mb-2">Kategori <span class="text-rose-500">*</span></label>
                <select id="category_id" name="category_id" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-colors bg-slate-50 focus:bg-white text-slate-800">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="mt-1 text-sm text-rose-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="featured_image" class="block text-sm font-bold text-slate-700 mb-2">Gambar Utama (Opsional)</label>
                <input type="file" id="featured_image" name="featured_image" accept="image/*" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-colors bg-slate-50 focus:bg-white text-slate-800 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-sky-100 file:text-sky-700 hover:file:bg-sky-200">
                <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                @error('featured_image')<p class="mt-1 text-sm text-rose-500">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label for="excerpt" class="block text-sm font-bold text-slate-700 mb-2">Ringkasan (Excerpt) <span class="text-rose-500">*</span></label>
                <textarea id="excerpt" name="excerpt" rows="2" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-colors bg-slate-50 focus:bg-white text-slate-800" placeholder="Tuliskan ringkasan singkat yang akan muncul di halaman depan...">{{ old('excerpt') }}</textarea>
                @error('excerpt')<p class="mt-1 text-sm text-rose-500">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label for="body" class="block text-sm font-bold text-slate-700 mb-2">Isi Berita <span class="text-rose-500">*</span></label>
                <textarea id="body" name="body" rows="12" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-colors bg-slate-50 focus:bg-white text-slate-800" placeholder="Tuliskan isi berita selengkapnya di sini...">{{ old('body') }}</textarea>
                <p class="mt-2 text-xs text-slate-500 bg-sky-50 p-2 rounded-lg border border-sky-100"><svg class="w-4 h-4 inline-block mr-1 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Tips: Anda dapat menggunakan tag HTML dasar seperti &lt;b&gt;, &lt;i&gt;, &lt;u&gt;, atau &lt;br&gt; untuk mengatur format teks.</p>
                @error('body')<p class="mt-1 text-sm text-rose-500">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-4">
            <a href="{{ route('admin.news.index') }}" class="px-6 py-2.5 rounded-xl font-semibold text-slate-600 hover:bg-slate-100 transition-colors">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-white bg-sky-600 hover:bg-sky-700 shadow-md shadow-sky-600/20 transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                Simpan sebagai Draf
            </button>
        </div>
    </form>
</div>

@endsection
