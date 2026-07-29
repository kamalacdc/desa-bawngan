@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.news.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center text-slate-500 hover:text-sky-600 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
        <h2 class="text-xl font-bold text-slate-800 flex items-center gap-3">
            Formulir Edit
            <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-{{ $news->statusBadgeColor() }}-100 text-{{ $news->statusBadgeColor() }}-700">
                {{ $news->statusLabel() }}
            </span>
        </h2>
    </div>
</div>

@if($news->isRejected() && $news->rejection_note)
<div class="mb-6 bg-rose-50 border border-rose-200 rounded-2xl p-5 flex gap-4 items-start max-w-4xl shadow-sm">
    <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    </div>
    <div>
        <h4 class="font-bold text-rose-800 mb-1">Berita Ditolak</h4>
        <p class="text-sm text-rose-700 leading-relaxed">{{ $news->rejection_note }}</p>
        <p class="text-xs text-rose-500 mt-2 font-semibold">Silakan perbaiki berita sesuai catatan di atas, kemudian ajukan ulang.</p>
    </div>
</div>
@endif

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden max-w-4xl">
    
    {{-- Header Action Bar --}}
    <div class="bg-slate-50 border-b border-slate-200 p-4 sm:px-8 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-slate-500">
            Dibuat oleh: <strong class="text-slate-700">{{ $news->author->name }}</strong> pada {{ $news->created_at->format('d M Y') }}
        </p>
        
        <div class="flex gap-2">
            @if(in_array($news->status, ['draft', 'rejected']))
                <form action="{{ route('admin.news.submit', $news) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg flex items-center gap-2 transition-colors shadow-sm shadow-emerald-600/20" onclick="return confirm('Ajukan berita ini untuk diperiksa oleh Super Admin?');">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Ajukan Publish
                    </button>
                </form>
            @endif
            @if($news->isPublished())
                <a href="{{ route('berita.detail', $news->slug) }}" target="_blank" class="px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-lg flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Lihat di Web
                </a>
            @endif
        </div>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid sm:grid-cols-2 gap-6">
            <div class="sm:col-span-2">
                <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Berita <span class="text-rose-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $news->title) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-colors bg-slate-50 focus:bg-white text-slate-800">
                @error('title')<p class="mt-1 text-sm text-rose-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-bold text-slate-700 mb-2">Kategori <span class="text-rose-500">*</span></label>
                <select id="category_id" name="category_id" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-colors bg-slate-50 focus:bg-white text-slate-800">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $news->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="mt-1 text-sm text-rose-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="featured_image" class="block text-sm font-bold text-slate-700 mb-2">Gambar Utama (Opsional)</label>
                <div class="flex items-center gap-4">
                    @if($news->featured_image)
                    <div class="w-12 h-12 rounded-lg bg-slate-100 overflow-hidden shrink-0 border border-slate-200">
                        <img src="{{ asset('storage/' . $news->featured_image) }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <div class="flex-1">
                        <input type="file" id="featured_image" name="featured_image" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-colors bg-slate-50 focus:bg-white text-slate-800 file:mr-3 file:py-1 file:px-2 file:rounded file:border-0 file:bg-sky-100 file:text-sky-700 file:text-xs text-sm hover:file:bg-sky-200">
                    </div>
                </div>
                <p class="mt-1 text-xs text-slate-500">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                @error('featured_image')<p class="mt-1 text-sm text-rose-500">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label for="excerpt" class="block text-sm font-bold text-slate-700 mb-2">Ringkasan (Excerpt) <span class="text-rose-500">*</span></label>
                <textarea id="excerpt" name="excerpt" rows="2" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-colors bg-slate-50 focus:bg-white text-slate-800">{{ old('excerpt', $news->excerpt) }}</textarea>
                @error('excerpt')<p class="mt-1 text-sm text-rose-500">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label for="body" class="block text-sm font-bold text-slate-700 mb-2">Isi Berita <span class="text-rose-500">*</span></label>
                <textarea id="body" name="body" rows="16" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-colors bg-slate-50 focus:bg-white text-slate-800 font-mono text-sm leading-relaxed">{{ old('body', $news->body) }}</textarea>
                @error('body')<p class="mt-1 text-sm text-rose-500">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-4">
            <a href="{{ route('admin.news.index') }}" class="px-6 py-2.5 rounded-xl font-semibold text-slate-600 hover:bg-slate-100 transition-colors">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-white bg-sky-600 hover:bg-sky-700 shadow-md shadow-sky-600/20 transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection
