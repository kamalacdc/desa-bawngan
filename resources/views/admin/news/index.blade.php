@extends('layouts.admin')

@section('title', 'Manajemen Berita & Artikel')

@section('content')

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex gap-2 border-b border-slate-200/80 w-full sm:w-auto overflow-x-auto pb-1 sm:pb-0">
        <a href="{{ route('admin.news.index') }}" class="px-4 py-2 text-xs font-bold transition-all cursor-pointer border-b-2 {{ !request('status') ? 'border-sky-600 text-sky-700 font-extrabold' : 'border-transparent text-slate-500 hover:text-slate-900' }}">Semua</a>
        <a href="{{ route('admin.news.index', ['status' => 'draft']) }}" class="px-4 py-2 text-xs font-bold transition-all cursor-pointer border-b-2 {{ request('status') === 'draft' ? 'border-sky-600 text-sky-700 font-extrabold' : 'border-transparent text-slate-500 hover:text-slate-900' }}">Draf</a>
        <a href="{{ route('admin.news.index', ['status' => 'submitted']) }}" class="px-4 py-2 text-xs font-bold transition-all cursor-pointer border-b-2 {{ request('status') === 'submitted' ? 'border-sky-600 text-sky-700 font-extrabold' : 'border-transparent text-slate-500 hover:text-slate-900' }}">Diajukan</a>
        <a href="{{ route('admin.news.index', ['status' => 'published']) }}" class="px-4 py-2 text-xs font-bold transition-all cursor-pointer border-b-2 {{ request('status') === 'published' ? 'border-sky-600 text-sky-700 font-extrabold' : 'border-transparent text-slate-500 hover:text-slate-900' }}">Dipublikasi</a>
    </div>
    
    <div class="flex gap-3 w-full sm:w-auto">
        <form action="{{ route('admin.news.index') }}" method="GET" class="flex-1 sm:w-64 relative">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul berita..." class="w-full pl-10 pr-4 py-2.5 border border-slate-300/80 rounded-2xl text-xs font-medium focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-white shadow-xs outline-none">
            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </form>
        <a href="{{ route('admin.news.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-sky-700 to-emerald-600 hover:from-sky-800 hover:to-emerald-700 text-white text-xs font-extrabold rounded-2xl flex items-center gap-2 shrink-0 shadow-md hover:shadow-lg transition-all cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Berita Baru</span>
        </a>
    </div>
</div>

<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs whitespace-nowrap">
            <thead class="bg-slate-50/80 text-slate-700 font-extrabold border-b border-slate-200/80 uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="px-6 py-4">Judul Berita</th>
                    <th class="px-6 py-4">Kategori</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Pembaca</th>
                    <th class="px-6 py-4">Penulis</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($news as $item)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 shrink-0 overflow-hidden border border-slate-200/60">
                                @if($item->featured_image)
                                    <img src="{{ asset('storage/' . $item->featured_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="max-w-[200px] sm:max-w-xs md:max-w-sm">
                                <p class="font-extrabold text-slate-900 text-sm truncate mb-0.5">{{ $item->title }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ $item->excerpt }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-slate-700 bg-slate-100 px-3 py-1 rounded-xl text-xs font-bold border border-slate-200/60">{{ $item->category->name }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-xl text-[10px] font-extrabold uppercase tracking-wider bg-{{ $item->statusBadgeColor() }}-50 text-{{ $item->statusBadgeColor() }}-700 border border-{{ $item->statusBadgeColor() }}-200/60 inline-block">
                            {{ $item->statusLabel() }}
                        </span>
                        @if($item->isRejected() && $item->rejection_note)
                            <div class="mt-1 flex items-center text-xs font-semibold text-rose-600 cursor-help" title="{{ $item->rejection_note }}">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Lihat Catatan Revisi</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-extrabold text-slate-900">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-slate-100 border border-slate-200/80 text-slate-700 text-xs" title="Total dibaca di web">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span>{{ number_format($item->views_count) }}x</span>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-700 font-semibold">{{ $item->author->name }}</td>
                    <td class="px-6 py-4 text-slate-500 text-xs">
                        <div>Dibuat: <strong class="text-slate-700">{{ $item->created_at->format('d M Y') }}</strong></div>
                        @if($item->published_at)
                            <div class="text-emerald-700 font-bold mt-0.5">Rilis: {{ $item->published_at->format('d M Y') }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($item->isPublished())
                                <a href="{{ route('berita.detail', $item->slug) }}" target="_blank" class="p-2 rounded-xl text-slate-400 hover:text-sky-600 hover:bg-sky-50 transition-colors cursor-pointer" title="Lihat di Situs Utama">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            @endif
                            @if(Auth::user()->isSuperAdmin() || !$item->isPublished())
                                <a href="{{ route('admin.news.edit', $item) }}" class="p-2 rounded-xl text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-colors cursor-pointer" title="Edit Berita">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                            @else
                                <span class="p-2 rounded-xl text-slate-300 cursor-not-allowed inline-flex items-center" title="Berita terpublikasi tidak dapat diubah oleh Staf Admin">
                                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </span>
                            @endif
                            @if(Auth::user()->isSuperAdmin())
                                <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer" title="Hapus Berita">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-14 text-center text-slate-500">
                        <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center mx-auto mb-3 border border-sky-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                        <p class="font-bold text-slate-900 text-sm">Belum ada berita ditemukan.</p>
                        <p class="text-xs text-slate-500 mt-1">Gunakan tombol di atas untuk menambah berita baru.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($news->hasPages())
        <div class="p-4 border-t border-slate-200/80 bg-slate-50/50">
            {{ $news->links() }}
        </div>
    @endif
</div>

@endsection

