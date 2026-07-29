@extends('layouts.admin')

@section('title', $leader ? 'Edit Perangkat Desa' : 'Tambah Perangkat Desa')

@section('content')

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.leaders.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-center text-slate-500 hover:text-sky-600 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h2 class="text-xl font-bold text-slate-800">{{ $leader ? 'Edit Profil' : 'Formulir Perangkat Baru' }}</h2>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 max-w-2xl">
    <form action="{{ $leader ? route('admin.leaders.update', $leader) : route('admin.leaders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if($leader) @method('PUT') @endif

        <div>
            <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name', $leader->name ?? '') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-colors bg-slate-50 focus:bg-white text-slate-800">
            @error('name')<p class="mt-1 text-sm text-rose-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="position" class="block text-sm font-bold text-slate-700 mb-2">Jabatan <span class="text-rose-500">*</span></label>
            <input type="text" id="position" name="position" value="{{ old('position', $leader->position ?? '') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-colors bg-slate-50 focus:bg-white text-slate-800" placeholder="Contoh: Kepala Desa">
            @error('position')<p class="mt-1 text-sm text-rose-500">{{ $message }}</p>@enderror
        </div>

        <div class="grid sm:grid-cols-2 gap-6">
            <div>
                <label for="sort_order" class="block text-sm font-bold text-slate-700 mb-2">Urutan Tampil <span class="text-rose-500">*</span></label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $leader->sort_order ?? 0) }}" min="0" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-colors bg-slate-50 focus:bg-white text-slate-800">
                <p class="mt-1 text-xs text-slate-500">Angka lebih kecil tampil lebih awal (0, 1, 2...)</p>
                @error('sort_order')<p class="mt-1 text-sm text-rose-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Status Penayangan</label>
                <div class="pt-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $leader->is_active ?? true) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        <span class="ml-3 text-sm font-semibold text-slate-600">Aktif Tampil</span>
                    </label>
                </div>
            </div>
        </div>

        <div>
            <label for="photo" class="block text-sm font-bold text-slate-700 mb-2">Foto Profil (Opsional)</label>
            <div class="flex items-center gap-4">
                @if($leader && $leader->photo)
                <div class="w-16 h-16 rounded-full bg-slate-100 overflow-hidden shrink-0 border border-slate-200">
                    <img src="{{ asset('storage/' . $leader->photo) }}" class="w-full h-full object-cover">
                </div>
                @endif
                <div class="flex-1">
                    <input type="file" id="photo" name="photo" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 transition-colors bg-slate-50 focus:bg-white text-slate-800 file:mr-3 file:py-1 file:px-2 file:rounded file:border-0 file:bg-sky-100 file:text-sky-700 file:text-xs text-sm hover:file:bg-sky-200">
                    <p class="mt-1 text-xs text-slate-500">Saran: Gunakan foto rasio 1:1 (persegi).</p>
                </div>
            </div>
            @error('photo')<p class="mt-1 text-sm text-rose-500">{{ $message }}</p>@enderror
        </div>

        <div class="pt-6 border-t border-slate-200 flex items-center justify-end gap-4">
            <a href="{{ route('admin.leaders.index') }}" class="px-6 py-2.5 rounded-xl font-semibold text-slate-600 hover:bg-slate-100 transition-colors">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-white bg-sky-600 hover:bg-sky-700 shadow-md shadow-sky-600/20 transition-colors">
                Simpan Data
            </button>
        </div>
    </form>
</div>

@endsection
