@extends('layouts.app')

@section('title', 'Berita & Informasi')
@section('meta_description', 'Berita terbaru, pengumuman resmi, dan informasi kegiatan seputar Desa Bawangan.')

@section('content')
<section class="pt-10 pb-24 bg-slate-50/80 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <div class="mb-12">
            <div class="section-badge mb-4">
                <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <span>Informasi Publik</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-6">Kabar & Informasi <span class="bg-gradient-to-r from-sky-700 to-emerald-600 bg-clip-text text-transparent">Desa Bawangan</span></h1>
            
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between bg-white/90 backdrop-blur-md p-4 rounded-3xl shadow-sm border border-slate-200/80">
                {{-- Search Form --}}
                <form action="{{ route('berita') }}" method="GET" class="w-full md:w-auto relative flex-1 max-w-md">
                    @if(request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari berita atau pengumuman..." class="w-full pl-11 pr-4 py-2.5 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50 text-sm font-medium text-slate-900 transition-all outline-none">
                    <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </form>

                {{-- Category Filters --}}
                <div class="flex flex-wrap gap-2 justify-center md:justify-end">
                    <a href="{{ route('berita', ['cari' => request('cari')]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer {{ !request('kategori') ? 'bg-sky-700 text-white shadow-md shadow-sky-700/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">Semua</a>
                    @foreach($categories as $cat)
                        <a href="{{ route('berita', ['kategori' => $cat->slug, 'cari' => request('cari')]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer {{ request('kategori') == $cat->slug ? 'bg-sky-700 text-white shadow-md shadow-sky-700/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            {{ $cat->name }} <span class="ml-1 opacity-70 text-[11px]">({{ $cat->news_count }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- News Grid --}}
        @if($news->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl border border-slate-200/80 shadow-xs">
                <div class="w-16 h-16 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-sky-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Belum ada berita ditemukan</h3>
                <p class="text-sm text-slate-500 max-w-sm mx-auto mb-6">Coba gunakan kata kunci pencarian yang berbeda atau pilih kategori lain.</p>
                <a href="{{ route('berita') }}" class="btn-primary">Lihat Semua Berita</a>
            </div>
        @else
            <div id="berita-list" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($news as $item)
                <article class="news-card group flex flex-col h-full bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-slate-200/60 border border-slate-200/80 transition-all duration-300 hover:-translate-y-1">
                    <div class="relative h-56 overflow-hidden bg-slate-100 shrink-0">
                        @if($item->featured_image)
                            <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-xl bg-white/95 backdrop-blur-md text-xs font-bold tracking-wide text-sky-700 shadow-sm border border-white/40">{{ $item->category->name }}</span>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500 mb-3 flex-wrap gap-2">
                            <div class="flex items-center gap-2">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $item->published_at->translatedFormat('d M Y') }}
                                </span>
                            </div>
                            <span class="flex items-center gap-1 text-slate-600 font-bold text-[11px] bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200/60" title="{{ number_format($item->views_count) }} kali dibaca">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                {{ number_format($item->views_count) }}x
                            </span>
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-lg leading-snug mb-3 group-hover:text-sky-700 transition-colors">
                            <a href="{{ route('berita.detail', $item->slug) }}" class="hover:underline focus:outline-none cursor-pointer">
                                {{ $item->title }}
                            </a>
                        </h3>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed mb-6 flex-1">{{ Str::limit($item->excerpt, 120) }}</p>
                        <a href="{{ route('berita.detail', $item->slug) }}" class="flex items-center text-xs font-bold text-sky-700 mt-auto group-hover:text-sky-800 transition-colors cursor-pointer hover:underline">
                            <span>Baca Selengkapnya</span>
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex justify-center">
                {{ $news->links() }}
            </div>
        @endif

    </div>
</section>
@endsection

