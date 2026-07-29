@extends('layouts.admin')

@section('title', 'Dashboard Summary')

@section('content')

{{-- Welcome Header Banner --}}
<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-950 via-slate-900 to-sky-950 border border-slate-800 shadow-xl p-6 md:p-8 text-white mb-8">
    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute right-1/3 -top-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
    
    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="space-y-2 max-w-2xl">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-white/10 text-sky-300 border border-white/15 backdrop-blur-xs">
                    {{ Auth::user()->isSuperAdmin() ? 'Super Administrator' : 'Staf Admin Redaksi' }}
                </span>
                <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                    Sistem Aktif & Normal
                </span>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">
                Selamat Datang Kembali, {{ Auth::user()->name }}! 👋
            </h2>
            <p class="text-xs md:text-sm text-slate-300 leading-relaxed">
                Kelola publikasi informasi desa, approval berita, demografi penduduk, dan transparansi APBDes Bawangan secara terstruktur & real-time.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0 flex-wrap">
            <a href="{{ route('admin.news.create') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-extrabold text-xs shadow-lg shadow-sky-600/30 hover:shadow-sky-600/50 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Tulis Berita Baru</span>
            </a>
            @if(Auth::user()->isSuperAdmin() && $stats['pending_approval'] > 0)
            <a href="{{ route('admin.approvals') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs shadow-lg shadow-amber-500/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Review Approval ({{ $stats['pending_approval'] }})</span>
            </a>
            @endif
        </div>
    </div>
</div>

{{-- KPI Quick Stats Cards Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-5 mb-8">
    
    {{-- Card 1: Total Berita --}}
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
        <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 border border-sky-100 flex items-center justify-center shrink-0 shadow-inner">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
        </div>
        <div class="min-w-0">
            <p class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-0.5">Total Berita</p>
            <p class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['total_news']) }}</p>
            <p class="text-[10px] font-semibold text-slate-400 truncate">Semua artikel terdaftar</p>
        </div>
    </div>
    
    {{-- Card 2: Dipublikasi --}}
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0 shadow-inner">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="min-w-0">
            <p class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-0.5">Dipublikasi</p>
            <p class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['published_news']) }}</p>
            <p class="text-[10px] font-semibold text-emerald-600 truncate">Tayang di web publik</p>
        </div>
    </div>

    {{-- Card 3: Menunggu Approval --}}
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer relative overflow-hidden">
        @if($stats['pending_approval'] > 0)
            <div class="absolute top-0 right-0 w-2 h-2 rounded-full bg-amber-500 m-3 animate-ping"></div>
        @endif
        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center shrink-0 shadow-inner">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="min-w-0">
            <p class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-0.5">Pending Review</p>
            <p class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['pending_approval']) }}</p>
            <p class="text-[10px] font-semibold text-amber-600 truncate">Perlu persetujuan</p>
        </div>
    </div>

    {{-- Card 4: Draf & Ditolak --}}
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 border border-rose-100 flex items-center justify-center shrink-0 shadow-inner">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        </div>
        <div class="min-w-0">
            <p class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-0.5">Draf / Revisi</p>
            <p class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['draft_news'] + $stats['rejected_news']) }}</p>
            <p class="text-[10px] font-semibold text-slate-400 truncate">{{ $stats['draft_news'] }} Draf | {{ $stats['rejected_news'] }} Ditolak</p>
        </div>
    </div>

    {{-- Card 5: System Admin Metrics (Super Admin) / Status Staff --}}
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex items-center gap-4 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer sm:col-span-2 lg:col-span-4 xl:col-span-1">
        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center shrink-0 shadow-inner">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <div class="min-w-0">
            <p class="text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-0.5">Pengguna & Aparat</p>
            <p class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($stats['total_users']) }} User</p>
            <p class="text-[10px] font-semibold text-indigo-600 truncate">{{ $stats['total_leaders'] }} Perangkat Desa</p>
        </div>
    </div>
</div>

