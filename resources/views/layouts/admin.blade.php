<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — SID Bawangan Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fira+Code:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-slate-100/90 text-slate-800 selection:bg-sky-500 selection:text-white">

    <div class="flex h-screen overflow-hidden relative">

        {{-- Mobile Backdrop Overlay --}}
        <div id="mobileSidebarBackdrop" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-30 hidden transition-opacity duration-300 md:hidden cursor-pointer"></div>

        {{-- Sidebar --}}
        <aside id="adminSidebar" class="fixed md:static inset-y-0 left-0 w-72 bg-slate-950 text-white flex flex-col shrink-0 border-r border-slate-800/80 shadow-2xl z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
            
            {{-- Brand Header --}}
            <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800/80 shrink-0 bg-slate-950">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-sky-500 rounded-xl p-1">
                    <div class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center p-1.5 group-hover:scale-105 transition-transform duration-200 shadow-inner">
                        <img src="{{ asset('logo/jombang.png') }}" alt="Logo Jombang" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="font-extrabold text-sm tracking-wide text-white group-hover:text-sky-400 transition-colors">SID Bawangan</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        </div>
                        <span class="text-[11px] text-slate-400 font-medium block">Portal Administrasi Desa</span>
                    </div>
                </a>
                <button id="mobileSidebarClose" class="md:hidden text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-900 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- User Role Card --}}
            <div class="p-4 border-b border-slate-800/80 shrink-0 bg-gradient-to-r from-slate-900/90 to-slate-950">
                <div class="flex items-center gap-3 bg-slate-900/80 p-3 rounded-2xl border border-slate-800">
                    <div class="w-10 h-10 rounded-xl {{ Auth::user()->isSuperAdmin() ? 'bg-gradient-to-tr from-amber-500 to-sky-600' : 'bg-gradient-to-tr from-sky-600 to-emerald-600' }} flex items-center justify-center font-extrabold text-white shadow-md overflow-hidden shrink-0 border border-white/20">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-xs font-bold text-slate-100 truncate">{{ Auth::user()->name }}</p>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            @if(Auth::user()->isSuperAdmin())
                                <span class="px-2 py-0.5 rounded-md text-[9px] font-extrabold tracking-wider uppercase bg-amber-500/20 text-amber-300 border border-amber-500/30">Super Admin</span>
                            @else
                                <span class="px-2 py-0.5 rounded-md text-[9px] font-extrabold tracking-wider uppercase bg-sky-500/20 text-sky-300 border border-sky-500/30">Staf Admin</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Navigation Links --}}
            <nav class="flex-1 overflow-y-auto p-4 space-y-1 custom-scrollbar">
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-1">Utama</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-sky-600 to-sky-700 text-white shadow-md shadow-sky-600/30 font-bold border-l-4 border-sky-400' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Dashboard</span>
                </a>

                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-6">Informasi & Berita</p>
                
                <a href="{{ route('admin.news.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.news.*') ? 'bg-gradient-to-r from-sky-600 to-sky-700 text-white shadow-md shadow-sky-600/30 font-bold border-l-4 border-sky-400' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    <span>Berita Desa</span>
                </a>

                @if(Auth::user()->isSuperAdmin())
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-6">Manajemen Konten Web</p>

                <a href="{{ route('admin.content.slides') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.content.slides*') ? 'bg-gradient-to-r from-sky-600 to-sky-700 text-white shadow-md shadow-sky-600/30 font-bold border-l-4 border-sky-400' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Slide Hero Utama</span>
                </a>

                <a href="{{ route('admin.content.visi-misi') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.content.visi-misi*') ? 'bg-gradient-to-r from-sky-600 to-sky-700 text-white shadow-md shadow-sky-600/30 font-bold border-l-4 border-sky-400' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>Visi & Misi</span>
                </a>

                <a href="{{ route('admin.content.sejarah') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.content.sejarah*') ? 'bg-gradient-to-r from-sky-600 to-sky-700 text-white shadow-md shadow-sky-600/30 font-bold border-l-4 border-sky-400' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Sejarah Desa</span>
                </a>

                <a href="{{ route('admin.content.profile') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.content.profile*') ? 'bg-gradient-to-r from-sky-600 to-sky-700 text-white shadow-md shadow-sky-600/30 font-bold border-l-4 border-sky-400' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V5m0 6h4m-4 0H9"/></svg>
                    <span>Profil Desa</span>
                </a>

                <a href="{{ route('admin.content.sambutan') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.content.sambutan*') ? 'bg-gradient-to-r from-sky-600 to-sky-700 text-white shadow-md shadow-sky-600/30 font-bold border-l-4 border-sky-400' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <span>Sambutan Kades</span>
                </a>

                <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.galleries.*') ? 'bg-gradient-to-r from-sky-600 to-sky-700 text-white shadow-md shadow-sky-600/30 font-bold border-l-4 border-sky-400' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Galeri Kegiatan</span>
                </a>

                <a href="{{ route('admin.approvals') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.approvals') ? 'bg-gradient-to-r from-sky-600 to-sky-700 text-white shadow-md shadow-sky-600/30 font-bold border-l-4 border-sky-400' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Approval Berita</span>
                    </div>
                    @php $pendingCount = \App\Models\News::where('status', 'submitted')->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="bg-amber-400 text-slate-950 font-black text-[10px] px-2 py-0.5 rounded-full shadow-sm animate-pulse">{{ $pendingCount }}</span>
                    @endif
                </a>

                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-6">Data & Publikasi</p>
                
                <a href="{{ route('admin.leaders.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.leaders.*') ? 'bg-gradient-to-r from-sky-600 to-sky-700 text-white shadow-md shadow-sky-600/30 font-bold border-l-4 border-sky-400' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Perangkat Desa</span>
                </a>

                <a href="{{ route('admin.population.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.population.*') ? 'bg-gradient-to-r from-sky-600 to-sky-700 text-white shadow-md shadow-sky-600/30 font-bold border-l-4 border-sky-400' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>Data Kependudukan</span>
                </a>

                <a href="{{ route('admin.budget.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.budget.*') ? 'bg-gradient-to-r from-sky-600 to-sky-700 text-white shadow-md shadow-sky-600/30 font-bold border-l-4 border-sky-400' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Transparansi APBDes</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-sky-600 to-sky-700 text-white shadow-md shadow-sky-600/30 font-bold border-l-4 border-sky-400' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span>Manajemen Pengguna</span>
                </a>

                <a href="{{ route('admin.activity-logs') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.activity-logs*') ? 'bg-gradient-to-r from-sky-600 to-sky-700 text-white shadow-md shadow-sky-600/30 font-bold border-l-4 border-sky-400' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    <span>Log Aktivitas (Audit)</span>
                </a>
                @endif

                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 mt-6">Akun</p>

                <a href="{{ route('admin.account.change-password') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.account.*') ? 'bg-gradient-to-r from-sky-600 to-sky-700 text-white shadow-md shadow-sky-600/30 font-bold border-l-4 border-sky-400' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span>Keamanan & Password</span>
                </a>
            </nav>

            {{-- Sidebar Footer --}}
            <div class="p-4 border-t border-slate-800/80 shrink-0 bg-slate-950">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center gap-2.5 w-full px-4 py-2.5 rounded-xl text-xs font-extrabold text-rose-400 bg-rose-500/10 hover:bg-rose-500/20 hover:text-rose-300 border border-rose-500/20 transition-all duration-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-rose-500">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Keluar dari Sistem</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content Window --}}
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-100/90">
            
            {{-- Topbar Header --}}
            <header class="h-20 bg-white/95 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-4 md:px-8 shrink-0 z-20 shadow-xs">
                <div class="flex items-center gap-3 min-w-0">
                    <button id="mobileSidebarToggle" class="md:hidden text-slate-600 hover:text-slate-900 p-2 rounded-xl hover:bg-slate-100 border border-slate-200/80 transition-colors cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div>
                        <h1 class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight truncate">@yield('title')</h1>
                        <p class="text-[11px] font-medium text-slate-500 hidden sm:block">Sistem Informasi Desa Bawangan, Kecamatan Ploso, Kab. Jombang</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 shrink-0">
                    <span class="hidden lg:inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold border border-slate-200/80">
                        <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>{{ now()->translatedFormat('l, d M Y') }}</span>
                    </span>

                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-sky-800 bg-sky-50 hover:bg-sky-100 border border-sky-200/80 transition-all duration-200 shadow-xs hover:shadow-md cursor-pointer">
                        <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span class="hidden sm:inline">Lihat Web Publik</span>
                    </a>
                </div>
            </header>

            {{-- Flash Alerts --}}
            @if(session('success'))
            <div class="mx-4 md:mx-8 mt-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200/90 text-emerald-950 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-bold shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-xs md:text-sm font-bold">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mx-4 md:mx-8 mt-6 p-4 rounded-2xl bg-rose-50 border border-rose-200/90 text-rose-950 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center font-bold shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <span class="text-xs md:text-sm font-bold">{{ session('error') }}</span>
                </div>
            </div>
            @endif

            {{-- Scrollable Main View --}}
            <div class="flex-1 overflow-y-auto p-4 md:p-8 lg:p-10 custom-scrollbar space-y-8">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>


