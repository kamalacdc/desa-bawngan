@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_description', 'Website Resmi Pemerintah Desa Bawangan Merawat tradisi, mendorong kemandirian ekonomi, dan
    membangun masa depan desa yang sejahtera.')

    @push('styles')
        <style>
            @keyframes marquee {
                0% {
                    transform: translateX(0%);
                }

                100% {
                    transform: translateX(-50%);
                }
            }

            .animate-marquee {
                display: inline-flex;
                animation: marquee 50s linear infinite;
                white-space: nowrap;
                will-change: transform;
            }

            /* Main Hero Carousel Navigation Buttons: Revealed ONLY when cursor is very close to the button */
            .hero-nav-wrapper .carousel-nav-btn {
                opacity: 0;
                pointer-events: none;
                transform: scale(0.85);
                transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out, background-color 0.3s ease-in-out;
            }

            .hero-nav-wrapper:hover .carousel-nav-btn {
                opacity: 1;
                pointer-events: auto;
                transform: scale(1);
            }
        </style>
    @endpush

@section('content')

    {{-- ═══ HERO CAROUSEL ═══ --}}
    <section class="relative h-[calc(100vh-52px)] min-h-[580px] overflow-hidden bg-slate-900">
        @if ($slides->isNotEmpty())
            <div id="hero-carousel" class="relative w-full h-full">
                {{-- Slides --}}
                @foreach ($slides as $index => $slide)
                    <div class="hero-slide absolute inset-0 transition-opacity duration-700 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                        data-slide="{{ $index }}">
                        {{-- Background Image --}}
                        @if ($slide->image)
                            <div class="absolute inset-0 bg-cover bg-center"
                                style="background-image: url('{{ asset('storage/' . $slide->image) }}')"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-sky-950 to-emerald-950"></div>
                        @endif
                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
                        {{-- Animated dots pattern --}}
                        <div
                            class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.03%22%3E%3Ccircle%20cx%3D%2230%22%20cy%3D%2230%22%20r%3D%221.5%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-60">
                        </div>

                        {{-- Content --}}
                        <div class="relative z-10 h-full flex items-center pt-12 pb-8">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                                <div class="max-w-2xl">
                                    @if ($slide->subtitle)
                                        <div
                                            class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/10 text-emerald-300 text-xs font-semibold mb-6">
                                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                            {{ $slide->subtitle }}
                                        </div>
                                    @endif
                                    <h2
                                        class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight mb-5">
                                        {{ $slide->title }}
                                    </h2>
                                    @if ($slide->description)
                                        <p class="text-base sm:text-lg text-slate-300 leading-relaxed mb-8 max-w-xl">
                                            {{ $slide->description }}
                                        </p>
                                    @endif
                                    @if ($slide->button_text && $slide->button_url)
                                        <a href="{{ $slide->button_url }}"
                                            class="group inline-flex items-center gap-2 px-6 py-3 rounded-2xl font-semibold text-sm bg-gradient-to-r from-sky-500 to-emerald-500 text-white shadow-xl shadow-sky-600/30 hover:shadow-sky-600/50 transition-all hover:-translate-y-0.5">
                                            {{ $slide->button_text }}
                                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Navigation Arrows --}}
                @if ($slides->count() > 1)
                    <div class="hero-nav-wrapper absolute left-0 top-1/2 -translate-y-1/2 z-20 p-6 sm:p-10 flex items-center justify-center">
                        <button id="carousel-prev-hero"
                            class="carousel-nav-btn w-11 h-11 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white flex items-center justify-center hover:bg-white/35 transition-all duration-300 group hover:scale-105 active:scale-95 shadow-lg cursor-pointer"
                            aria-label="Slide sebelumnya">
                            <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                    </div>
                    <div class="hero-nav-wrapper absolute right-0 top-1/2 -translate-y-1/2 z-20 p-6 sm:p-10 flex items-center justify-center">
                        <button id="carousel-next-hero"
                            class="carousel-nav-btn w-11 h-11 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white flex items-center justify-center hover:bg-white/35 transition-all duration-300 group hover:scale-105 active:scale-95 shadow-lg cursor-pointer"
                            aria-label="Slide selanjutnya">
                            <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
        @else
            {{-- Fallback if no slides --}}
            <div class="relative h-full flex items-center bg-gradient-to-br from-slate-900 via-sky-950 to-emerald-950">
                <div
                    class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.03%22%3E%3Ccircle%20cx%3D%2230%22%20cy%3D%2230%22%20r%3D%221.5%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-60">
                </div>
                <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    <div class="max-w-3xl">
                        <div
                            class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/10 text-emerald-300 text-xs font-semibold mb-8 animate-fade-in-up">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Sistem Informasi Desa
                        </div>
                        <h1
                            class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6 animate-fade-in-up animation-delay-100">
                            Selamat Datang di <br>
                            <span
                                class="bg-gradient-to-r from-sky-400 via-emerald-300 to-amber-300 bg-clip-text text-transparent">Desa
                                Bawangan</span>
                        </h1>
                        <p
                            class="text-lg sm:text-xl text-slate-300 leading-relaxed mb-10 max-w-2xl animate-fade-in-up animation-delay-200">
                            Merawat tradisi sejarah, mendorong kemandirian ekonomi lewat UMKM unggulan, dan membangun masa
                            depan desa yang sejahtera.
                        </p>
                        <div class="flex flex-wrap gap-4 animate-fade-in-up animation-delay-300">
                            <a href="#profil"
                                class="group inline-flex items-center gap-2 px-6 py-3 rounded-2xl font-semibold text-sm bg-gradient-to-r from-sky-500 to-emerald-500 text-white shadow-xl shadow-sky-600/30 hover:shadow-sky-600/50 transition-all hover:-translate-y-0.5">
                                Jelajahi Profil Desa
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                            <a href="{{ route('berita') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl font-semibold text-sm bg-white/10 backdrop-blur-md border border-white/20 text-white hover:bg-white/20 hover:-translate-y-0.5 active:translate-y-0 transition-all cursor-pointer">
                                <svg class="w-4 h-4 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <span>Baca Berita Desa</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Hero bottom semi-blur effect --}}
        <div
            class="absolute bottom-0 inset-x-0 z-20 h-4 sm:h-6 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent backdrop-blur-sm pointer-events-none">
        </div>
    </section>

    {{-- ═══ RUNNING TEXT ANNOUNCEMENT BANNER ═══ --}}
    <div class="relative z-30 bg-slate-900 border-y border-slate-800 text-white shadow-xl overflow-hidden py-3.5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-4">
            {{-- Info Badge Label --}}
            <div
                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-sky-600 to-emerald-600 text-white text-xs font-extrabold tracking-wider uppercase shrink-0 shadow-md">
                <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
                <span>INFO DESA</span>
            </div>

            {{-- Running Text Marquee Container --}}
            <div class="overflow-hidden flex-1 relative whitespace-nowrap">
                <div
                    class="inline-flex animate-marquee hover:[animation-play-state:paused] items-center gap-8 text-xs sm:text-sm font-medium text-slate-300">
                    {{-- Copy 1 --}}
                    <span class="inline-flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Selamat Datang di Website Resmi Desa Bawangan, Kecamatan Ploso, Kabupaten Jombang.
                    </span>
                    <span class="text-sky-400 font-bold">•</span>
                    <span class="inline-flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                        Layanan Pelayanan Publik Kantor Desa Buka Setiap Hari Kerja (Senin – Jumat, 08.00 – 14.00 WIB).
                    </span>
                    <span class="text-sky-400 font-bold">•</span>
                    @if (isset($latestNews) && $latestNews->isNotEmpty())
                        @foreach ($latestNews as $newsItem)
                            <a href="{{ route('berita.detail', $newsItem->slug) }}"
                                class="inline-flex items-center gap-2 hover:text-emerald-300 transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                <span class="text-amber-300 font-extrabold">KABAR DESA:</span> {{ $newsItem->title }}
                            </a>
                            <span class="text-sky-400 font-bold">•</span>
                        @endforeach
                    @endif
                    <span class="inline-flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Merawat Tradisi, Mendorong Kemandirian Ekonomi, dan Membangun Desa Bawangan Yang Sejahtera.
                    </span>
                    <span class="text-sky-400 font-bold">•</span>

                    {{-- Copy 2 (For seamless infinite looping) --}}
                    <span class="inline-flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Selamat Datang di Website Resmi Desa Bawangan, Kecamatan Ploso, Kabupaten Jombang.
                    </span>
                    <span class="text-sky-400 font-bold">•</span>
                    <span class="inline-flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                        Layanan Pelayanan Publik Kantor Desa Buka Setiap Hari Kerja (Senin – Jumat, 08.00 – 14.00 WIB).
                    </span>
                    <span class="text-sky-400 font-bold">•</span>
                    @if (isset($latestNews) && $latestNews->isNotEmpty())
                        @foreach ($latestNews as $newsItem)
                            <a href="{{ route('berita.detail', $newsItem->slug) }}"
                                class="inline-flex items-center gap-2 hover:text-emerald-300 transition-colors">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                <span class="text-amber-300 font-extrabold">KABAR DESA:</span> {{ $newsItem->title }}
                            </a>
                            <span class="text-sky-400 font-bold">•</span>
                        @endforeach
                    @endif
                    <span class="inline-flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Merawat Tradisi, Mendorong Kemandirian Ekonomi, dan Membangun Desa Bawangan Yang Sejahtera.
                    </span>
                    <span class="text-sky-400 font-bold">•</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ 2 CARD BESAR: PROFIL DESA + SAMBUTAN KADES ═══ --}}
    <section id="profil" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <div class="section-badge mx-auto">
                    <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V5m0 6h4m-4 0H9" />
                    </svg>
                    <span>Tentang Desa</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Profil <span
                        class="text-sky-700">Desa Bawangan</span></h2>
            </div>

            <div
                class="glass-card p-8 relative overflow-hidden group hover:shadow-2xl transition-shadow duration-300 mb-12">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center ">
                            <img src="{{ asset('logo/jombang.png') }}" alt="Logo Jombang"
                                class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Sejarah & Profil Desa</h3>
                            <p class="text-xs text-slate-500">Ringkasan identitas, sejarah, dan kondisi Desa Bawangan.</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-6">
                        {{-- Sejarah Desa --}}
                        <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80">
                            <h4 class="text-sm font-bold text-slate-700 mb-3">Sejarah Desa</h4>
                            <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                                {{ $profile->history ?? 'Desa Bawangan merupakan desa yang kaya akan nilai sejarah dan adat istiadat yang kental. Berdiri sejak bertahun-tahun lalu, nama Bawangan melambangkan ketangguhan dan gotong royong warganya.' }}
                            </p>
                        </div>

                        {{-- Profil Desa (Narasi di bawah Sejarah Desa) --}}
                        <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80">
                            <h4 class="text-sm font-bold text-slate-700 mb-3">Profil Desa</h4>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                {{ $profile->name ?? 'Desa Bawangan' }} adalah desa yang berlokasi di
                                {{ !empty($profile->address) ? $profile->address : 'Kecamatan Ploso, Kabupaten Jombang' }}
                                dengan total luas wilayah mencakup {{ $profile->area ?? '124 Ha' }}. Sebagai pusat
                                pemerintahan dan pelayanan masyarakat, Desa Bawangan selalu berupaya meningkatkan kualitas
                                pelayanan publik yang ramah, transparan, dan akuntabel demi kemajuan serta kesejahteraan
                                seluruh warga.
                                @if (!empty($profile->phone) || !empty($profile->email))
                                    Masyarakat dapat menghubungi kantor desa melalui
                                    @if (!empty($profile->phone))
                                        telepon <span class="font-semibold text-slate-700">{{ $profile->phone }}</span>
                                    @endif
                                    @if (!empty($profile->phone) && !empty($profile->email))
                                        maupun
                                    @endif
                                    @if (!empty($profile->email))
                                        email <span class="font-semibold text-slate-700">{{ $profile->email }}</span>
                                    @endif.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                {{-- Card 1: Visi & Misi Desa --}}
                <div class="glass-card p-8 relative overflow-hidden group hover:shadow-2xl transition-shadow duration-300">
                    <div class="relative z-10 flex flex-col">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center ">
                                <img src="{{ asset('logo/jombang.png') }}" alt="Logo Jombang"
                                    class="w-full h-full object-contain">
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-800">Visi & Misi Desa</h3>
                                <p class="text-xs text-slate-500">Fokus pada arah dan tujuan Desa Bawangan.</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-6 mt-2">
                            <div class="bg-slate-50 rounded-xl p-5 border border-slate-200/80">
                                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Visi Desa</h4>
                                <p class="text-slate-700 text-sm  leading-relaxed">
                                    "{{ $profile->vision ?? 'Mewujudkan Desa Bawangan yang mandiri, berbudaya, maju, sejahtera, dan transparan dalam pelayanan.' }}"
                                </p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-5 border border-slate-200/80">
                                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Misi Desa</h4>
                                <div class="text-slate-700 text-sm  leading-relaxed whitespace-pre-line">
                                    {{ $profile->mission ?? '1. Meningkatkan tata kelola pemerintahan yang baik.\n2. Memberdayakan ekonomi kerakyatan berbasis potensi lokal.\n3. Melestarikan budaya dan lingkungan.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="absolute -top-6 -right-6 w-28 h-28 bg-gradient-to-br from-sky-200 to-emerald-200 rounded-3xl -z-0 rotate-12 opacity-40 group-hover:rotate-6 transition-transform duration-500">
                    </div>
                </div>

                {{-- Card 2: Sambutan Kepala Desa --}}
                <div class="glass-card p-8 relative overflow-hidden group hover:shadow-2xl transition-shadow duration-300">
                    <div class="relative z-10 flex flex-col">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center ">
                                <img src="{{ asset('logo/jombang.png') }}" alt="Logo Jombang"
                                    class="w-full h-full object-contain">
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-800">
                                    {{ $profile->welcome_title ?? 'Sambutan Kepala Desa' }}</h3>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-8 items-start">
                            {{-- Foto, Nama & Jabatan Kades (Left Side) --}}
                            <div class="sm:w-48 shrink-0 text-center mx-auto sm:mx-0">
                                <div
                                    class="aspect-[3/4] rounded-2xl overflow-hidden bg-gradient-to-br from-sky-100 to-emerald-100 shadow-lg border-2 border-white mb-3">
                                    @if ($kades && $kades->photo)
                                        <img src="{{ asset('storage/' . $kades->photo) }}" alt="{{ $kades->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div
                                            class="w-full h-full flex flex-col items-center justify-center p-4 text-center">
                                            <div
                                                class="w-16 h-16 rounded-full bg-gradient-to-br from-sky-500 to-emerald-500 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                                                {{ $kades ? strtoupper(substr($kades->name, 0, 1)) : 'K' }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <p class="text-sm font-bold text-slate-800 leading-snug">
                                    {{ $kades->name ?? 'Kepala Desa' }}</p>
                                <p class="text-xs text-sky-600 font-semibold mt-0.5">
                                    {{ $kades->position ?? 'Kepala Desa Bawangan' }}</p>
                            </div>

                            {{-- Teks Sambutan Kades (Right Side) --}}
                            <div class="flex-1 bg-slate-50/70 rounded-2xl p-6 border border-slate-200/80 w-full">
                                <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                                    {{ $profile->welcome_speech ?? "Assalamu'alaikum Wr. Wb. Selamat datang di Website Resmi Desa Bawangan. Kami berkomitmen untuk memberikan pelayanan terbaik bagi seluruh warga dan masyarakat umum.\n\nMelalui website ini, kami berusaha mewujudkan transparansi informasi dan pelayanan publik yang semakin baik. Semoga website ini bermanfaat bagi kita semua.\n\nWassalamu'alaikum Wr. Wb." }}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Decorative --}}
                    <div
                        class="absolute -bottom-6 -left-6 w-28 h-28 bg-gradient-to-br from-amber-200 to-orange-200 rounded-3xl -z-0 -rotate-12 opacity-40 group-hover:-rotate-6 transition-transform duration-500">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ POTENSI UMKM ═══ --}}
    <section id="umkm" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <div class="section-badge-emerald mx-auto">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span>Ekonomi Kreatif</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Potensi <span
                        class="text-emerald-700">UMKM Desa</span></h2>
                <p class="text-slate-600 text-sm mt-3 max-w-xl mx-auto font-medium">Karya lokal kreatif dan produk unggulan
                    asli buatan warga Desa Bawangan.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($umkmList as $umkm)
                    <div
                        class="umkm-card group bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                        <div
                            class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-700 text-2xl mb-5 group-hover:scale-110 transition-transform duration-300">
                            {{ $umkm['ikon'] }}
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">{{ $umkm['nama'] }}</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-5">{{ $umkm['deskripsi'] }}</p>
                        <span
                            class="inline-block px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold">Produk
                            Unggulan</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    {{-- ═══ LEADERSHIP CAROUSEL ═══ --}}
    @if ($leaders->isNotEmpty())
        <section id="perangkat" class="py-24 bg-gradient-to-b from-slate-50 to-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <div class="section-badge mx-auto">
                        <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Perangkat Desa</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Struktur Pemerintahan
                        <span class="text-sky-700">Desa Bawangan</span></h2>
                    <p class="text-slate-600 text-sm mt-3 max-w-xl mx-auto font-medium">Perangkat desa yang bertugas
                        melayani masyarakat Desa
                        Bawangan dengan penuh dedikasi.</p>
                </div>

                <div class="leader-carousel-wrapper relative group/carousel" id="leader-carousel-wrapper">
                    {{-- Navigation Buttons --}}
                    <button id="leader-carousel-prev"
                        class="absolute -left-2 sm:-left-5 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-white/90 backdrop-blur-sm border border-slate-200 shadow-md flex items-center justify-center text-slate-700 hover:text-sky-600 hover:bg-white hover:border-sky-300 hover:shadow-xl transition-all duration-300 hover:scale-105 active:scale-95 opacity-100"
                        aria-label="Slide sebelumnya">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button id="leader-carousel-next"
                        class="absolute -right-2 sm:-right-5 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-white/90 backdrop-blur-sm border border-slate-200 shadow-md flex items-center justify-center text-slate-700 hover:text-sky-600 hover:bg-white hover:border-sky-300 hover:shadow-xl transition-all duration-300 hover:scale-105 active:scale-95 opacity-100"
                        aria-label="Slide selanjutnya">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    {{-- Carousel Track --}}
                    <div class="overflow-hidden rounded-xl">
                        <div id="leader-carousel" class="flex will-change-transform">
                            @foreach ($leaders as $leader)
                                <div class="leader-card shrink-0 px-3" style="width: calc(100% / var(--leader-cols, 4))">
                                    <div
                                        class="relative overflow-hidden rounded-2xl bg-white border border-slate-200/80 shadow-xs hover:shadow-xl transition-all duration-300 group">
                                        <div
                                            class="aspect-[4/5] w-full bg-gradient-to-br from-sky-100 to-emerald-100 flex items-center justify-center relative overflow-hidden">
                                            @if ($leader->photo)
                                                <img src="{{ asset('storage/' . $leader->photo) }}"
                                                    alt="{{ $leader->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-24 h-24 rounded-full bg-gradient-to-br from-sky-500 to-emerald-500 flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                                    {{ strtoupper(substr($leader->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                            </div>
                                        </div>
                                        <div class="p-5 text-center">
                                            <h4 class="font-bold text-slate-900 text-lg">{{ $leader->name }}</h4>
                                            <span
                                                class="inline-block mt-2 px-3 py-1 rounded-full bg-sky-50 text-sky-700 text-xs font-bold border border-sky-200/60">{{ $leader->position }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ═══ BERITA TERBARU ═══ --}}
    @if ($latestNews->isNotEmpty())
        <section class="py-24 bg-gradient-to-b from-slate-50 to-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-12 gap-4">
                    <div>
                        <div class="section-badge">
                            <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <span>Berita Terbaru</span>
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Kabar <span
                                class="text-sky-700">Desa Bawangan</span></h2>
                    </div>
                    <a href="{{ route('berita') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-sky-700 bg-sky-50 hover:bg-sky-100 transition-all border border-sky-200/60 cursor-pointer">
                        <span>Lihat Semua Berita</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($latestNews as $news)
                        <article
                            class="news-card group bg-white rounded-3xl overflow-hidden shadow-xs hover:shadow-2xl hover:shadow-slate-200/60 border border-slate-200/80 transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                            <a href="{{ route('berita.detail', $news->slug) }}" class="block">
                                <div
                                    class="relative h-56 sm:h-60 overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200">
                                    @if ($news->featured_image)
                                        <img src="{{ asset('storage/' . $news->featured_image) }}"
                                            alt="{{ $news->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-3 left-3">
                                        <span
                                            class="px-2.5 py-1 rounded-lg bg-white/90 backdrop-blur-sm text-xs font-semibold text-sky-700">{{ $news->category->name }}</span>
                                    </div>
                                </div>
                            </a>
                            <div class="p-5">
                                <div class="flex items-center justify-between text-xs text-slate-400 mb-3 flex-wrap gap-2">
                                    <div class="flex items-center gap-2">
                                        <span>{{ $news->published_at->translatedFormat('d M Y') }}</span>
                                        <span>·</span>
                                        <span>{{ $news->author->name }}</span>
                                    </div>
                                    <span
                                        class="flex items-center gap-1 text-slate-600 font-bold text-[11px] bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200/60"
                                        title="{{ number_format($news->views_count) }} kali dibaca">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        {{ number_format($news->views_count) }}x
                                    </span>
                                </div>
                                <h3
                                    class="font-bold text-slate-800 text-lg mb-2 group-hover:text-sky-700 transition-colors line-clamp-2">
                                    <a href="{{ route('berita.detail', $news->slug) }}">{{ $news->title }}</a>
                                </h3>
                                <p class="text-slate-500 text-sm leading-relaxed line-clamp-3">{{ $news->excerpt }}</p>
                                <a href="{{ route('berita.detail', $news->slug) }}"
                                    class="inline-flex items-center gap-1 mt-4 text-sm font-semibold text-sky-600 hover:text-sky-700 transition-colors">
                                    Baca Selengkapnya
                                    <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══ GALERI KEGIATAN DESA (Desain Referensi Desa Kebonagung) ═══ --}}
    @if ($galleries->isNotEmpty())
        <section id="galeri" class="py-20 bg-white border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Header Section --}}
                <div class="text-center mb-12">
                    <div class="section-badge-emerald mx-auto mb-3">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Dokumentasi Desa</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3 tracking-tight">Galeri <span
                            class="text-emerald-700">Kegiatan Desa</span></h2>
                    <div class="w-20 h-1 bg-gradient-to-r from-sky-600 to-emerald-600 mx-auto rounded-full mb-4"></div>
                    <p class="text-slate-600 text-sm max-w-2xl mx-auto font-medium">
                        Dokumentasi kegiatan, gotong royong, dan momen-momen penting di Desa Bawangan.
                    </p>
                </div>

                {{-- Grid Galeri (Ukuran Foto Diperbesar dengan Grid 3 Kolom & Modal Pop-Up) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach ($galleries as $item)
                        <div onclick="openGalleryModal(this)" data-title="{{ $item->title }}"
                            data-image="{{ asset('storage/' . $item->image) }}"
                            data-date="{{ $item->date ? $item->date->translatedFormat('d F Y') : '' }}"
                            data-category="{{ $item->category ?? '' }}"
                            data-description="{{ $item->description ?? '' }}"
                            class="group relative rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 aspect-[4/3] cursor-pointer border border-slate-200/80 bg-slate-900">

                            {{-- Foto Utama --}}
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                            {{-- Top-Right Badge (Kategori/Zoom Icon) --}}
                            <div class="absolute top-4 right-4 z-10">
                                @if ($item->category)
                                    <span
                                        class="px-3 py-1.5 rounded-full bg-black/50 backdrop-blur-md text-emerald-300 text-xs font-extrabold tracking-wider uppercase border border-emerald-400/30 flex items-center gap-1.5 shadow-md">
                                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        {{ $item->category }}
                                    </span>
                                @else
                                    <span
                                        class="p-2 rounded-full bg-black/50 backdrop-blur-md text-white/90 border border-white/20 flex items-center justify-center shadow-md">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                                        </svg>
                                    </span>
                                @endif
                            </div>

                            {{-- Overlay Caption on Hover --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5 sm:p-6 z-10">
                                @if ($item->date)
                                    <p class="text-xs font-semibold text-emerald-300 mb-1 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $item->date->translatedFormat('d F Y') }}</span>
                                    </p>
                                @endif
                                <p
                                    class="text-white font-extrabold text-base sm:text-lg leading-snug translate-y-3 group-hover:translate-y-0 transition-transform duration-300 line-clamp-2">
                                    {{ $item->title }}
                                </p>
                                <span
                                    class="inline-flex items-center gap-1.5 text-xs text-sky-300 font-bold mt-2.5 translate-y-3 group-hover:translate-y-0 transition-transform duration-300">
                                    <span>Lihat Foto Perbesar</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ═══ MODAL POP-UP GALERI (LIGHTBOX UKURAN BESAR) ═══ --}}
        <div id="galleryModal"
            class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-slate-950/85 backdrop-blur-md transition-opacity" onclick="closeGalleryModal()">
            </div>

            {{-- Modal Content Container --}}
            <div id="galleryModalContent"
                class="relative bg-white rounded-3xl shadow-2xl w-full max-w-5xl mx-auto overflow-hidden transform scale-95 opacity-0 transition-all duration-300 flex flex-col z-10 my-auto">

                {{-- Header --}}
                <div
                    class="bg-gradient-to-r from-sky-700 via-sky-800 to-emerald-700 px-6 py-4.5 flex justify-between items-center z-10 border-b border-white/10">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div
                            class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center shrink-0 border border-white/20">
                            <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 id="galleryModalTitle"
                                class="text-white font-extrabold text-base sm:text-lg leading-tight line-clamp-1">
                                Detail Foto Kegiatan
                            </h3>
                            <span id="galleryModalCategory" class="text-xs text-emerald-300 font-semibold block"></span>
                        </div>
                    </div>
                    <button onclick="closeGalleryModal()"
                        class="text-white/80 hover:text-white transition-colors p-2 rounded-xl hover:bg-white/10 shrink-0 cursor-pointer"
                        title="Tutup Modal">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Body Modal (Gambar Diperbesar Maksimal) --}}
                <div class="bg-slate-950 flex items-center justify-center relative p-4 sm:p-8 min-h-[55vh] max-h-[78vh]">
                    <img id="galleryModalImg" src="" alt="Foto Kegiatan Desa"
                        class="max-h-[72vh] w-auto object-contain mx-auto rounded-2xl shadow-2xl border border-slate-800">
                </div>

                {{-- Footer & Deskripsi --}}
                <div
                    class="bg-slate-50 p-6 sm:p-7 border-t border-slate-200/80 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex-1 space-y-1.5">
                        <p id="galleryModalDate" class="text-xs font-bold text-emerald-700 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span></span>
                        </p>
                        <p id="galleryModalDesc"
                            class="text-slate-700 text-sm leading-relaxed whitespace-pre-line font-medium"></p>
                    </div>
                    <button onclick="closeGalleryModal()"
                        class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-800 text-xs font-extrabold rounded-2xl transition-all cursor-pointer shrink-0">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // === Hero Carousel ===
            const heroCarousel = document.getElementById('hero-carousel');
            if (heroCarousel) {
                const slides = heroCarousel.querySelectorAll('.hero-slide');
                const dots = heroCarousel.querySelectorAll('.carousel-dot');
                const prevBtn = document.getElementById('carousel-prev-hero');
                const nextBtn = document.getElementById('carousel-next-hero');
                let currentSlide = 0;
                let autoPlayTimer;
                const totalSlides = slides.length;
                function goToSlide(index) {
                    if (index < 0) index = totalSlides - 1;
                    if (index >= totalSlides) index = 0;

                    slides.forEach((slide, i) => {
                        if (i === index) {
                            slide.classList.remove('opacity-0', 'z-0');
                            slide.classList.add('opacity-100', 'z-10');
                        } else {
                            slide.classList.remove('opacity-100', 'z-10');
                            slide.classList.add('opacity-0', 'z-0');
                        }
                    });

                    dots.forEach((dot, i) => {
                        if (i === index) {
                            dot.classList.remove('bg-white/40', 'hover:bg-white/60');
                            dot.classList.add('bg-white', 'w-8');
                        } else {
                            dot.classList.remove('bg-white', 'w-8');
                            dot.classList.add('bg-white/40', 'hover:bg-white/60');
                        }
                    });

                    currentSlide = index;
                }

                function startAutoPlay() {
                    autoPlayTimer = setInterval(() => goToSlide(currentSlide + 1), 5000);
                }

                function resetAutoPlay() {
                    clearInterval(autoPlayTimer);
                    startAutoPlay();
                }

                if (prevBtn) prevBtn.addEventListener('click', () => {
                    goToSlide(currentSlide - 1);
                    resetAutoPlay();
                });
                if (nextBtn) nextBtn.addEventListener('click', () => {
                    goToSlide(currentSlide + 1);
                    resetAutoPlay();
                });

                dots.forEach((dot, i) => {
                    dot.addEventListener('click', () => {
                        goToSlide(i);
                        resetAutoPlay();
                    });
                });

                // Touch Swipe functionality for Mobile
                let touchStartX = 0;
                let touchStartY = 0;
                let touchEndX = 0;
                let touchEndY = 0;

                heroCarousel.addEventListener('touchstart', (e) => {
                    if (e.touches.length > 0) {
                        touchStartX = e.touches[0].clientX;
                        touchStartY = e.touches[0].clientY;
                    }
                }, { passive: true });

                heroCarousel.addEventListener('touchend', (e) => {
                    if (e.changedTouches.length > 0) {
                        touchEndX = e.changedTouches[0].clientX;
                        touchEndY = e.changedTouches[0].clientY;
                        handleSwipe();
                    }
                }, { passive: true });

                function handleSwipe() {
                    const deltaX = touchEndX - touchStartX;
                    const deltaY = touchEndY - touchStartY;
                    const minSwipeDistance = 40;

                    if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > minSwipeDistance) {
                        if (deltaX < 0) {
                            goToSlide(currentSlide + 1);
                        } else {
                            goToSlide(currentSlide - 1);
                        }
                        resetAutoPlay();
                    }
                }

                if (totalSlides > 1) startAutoPlay();
            }

            // === Leadership Carousel (Seamless Smooth Infinite Marquee Loop) ===
            (function() {
                const track = document.getElementById('leader-carousel');
                const wrapper = document.getElementById('leader-carousel-wrapper');
                const prevBtn = document.getElementById('leader-carousel-prev');
                const nextBtn = document.getElementById('leader-carousel-next');
                if (!track || !wrapper) return;

                if (track.getAttribute('data-initialized') === 'true') return;
                track.setAttribute('data-initialized', 'true');

                const originalCards = Array.from(track.children);
                if (originalCards.length === 0) return;

                function getCols() {
                    if (window.innerWidth >= 1024) return 4;
                    if (window.innerWidth >= 640) return 2;
                    return 1;
                }

                function setCols() {
                    wrapper.style.setProperty('--leader-cols', getCols());
                }
                setCols();
                window.addEventListener('resize', setCols);

                // Duplicate cards twice for seamless loop
                for (let c = 0; c < 2; c++) {
                    originalCards.forEach(card => {
                        const clone = card.cloneNode(true);
                        clone.setAttribute('aria-hidden', 'true');
                        track.appendChild(clone);
                    });
                }

                let scrollPos = 0;
                let isPaused = false;
                let isTransitioning = false;
                const speed = 0.75; // Pixels per frame continuous smooth speed

                function getSetWidth() {
                    let width = 0;
                    for (let i = 0; i < originalCards.length; i++) {
                        width += originalCards[i].getBoundingClientRect().width;
                    }
                    return width;
                }

                function render() {
                    const setWidth = getSetWidth();
                    if (setWidth > 0) {
                        if (scrollPos >= setWidth) {
                            scrollPos %= setWidth;
                        } else if (scrollPos < 0) {
                            scrollPos = (scrollPos % setWidth) + setWidth;
                        }
                    }
                    track.style.transform = `translate3d(-${scrollPos}px, 0, 0)`;
                }

                function animate() {
                    if (!isPaused && !isTransitioning) {
                        scrollPos += speed;
                        render();
                    }
                    requestAnimationFrame(animate);
                }

                function slideBy(direction) {
                    const setWidth = getSetWidth();
                    if (setWidth <= 0) return;
                    const cardWidth = setWidth / originalCards.length;
                    const startPos = scrollPos;
                    const targetPos = scrollPos + (direction * cardWidth);
                    const startTime = performance.now();
                    const duration = 350;

                    isTransitioning = true;

                    function step(now) {
                        const elapsed = now - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        const ease = progress * (2 - progress);

                        scrollPos = startPos + (targetPos - startPos) * ease;
                        render();

                        if (progress < 1) {
                            requestAnimationFrame(step);
                        } else {
                            isTransitioning = false;
                        }
                    }
                    requestAnimationFrame(step);
                }

                if (prevBtn) {
                    prevBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        slideBy(-1);
                    });
                }

                if (nextBtn) {
                    nextBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        slideBy(1);
                    });
                }

                wrapper.addEventListener('mouseenter', () => {
                    isPaused = true;
                });
                wrapper.addEventListener('mouseleave', () => {
                    isPaused = false;
                });

                let touchStartX = 0;
                let touchStartPos = 0;
                wrapper.addEventListener('touchstart', (e) => {
                    if (e.touches.length > 0) {
                        isPaused = true;
                        touchStartX = e.touches[0].clientX;
                        touchStartPos = scrollPos;
                    }
                }, {
                    passive: true
                });

                wrapper.addEventListener('touchmove', (e) => {
                    if (e.touches.length > 0) {
                        const delta = touchStartX - e.touches[0].clientX;
                        scrollPos = touchStartPos + delta;
                        render();
                    }
                }, {
                    passive: true
                });

                wrapper.addEventListener('touchend', () => {
                    if (!wrapper.matches(':hover')) {
                        isPaused = false;
                    }
                }, {
                    passive: true
                });

                requestAnimationFrame(animate);
            })();
        });

        // === Gallery Modal Lightbox Functions ===
        window.openGalleryModal = function(element) {
            const modal = document.getElementById('galleryModal');
            const content = document.getElementById('galleryModalContent');
            const titleEl = document.getElementById('galleryModalTitle');
            const categoryEl = document.getElementById('galleryModalCategory');
            const imgEl = document.getElementById('galleryModalImg');
            const dateEl = document.getElementById('galleryModalDate');
            const descEl = document.getElementById('galleryModalDesc');

            if (!modal) return;

            const title = element.getAttribute('data-title') || '';
            const image = element.getAttribute('data-image') || '';
            const date = element.getAttribute('data-date') || '';
            const category = element.getAttribute('data-category') || '';
            const description = element.getAttribute('data-description') || '';

            titleEl.textContent = title;
            imgEl.src = image;
            imgEl.alt = title;

            if (category) {
                categoryEl.textContent = 'Kategori: ' + category;
                categoryEl.classList.remove('hidden');
            } else {
                categoryEl.classList.add('hidden');
            }

            if (date) {
                const dateSpan = dateEl.querySelector('span');
                if (dateSpan) dateSpan.textContent = 'Tanggal: ' + date;
                dateEl.classList.remove('hidden');
            } else {
                dateEl.classList.add('hidden');
            }

            if (description) {
                descEl.textContent = description;
                descEl.classList.remove('hidden');
            } else {
                descEl.classList.add('hidden');
            }

            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 20);
        };

        window.closeGalleryModal = function() {
            const modal = document.getElementById('galleryModal');
            const content = document.getElementById('galleryModalContent');
            if (!modal) return;

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }, 200);
        };

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeGalleryModal();
            }
        });
    </script>
@endpush
