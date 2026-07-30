@extends('layouts.app')

@section('title', 'Galeri & Dokumentasi Kegiatan')
@section('meta_description', 'Dokumentasi foto kegiatan, pembangunan, gotong royong, dan momen penting di Desa Bawangan, Kecamatan Ploso, Kabupaten Jombang.')

@section('content')
{{-- ═══ HERO BANNER ═══ --}}
<section class="relative bg-gradient-to-br from-slate-900 via-sky-950 to-slate-900 py-16 lg:py-20 text-white overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.03%22%3E%3Ccircle%20cx%3D%2230%22%20cy%3D%2230%22%20r%3D%221.5%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-300 mb-6">
            <a href="{{ route('home') }}" class="hover:text-sky-300 transition-colors">Beranda</a>
            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-emerald-400 font-semibold">Galeri Foto</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-400/20 text-emerald-300 text-xs font-semibold mb-4">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Dokumentasi Kegiatan Desa
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight">
                    Galeri & <span class="bg-gradient-to-r from-emerald-400 to-sky-400 bg-clip-text text-transparent">Dokumentasi</span>
                </h1>
                <p class="text-slate-300 text-sm sm:text-base mt-3 max-w-2xl leading-relaxed">
                    Kumpulan foto kegiatan, momen penting, pembangunan, dan acara kebersamaan warga Desa Bawangan.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ═══ GALLERY LIST SECTION ═══ --}}
<section class="py-12 bg-slate-50 min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Category Filter Pills --}}
        @if($categories->isNotEmpty())
        <div class="flex flex-wrap items-center gap-2 mb-10 pb-2 overflow-x-auto">
            <a href="{{ route('galeri') }}"
               class="px-4 py-2 rounded-2xl text-xs font-bold transition-all cursor-pointer border {{ !request('kategori') ? 'bg-emerald-600 text-white border-emerald-600 shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-100' }}">
               Semua Foto
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('galeri', ['kategori' => $cat]) }}"
               class="px-4 py-2 rounded-2xl text-xs font-bold transition-all cursor-pointer border {{ request('kategori') === $cat ? 'bg-emerald-600 text-white border-emerald-600 shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-100' }}">
               {{ $cat }}
            </a>
            @endforeach
        </div>
        @endif

        @if($galleries->isNotEmpty())
        {{-- Photo Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-12">
            @foreach ($galleries as $item)
                <div onclick="openGalleryModal(this)"
                     data-title="{{ $item->title }}"
                     data-image="{{ asset('storage/' . $item->image) }}"
                     data-date="{{ $item->date ? $item->date->translatedFormat('d F Y') : '' }}"
                     data-category="{{ $item->category ?? '' }}"
                     data-description="{{ $item->description ?? '' }}"
                     class="group relative rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 aspect-[4/3] cursor-pointer border border-slate-200/80 bg-slate-900">

                    {{-- Foto Utama --}}
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                    {{-- Top-Right Badge --}}
                    <div class="absolute top-4 right-4 z-10">
                        @if ($item->category)
                            <span class="px-3 py-1.5 rounded-full bg-black/50 backdrop-blur-md text-emerald-300 text-xs font-extrabold tracking-wider uppercase border border-emerald-400/30 flex items-center gap-1.5 shadow-md">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ $item->category }}
                            </span>
                        @else
                            <span class="p-2 rounded-full bg-black/50 backdrop-blur-md text-white/90 border border-white/20 flex items-center justify-center shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                                </svg>
                            </span>
                        @endif
                    </div>

                    {{-- Overlay Caption on Hover --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5 sm:p-6 z-10">
                        @if ($item->date)
                            <p class="text-xs font-semibold text-emerald-300 mb-1 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $item->date->translatedFormat('d F Y') }}</span>
                            </p>
                        @endif
                        <p class="text-white font-extrabold text-base sm:text-lg leading-snug translate-y-3 group-hover:translate-y-0 transition-transform duration-300 line-clamp-2">
                            {{ $item->title }}
                        </p>
                        <span class="inline-flex items-center gap-1.5 text-xs text-sky-300 font-bold mt-2.5 translate-y-3 group-hover:translate-y-0 transition-transform duration-300">
                            <span>Perbesar Foto</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $galleries->links() }}
        </div>
        @else
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/80 shadow-xs max-w-xl mx-auto my-12">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Foto Galeri</h3>
            <p class="text-xs text-slate-500">Dokumentasi foto kegiatan desa belum diunggah atau belum tersedia untuk kategori ini.</p>
        </div>
        @endif

    </div>
</section>

{{-- ═══ MODAL POP-UP GALERI (LIGHTBOX) ═══ --}}
<div id="galleryModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
    <div class="fixed inset-0 bg-slate-950/85 backdrop-blur-md transition-opacity" onclick="closeGalleryModal()"></div>

    <div id="galleryModalContent" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-5xl mx-auto overflow-hidden transform scale-95 opacity-0 transition-all duration-300 flex flex-col z-10 my-auto">
        <div class="bg-gradient-to-r from-sky-700 via-sky-800 to-emerald-700 px-6 py-4.5 flex justify-between items-center z-10 border-b border-white/10">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center shrink-0 border border-white/20">
                    <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 id="galleryModalTitle" class="text-white font-extrabold text-base sm:text-lg leading-tight line-clamp-1">Detail Foto</h3>
                    <span id="galleryModalCategory" class="text-xs text-emerald-300 font-semibold block"></span>
                </div>
            </div>
            <button onclick="closeGalleryModal()" class="text-white/80 hover:text-white transition-colors p-2 rounded-xl hover:bg-white/10 shrink-0 cursor-pointer" title="Tutup Modal">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="bg-slate-950 flex items-center justify-center max-h-[70vh] overflow-hidden relative">
            <img id="galleryModalImage" src="" alt="Foto Galeri" class="max-h-[70vh] w-auto max-w-full object-contain">
        </div>

        <div class="p-6 bg-white border-t border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <p id="galleryModalDate" class="text-xs font-bold text-emerald-600 mb-1 flex items-center gap-1.5"></p>
                <p id="galleryModalDescription" class="text-slate-600 text-sm leading-relaxed"></p>
            </div>
            <button onclick="closeGalleryModal()" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-extrabold transition-colors cursor-pointer shrink-0">
                Tutup
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openGalleryModal(element) {
        const modal = document.getElementById('galleryModal');
        const content = document.getElementById('galleryModalContent');
        const title = element.getAttribute('data-title');
        const image = element.getAttribute('data-image');
        const date = element.getAttribute('data-date');
        const category = element.getAttribute('data-category');
        const description = element.getAttribute('data-description');

        document.getElementById('galleryModalTitle').innerText = title || 'Dokumentasi Kegiatan';
        document.getElementById('galleryModalImage').src = image;
        document.getElementById('galleryModalCategory').innerText = category ? `Kategori: ${category}` : 'Dokumentasi Desa';
        document.getElementById('galleryModalDate').innerHTML = date ? `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> ${date}` : '';
        document.getElementById('galleryModalDescription').innerText = description || 'Foto dokumentasi resmi kegiatan Desa Bawangan.';

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeGalleryModal() {
        const modal = document.getElementById('galleryModal');
        const content = document.getElementById('galleryModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeGalleryModal();
        }
    });
</script>
@endpush
@endsection
