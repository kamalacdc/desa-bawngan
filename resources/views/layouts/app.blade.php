<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Website Resmi Pemerintah Desa Bawangan - Sistem Informasi Desa. Mewujudkan desa mandiri, berbudaya, maju, dan sejahtera.')">
    <meta name="keywords" content="Desa Bawangan, Sistem Informasi Desa, SID Bawangan, Pemerintah Desa, Ploso, Jombang">
    <link rel="icon" href="{{ asset('logo/jombang.png') }}" type="image/png">
    <title>@yield('title', 'Desa Bawangan') DESA BAWANGAN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-sans antialiased text-slate-800 bg-slate-50 selection:bg-sky-500 selection:text-white">

    {{-- ═══ NAVBAR — Floating Glassmorphism ═══ --}}
    @php
        $villageProfile = $profile ?? \App\Models\VillageProfile::current();
        $rawPhone = !empty($villageProfile->phone) ? preg_replace('/[^0-9]/', '', $villageProfile->phone) : '6285806424049';
        if (str_starts_with($rawPhone, '0')) {
            $waPhone = '62' . substr($rawPhone, 1);
        } else {
            $waPhone = $rawPhone;
        }
    @endphp

    <nav id="main-navbar"
        class="fixed top-4 left-4 right-4 sm:left-6 sm:right-6 lg:left-8 lg:right-8 z-50 transition-all duration-500 bg-white/60 backdrop-blur-2xl border border-white/40 shadow-lg shadow-black/[0.04] rounded-2xl"
        style="max-width: 1400px; margin-left: auto; margin-right: auto;">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 lg:h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group focus:outline-none focus:ring-2 focus:ring-sky-500/50 rounded-xl p-1">
                    <div class="w-9 h-9 rounded-xl overflow-hidden flex items-center justify-center  group-hover:scale-105 transition-transform duration-200 shadow-sm">
                        <img src="{{ asset('logo/jombang.png') }}" alt="Logo Desa Bawangan"
                            class="w-full h-full object-contain">
                    </div>
                    <div class=" sm:block">
                        <span class="block text-sm font-extrabold text-slate-900 leading-tight tracking-wide group-hover:text-sky-700 transition-colors">DESA BAWANGAN</span>
                        <span class="block text-[10px] font-medium text-slate-500 leading-tight">Kec. Ploso, Kab. Jombang</span>
                    </div>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden lg:flex items-center gap-1 ml-auto mr-4">
                    <a href="{{ route('home') }}"
                        class="floating-nav-link {{ request()->routeIs('home') ? 'floating-nav-link-active' : '' }}">Beranda</a>
                    <!-- <a href="{{ route('home') }}#profil"
                        class="floating-nav-link">Tentang Desa</a>
                    <a href="{{ route('home') }}#perangkat"
                        class="floating-nav-link">Struktural</a>
                    <a href="{{ route('home') }}#galeri"
                        class="floating-nav-link">Galeri</a> -->
                    <a href="{{ route('demografi') }}"
                        class="floating-nav-link {{ request()->routeIs('demografi*') ? 'floating-nav-link-active' : '' }}">Demografi</a>
                    <a href="{{ route('apbdes') }}"
                        class="floating-nav-link {{ request()->routeIs('apbdes*') ? 'floating-nav-link-active' : '' }}">Anggaran</a>
                    <div class="relative group">
                        <a href="{{ route('berita') }}#berita-list"
                            class="floating-nav-link {{ request()->routeIs('berita*') ? 'floating-nav-link-active' : '' }} inline-flex items-center gap-1 cursor-pointer">
                            <span>Berita</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 group-hover:rotate-180 group-hover:text-sky-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <div
                            class="absolute right-0 top-full mt-3 w-56 rounded-2xl border border-white/50 bg-white/70 backdrop-blur-2xl p-2 shadow-xl shadow-black/[0.08] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0">
                            <a href="{{ route('berita', ['kategori' => 'berita-desa']) }}#berita-list"
                                class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 text-xs font-semibold text-slate-700 hover:bg-sky-50/80 hover:text-sky-700 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span> Berita Desa
                            </a>
                            <a href="{{ route('berita', ['kategori' => 'pengumuman']) }}#berita-list"
                                class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 text-xs font-semibold text-slate-700 hover:bg-amber-50/80 hover:text-amber-700 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Pengumuman
                            </a>
                            <a href="{{ route('berita', ['kategori' => 'kegiatan-warga']) }}#berita-list"
                                class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 text-xs font-semibold text-slate-700 hover:bg-emerald-50/80 hover:text-emerald-700 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Kegiatan Warga
                            </a>
                            <a href="{{ route('berita', ['kategori' => 'pembangunan']) }}#berita-list"
                                class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 text-xs font-semibold text-slate-700 hover:bg-purple-50/80 hover:text-purple-700 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-purple-500"></span> Pembangunan
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Login Button + Mobile Toggle --}}
                <div class="flex items-center gap-2">
                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                            class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-sky-600 to-emerald-500 text-white shadow-md shadow-sky-600/20 hover:shadow-sky-600/35 transition-all hover:-translate-y-0.5 active:translate-y-0 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-sky-600 to-emerald-500 text-white shadow-md shadow-sky-600/20 hover:shadow-sky-600/35 hover:-translate-y-0.5 active:translate-y-0 transition-all cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Login
                        </a>
                    @endauth
                    <button id="mobile-menu-toggle"
                        aria-label="Toggle Navigation Menu"
                        class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-white/60 transition-colors focus:outline-none focus:ring-2 focus:ring-sky-500/50 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="lg:hidden hidden border-t border-white/30 bg-white/50 backdrop-blur-2xl rounded-b-2xl">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('home') }}" class="mobile-nav-link">Beranda</a>
                <!-- <a href="{{ route('home') }}#profil" class="mobile-nav-link">Tentang Desa</a>
                <a href="{{ route('home') }}#perangkat" class="mobile-nav-link">Struktural</a>
                <a href="{{ route('home') }}#galeri" class="mobile-nav-link">Galeri</a> -->
                <a href="{{ route('demografi') }}" class="mobile-nav-link {{ request()->routeIs('demografi*') ? 'font-bold text-sky-700' : '' }}">Demografi</a>
                <a href="{{ route('apbdes') }}" class="mobile-nav-link {{ request()->routeIs('apbdes*') ? 'font-bold text-sky-700' : '' }}">Anggaran</a>
                <div class="space-y-1">
                    <button type="button" id="mobile-news-toggle" aria-expanded="false"
                        class="mobile-nav-link flex items-center justify-between w-full text-left">
                        <span>Berita & Informasi</span>
                        <svg id="mobile-news-icon" class="w-4 h-4 transition-transform duration-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="mobile-news-menu" class="hidden pl-4 pt-2 space-y-1">
                        <a href="{{ route('berita', ['kategori' => 'berita-desa']) }}#berita-list"
                            class="block text-sm font-medium text-slate-600 hover:text-sky-700 py-1.5">Berita Desa</a>
                        <a href="{{ route('berita', ['kategori' => 'pengumuman']) }}#berita-list"
                            class="block text-sm font-medium text-slate-600 hover:text-sky-700 py-1.5">Pengumuman</a>
                        <a href="{{ route('berita', ['kategori' => 'kegiatan-warga']) }}#berita-list"
                            class="block text-sm font-medium text-slate-600 hover:text-sky-700 py-1.5">Kegiatan Warga</a>
                        <a href="{{ route('berita', ['kategori' => 'pembangunan']) }}#berita-list"
                            class="block text-sm font-medium text-slate-600 hover:text-sky-700 py-1.5">Pembangunan</a>
                    </div>
                </div>

                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="block w-full mt-3 text-center px-4 py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-sky-600 to-emerald-500 text-white shadow-md">Dashboard Admin</a>
                @else
                    <a href="{{ route('login') }}"
                        class="block w-full mt-3 text-center px-4 py-3 rounded-xl text-sm font-bold bg-gradient-to-r from-sky-600 to-emerald-500 text-white shadow-md">Portal Login</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ═══ FLOATING WHATSAPP BUTTON ═══ --}}
    <a href="https://wa.me/{{ $waPhone }}" target="_blank" rel="noopener noreferrer" id="wa-fab"
        class="fixed bottom-6 right-6 z-50 group flex items-center gap-3 transition-all duration-300 hover:-translate-y-1">
        {{-- Tooltip Label --}}
        <span class="hidden sm:block opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0 transition-all duration-300 px-3 py-1.5 rounded-xl bg-slate-900/80 backdrop-blur-md text-white text-xs font-bold shadow-lg whitespace-nowrap pointer-events-none">
            Chat WhatsApp Desa
        </span>
        {{-- Button --}}
        <div class="relative">
            {{-- Pulse Ring --}}
            <span class="absolute inset-0 rounded-full bg-emerald-400 animate-ping opacity-20"></span>
            <div class="relative w-14 h-14 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 text-white flex items-center justify-center shadow-xl shadow-emerald-600/30 hover:shadow-emerald-600/50 transition-shadow">
                <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
            </div>
        </div>
    </a>

    {{-- Spacer for floating navbar — only on non-home pages (home has fullscreen hero that goes behind navbar) --}}
    @unless(request()->routeIs('home'))
        <div class="h-24 lg:h-28"></div>
    @endunless

    {{-- ═══ MAIN CONTENT ═══ --}}
    <main>
        @yield('content')
    </main>

    {{-- ═══ FOOTER ═══ --}}
    <footer class="bg-slate-950 text-slate-300 pt-16 pb-10 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-12">
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center p-1">
                            <img src="{{ asset('logo/jombang.png') }}" alt="Logo Desa Bawangan"
                                class="w-full h-full object-contain">
                        </div>
                        <div>
                            <span class="block text-sm font-extrabold text-white leading-tight tracking-wide">DESA BAWANGAN</span>
                            <span class="block text-xs text-slate-400 leading-tight">Kec. Ploso, Kab. Jombang</span>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm leading-relaxed text-slate-400">
                        Berkomitmen memberikan pelayanan publik yang transparan, akuntabel, profesional, serta memajukan perekonomian dan kesejahteraan warga Desa Bawangan.
                    </p>
                </div>
                <div>
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-5 text-sky-400">Kontak & Layanan</h4>
                    <ul class="text-xs sm:text-sm space-y-3.5 text-slate-400">
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 mt-0.5 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Jalan Tanjung Wadung No. 17 Bawangan, Ploso, Jombang, Jawa Timur (61453)</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>085231263646</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>desabawanganmajubersama@gmail.com</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-5 text-sky-400">Jam Operasional Kantor</h4>
                    <div class="space-y-3 text-xs sm:text-sm text-slate-400">
                        <div class="flex justify-between items-center bg-slate-900/60 p-3 rounded-xl border border-slate-800">
                            <span class="font-medium text-slate-300">Senin – Jumat</span>
                            <span class="text-sky-400 font-bold">08.00 – 14.00 WIB</span>
                        </div>
                        <div class="flex justify-between items-center bg-slate-900/60 p-3 rounded-xl border border-slate-800">
                            <span class="font-medium text-slate-300">Sabtu – Minggu</span>
                            <span class="text-rose-400 font-bold">Tutup / Libur</span>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="border-t border-slate-800/80 mt-12 pt-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Pemerintah Desa Bawangan. Hak Cipta Dilindungi.</p>
                <p class="flex items-center gap-1.5">
                    kpm kelompok 1 bawangan ❤️❤️
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileNewsToggle = document.getElementById('mobile-news-toggle');
            const mobileNewsMenu = document.getElementById('mobile-news-menu');
            const mobileNewsIcon = document.getElementById('mobile-news-icon');

            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            if (mobileNewsToggle && mobileNewsMenu && mobileNewsIcon) {
                mobileNewsToggle.addEventListener('click', function() {
                    const isExpanded = mobileNewsToggle.getAttribute('aria-expanded') === 'true';
                    mobileNewsToggle.setAttribute('aria-expanded', String(!isExpanded));
                    mobileNewsMenu.classList.toggle('hidden');
                    mobileNewsIcon.classList.toggle('rotate-180');
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>