{{-- Immediate Action Banner for Super Admin (If there are pending approvals) --}}
@if(Auth::user()->isSuperAdmin() && count($pendingApprovals) > 0)
<div class="bg-amber-500/10 border-2 border-amber-500/30 rounded-3xl p-6 mb-8 backdrop-blur-xs">
    <div class="flex items-center justify-between gap-4 mb-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-amber-500 text-slate-950 flex items-center justify-center font-bold shrink-0 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="font-extrabold text-slate-900 text-base">Antrean Persetujuan Berita ({{ count($pendingApprovals) }})</h3>
                <p class="text-xs text-slate-600">Berita yang diajukan oleh staf dan memerlukan verifikasi Super Admin sebelum terbit.</p>
            </div>
        </div>
        <a href="{{ route('admin.approvals') }}" class="text-xs font-extrabold text-amber-800 bg-amber-200/80 hover:bg-amber-300 px-4 py-2 rounded-xl transition-colors cursor-pointer shrink-0">
            Kelola Semua &rarr;
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($pendingApprovals as $pending)
        <div class="bg-white rounded-2xl p-4 border border-amber-200/70 shadow-xs flex items-start gap-4">
            <div class="w-16 h-16 rounded-xl bg-slate-100 shrink-0 overflow-hidden border border-slate-200">
                @if($pending->featured_image)
                    <img src="{{ asset('storage/' . $pending->featured_image) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2 py-0.5 rounded-md text-[9px] font-bold uppercase bg-slate-100 text-slate-700">{{ $pending->category->name }}</span>
                    <span class="text-[10px] font-medium text-slate-400">Oleh: {{ $pending->author->name }}</span>
                </div>
                <h4 class="font-extrabold text-slate-900 text-xs truncate mb-2">{{ $pending->title }}</h4>
                <div class="flex items-center gap-2">
                    <form method="POST" action="{{ route('admin.approvals.approve', $pending) }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1 rounded-lg text-[10px] font-extrabold bg-emerald-600 hover:bg-emerald-700 text-white transition-colors cursor-pointer">
                            Approve
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.approvals.reject', $pending) }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1 rounded-lg text-[10px] font-extrabold bg-rose-100 text-rose-700 hover:bg-rose-200 transition-colors cursor-pointer">
                            Tolak
                        </button>
                    </form>
                    <a href="{{ route('admin.news.show', $pending) }}" class="px-3 py-1 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-600 hover:bg-slate-200 transition-colors cursor-pointer">
                        Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Main Section 2-Column Grid (8:4 layout) --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    {{-- Left Column: 8 Cols --}}
    <div class="lg:col-span-8 space-y-8">
        
        {{-- Recent News Card Table --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-5 md:p-6 border-b border-slate-100 flex items-center justify-between flex-wrap gap-4 bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 border border-sky-100 flex items-center justify-center font-bold shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base flex items-center gap-2">
                            <span>Berita Terbaru</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-700">Maks. 4 Berita</span>
                        </h3>
                        <p class="text-xs text-slate-500">Daftar publikasi berita desa terbaru dari staf & admin</p>
                    </div>
                </div>
                <a href="{{ route('admin.news.index') }}" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-sky-700 hover:text-sky-800 transition-colors cursor-pointer bg-sky-50 px-3.5 py-2 rounded-xl border border-sky-200/70 hover:bg-sky-100">
                    <span>Lihat Semua Berita</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($recentNews as $news)
                <div class="p-4 md:p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4 hover:bg-slate-50/80 transition-colors group">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-slate-100 shrink-0 overflow-hidden border border-slate-200/80 group-hover:scale-105 transition-transform duration-200 shadow-xs">
                        @if($news->featured_image)
                            <img src="{{ asset('storage/' . $news->featured_image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                            <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider bg-slate-100 text-slate-700 border border-slate-200/80">{{ $news->category->name }}</span>
                            <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider bg-{{ $news->statusBadgeColor() }}-50 text-{{ $news->statusBadgeColor() }}-700 border border-{{ $news->statusBadgeColor() }}-200/80">
                                {{ $news->statusLabel() }}
                            </span>
                        </div>
                        <h4 class="font-extrabold text-slate-900 text-sm truncate mb-1 group-hover:text-sky-700 transition-colors">{{ $news->title }}</h4>
                        <p class="text-xs text-slate-600 truncate mb-2 max-w-xl">{{ $news->excerpt }}</p>
                        <div class="flex items-center gap-4 text-[11px] font-semibold text-slate-500 flex-wrap">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg> 
                                {{ $news->author->name }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> 
                                {{ $news->created_at->translatedFormat('d M Y') }}
                            </span>
                            <span class="flex items-center gap-1 text-slate-600 font-bold bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200/60" title="{{ number_format($news->views_count) }} kali dibaca">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                {{ number_format($news->views_count) }}x
                            </span>
                        </div>
                    </div>
                    <div class="shrink-0 self-end sm:self-center">
                        @if(Auth::user()->isSuperAdmin() || !$news->isPublished())
                            <a href="{{ route('admin.news.edit', $news) }}" class="p-2 rounded-xl text-slate-400 hover:text-sky-600 hover:bg-sky-50 transition-colors cursor-pointer block" title="Edit Artikel">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                        @else
                            <span class="p-2 rounded-xl text-slate-300 cursor-not-allowed inline-flex items-center" title="Berita terpublikasi tidak dapat diubah oleh Staf Admin">
                                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="p-10 text-center text-sm font-medium text-slate-500">
                    Belum ada berita yang dibuat. Klik tombol "Tulis Berita Baru" untuk menambahkan berita desa.
                </div>
                @endforelse
            </div>
        </div>

        {{-- Demografi & APBDes Charts Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Demografi Card --}}
            @if($latestPopulation)
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 flex flex-col h-full">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Demografi Penduduk</h3>
                        <p class="text-[11px] text-slate-500">Tahun {{ $latestPopulation->year }}</p>
                    </div>
                    @if(Auth::user()->isSuperAdmin())
                    <a href="{{ route('admin.population.index') }}" class="text-xs font-extrabold text-sky-700 hover:text-sky-800 cursor-pointer">
                        Kelola &rarr;
                    </a>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-3 mb-5">
                    <div class="bg-sky-50/90 rounded-2xl p-3 text-center border border-sky-100">
                        <p class="text-[10px] font-extrabold text-sky-700 uppercase tracking-wider mb-0.5">Laki-laki</p>
                        <p class="text-xl font-black text-slate-900">{{ number_format($latestPopulation->male_count, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-rose-50/90 rounded-2xl p-3 text-center border border-rose-100">
                        <p class="text-[10px] font-extrabold text-rose-700 uppercase tracking-wider mb-0.5">Perempuan</p>
                        <p class="text-xl font-black text-slate-900">{{ number_format($latestPopulation->female_count, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="relative flex-1 min-h-[220px] w-full">
                    <canvas id="populationChart"></canvas>
                </div>
                
                <script>
                    window.villagePopulationData = {
                        total: {{ $latestPopulation->male_count + $latestPopulation->female_count }},
                        male: {{ $latestPopulation->male_count }},
                        female: {{ $latestPopulation->female_count }},
                        ageGroups: {!! json_encode($latestPopulation->age_groups ?? []) !!}
                    };
                </script>
            </div>
            @endif

            {{-- APBDes Card --}}
            @if($budgetSummary)
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 flex flex-col h-full">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Transparansi APBDes</h3>
                        <p class="text-[11px] text-slate-500">Tahun {{ $budgetSummary['year'] }}</p>
                    </div>
                    @if(Auth::user()->isSuperAdmin())
                    <a href="{{ route('admin.budget.index') }}" class="text-xs font-extrabold text-sky-700 hover:text-sky-800 cursor-pointer">
                        Kelola &rarr;
                    </a>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-3 mb-5">
                    <div class="bg-emerald-50/90 rounded-2xl p-3 text-center border border-emerald-100">
                        <p class="text-[10px] font-extrabold text-emerald-700 uppercase tracking-wider mb-0.5">Pendapatan</p>
                        <p class="text-sm md:text-base font-black text-emerald-700">Rp {{ number_format($budgetSummary['total_income'] / 1000000, 0, ',', '.') }} Jt</p>
                    </div>
                    <div class="bg-amber-50/90 rounded-2xl p-3 text-center border border-amber-100">
                        <p class="text-[10px] font-extrabold text-amber-700 uppercase tracking-wider mb-0.5">Belanja</p>
                        <p class="text-sm md:text-base font-black text-amber-700">Rp {{ number_format($budgetSummary['total_expense'] / 1000000, 0, ',', '.') }} Jt</p>
                    </div>
                </div>

                <div class="relative flex-1 min-h-[220px] w-full">
                    <canvas id="budgetChart"></canvas>
                </div>

                <script>
                    window.villageBudgetData = {
                        income: {{ $budgetSummary['total_income'] }},
                        expense: {{ $budgetSummary['total_expense'] }}
                    };
                </script>
            </div>
            @endif
        </div>
    </div>

    {{-- Right Column: 4 Cols (Sidebar Panels) --}}
    <div class="lg:col-span-4 space-y-6">
        
        {{-- Quick Operations Panel --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6">
            <h3 class="font-extrabold text-slate-900 text-base mb-1">Aksi Cepat & Navigasi</h3>
            <p class="text-xs text-slate-500 mb-5">Pintasan operasional untuk efisiensi tugas kerja</p>
            
            <div class="space-y-2.5">
                <a href="{{ route('admin.news.create') }}" class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 hover:bg-sky-50/80 border border-slate-200/70 hover:border-sky-200 transition-all duration-200 cursor-pointer group">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-extrabold text-slate-900 group-hover:text-sky-700 transition-colors">Tulis Berita Baru</p>
                            <p class="text-[10px] text-slate-500">Buat artikel/pengumuman desa</p>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-sky-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>

                @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.approvals') }}" class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 hover:bg-amber-50/80 border border-slate-200/70 hover:border-amber-200 transition-all duration-200 cursor-pointer group">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-extrabold text-slate-900 group-hover:text-amber-800 transition-colors">Approval Berita</p>
                            <p class="text-[10px] text-slate-500">Review & publikasikan berita staf</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($stats['pending_approval'] > 0)
                        <span class="bg-amber-500 text-slate-950 font-black text-[10px] px-2 py-0.5 rounded-full">{{ $stats['pending_approval'] }}</span>
                        @endif
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>

                <a href="{{ route('admin.population.index') }}" class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/80 border border-slate-200/70 hover:border-emerald-200 transition-all duration-200 cursor-pointer group">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-extrabold text-slate-900 group-hover:text-emerald-700 transition-colors">Sync Data Penduduk</p>
                            <p class="text-[10px] text-slate-500">Update demografi dari Excel</p>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>

                <a href="{{ route('admin.budget.index') }}" class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/80 border border-slate-200/70 hover:border-emerald-200 transition-all duration-200 cursor-pointer group">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-extrabold text-slate-900 group-hover:text-emerald-700 transition-colors">Kelola APBDes</p>
                            <p class="text-[10px] text-slate-500">Upload laporan keuangan desa</p>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 hover:bg-indigo-50/80 border border-slate-200/70 hover:border-indigo-200 transition-all duration-200 cursor-pointer group">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-extrabold text-slate-900 group-hover:text-indigo-700 transition-colors">Manajemen Pengguna</p>
                            <p class="text-[10px] text-slate-500">Atur hak akses staf & admin</p>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>

                <a href="{{ route('admin.activity-logs') }}" class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 hover:bg-amber-50/80 border border-slate-200/70 hover:border-amber-200 transition-all duration-200 cursor-pointer group">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-extrabold text-slate-900 group-hover:text-amber-800 transition-colors">Log Aktivitas Sistem</p>
                            <p class="text-[10px] text-slate-500">Audit jejak aktivitas & akses</p>
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                @endif
            </div>
        </div>

        {{-- Role Privileges Info Card --}}
        <div class="bg-gradient-to-br from-slate-900 to-slate-950 rounded-3xl p-6 text-white border border-slate-800 shadow-lg relative overflow-hidden">
            <div class="relative z-10 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="px-2.5 py-0.5 rounded-md text-[9px] font-extrabold tracking-wider uppercase bg-sky-500/20 text-sky-300 border border-sky-500/30">
                        Otorisasi Akun
                    </span>
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                </div>
                <h4 class="font-extrabold text-base text-white">Hak Akses: {{ Auth::user()->roleLabel() }}</h4>
                <ul class="text-xs text-slate-300 space-y-2 list-disc list-inside leading-relaxed font-medium">
                    @if(Auth::user()->isSuperAdmin())
                        <li>Persetujuan & penolakan publikasi berita.</li>
                        <li>Sinkronisasi data kependudukan & APBDes.</li>
                        <li>Kelola slide hero & profil desa.</li>
                        <li>Manajemen seluruh akun pengguna.</li>
                    @else
                        <li>Menulis & menyimpan draf berita baru.</li>
                        <li>Mengajukan berita untuk approval Super Admin.</li>
                        <li>Mengubah password & profil akun pribadi.</li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- Help & System Status Widget --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h4 class="font-extrabold text-slate-900 text-sm">Status Informasi Desa</h4>
            </div>
            
            <div class="space-y-2.5 text-xs">
                <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500">Penduduk Terakhir</span>
                    <span class="font-extrabold text-slate-900">{{ $latestPopulation ? $latestPopulation->year : '-' }}</span>
                </div>
                <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500">APBDes Terakhir</span>
                    <span class="font-extrabold text-slate-900">{{ $budgetSummary ? $budgetSummary['year'] : '-' }}</span>
                </div>
                <div class="flex items-center justify-between py-1.5">
                    <span class="text-slate-500">Status Server</span>
                    <span class="font-bold text-emerald-600 inline-flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Online
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
