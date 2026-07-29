@extends('layouts.admin')

@section('title', 'Detail Pratinjau Berita')

@section('content')

{{-- Top Toolbar --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div class="flex items-center gap-3">
        <a href="{{ url()->previous() != request()->url() ? url()->previous() : route('admin.news.index') }}" class="w-10 h-10 rounded-2xl bg-white border border-slate-200/80 flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors shadow-xs cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <div>
            <div class="flex items-center gap-2 mb-1 flex-wrap">
                <span class="px-3 py-0.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider bg-slate-200 text-slate-700 border border-slate-300/80">{{ $news->category->name }}</span>
                <span class="px-3 py-0.5 rounded-lg text-[10px] font-extrabold uppercase tracking-wider bg-{{ $news->statusBadgeColor() }}-50 text-{{ $news->statusBadgeColor() }}-700 border border-{{ $news->statusBadgeColor() }}-200/80">
                    {{ $news->statusLabel() }}
                </span>
            </div>
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Detail Pratinjau Berita</h2>
        </div>
    </div>

    <div class="flex items-center gap-3 flex-wrap">
        {{-- If user can edit --}}
        @if(Auth::user()->isSuperAdmin() || $news->author_id === Auth::id())
        <a href="{{ route('admin.news.edit', $news) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white hover:bg-slate-50 text-slate-700 font-extrabold text-xs border border-slate-200/80 shadow-xs transition-colors cursor-pointer">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            <span>Edit Artikel</span>
        </a>
        @endif

        {{-- If published, view public page --}}
        @if($news->isPublished())
        <a href="{{ route('berita.detail', $news->slug) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-sky-50 hover:bg-sky-100 text-sky-800 font-extrabold text-xs border border-sky-200/80 shadow-xs transition-colors cursor-pointer">
            <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span>Buka di Web Publik</span>
        </a>
        @endif
    </div>
</div>

{{-- Approval Action Box (For Super Admin if submitted) --}}
@if(Auth::user()->isSuperAdmin() && $news->isSubmitted())
<div class="bg-amber-500/10 border-2 border-amber-500/30 rounded-3xl p-6 mb-8 backdrop-blur-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-2xl bg-amber-500 text-slate-950 flex items-center justify-center font-extrabold shrink-0 shadow-md">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div>
            <h3 class="font-extrabold text-slate-900 text-sm">Menunggu Persetujuan Publikasi</h3>
            <p class="text-xs text-slate-600">Artikel ini diajukan oleh {{ $news->author->name }} dan memerlukan persetujuan Anda untuk terbit.</p>
        </div>
    </div>

    <div class="flex items-center gap-3 shrink-0">
        <form method="POST" action="{{ route('admin.approvals.approve', $news) }}" onsubmit="return confirm('Setujui dan publikasikan berita ini?');">
            @csrf
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-md transition-all cursor-pointer">
                ✓ Setujui & Terbitkan
            </button>
        </form>

        <button type="button" onclick="openRejectModal({{ $news->id }}, '{{ addslashes($news->title) }}')" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs shadow-md transition-all cursor-pointer">
            ✕ Tolak
        </button>
    </div>
</div>
@endif

{{-- Rejection Note Alert if rejected --}}
@if($news->isRejected() && $news->rejection_note)
<div class="bg-rose-50 border border-rose-200/90 rounded-3xl p-6 mb-8 text-rose-950 flex items-start gap-4">
    <div class="w-10 h-10 rounded-2xl bg-rose-500 text-white flex items-center justify-center font-bold shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    </div>
    <div>
        <h4 class="font-extrabold text-sm text-rose-900 mb-1">Catatan Penolakan Pengajuan:</h4>
        <p class="text-xs font-semibold leading-relaxed text-rose-800">{{ $news->rejection_note }}</p>
    </div>
</div>
@endif

{{-- Main Article Preview Card --}}
<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 md:p-10 max-w-4xl mx-auto space-y-6">
    
    {{-- Featured Image --}}
    @if($news->featured_image)
    <div class="w-full h-72 md:h-96 rounded-2xl overflow-hidden border border-slate-200/80 bg-slate-100 shadow-inner">
        <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
    </div>
    @endif

    {{-- Metadata Row --}}
    <div class="flex items-center gap-4 text-xs font-semibold text-slate-500 pb-4 border-b border-slate-100 flex-wrap">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-slate-900 text-white font-extrabold text-xs flex items-center justify-center">
                {{ strtoupper(substr($news->author->name, 0, 1)) }}
            </div>
            <div>
                <span class="font-extrabold text-slate-900 block">{{ $news->author->name }}</span>
                <span class="text-[10px] text-slate-400 font-medium">{{ $news->author->roleLabel() }}</span>
            </div>
        </div>

        <span class="text-slate-300">•</span>

        <span class="flex items-center gap-1.5">
            <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Dibuat: {{ $news->created_at->translatedFormat('d F Y, H:i') }} WIB
        </span>

        @if($news->published_at)
        <span class="text-slate-300">•</span>
        <span class="flex items-center gap-1.5 text-emerald-600 font-bold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Terbit: {{ $news->published_at->translatedFormat('d F Y') }}
        </span>
        @endif

        <span class="text-slate-300">•</span>
        <span class="flex items-center gap-1.5 text-slate-700 bg-slate-100 px-3 py-1 rounded-full border border-slate-200/80 font-extrabold text-xs">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            <span>{{ number_format($news->views_count) }}x Dilihat Pembaca</span>
        </span>
    </div>

    {{-- Title & Excerpt --}}
    <div class="space-y-3">
        <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight leading-snug">{{ $news->title }}</h1>
        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/70 italic text-slate-600 text-sm leading-relaxed font-medium">
            "{{ $news->excerpt }}"
        </div>
    </div>

    {{-- Body Content --}}
    <div class="pt-4 text-slate-800 text-sm md:text-base leading-relaxed space-y-4 font-normal">
        {!! nl2br(e($news->body)) !!}
    </div>
</div>

{{-- Reject Modal --}}
@if(Auth::user()->isSuperAdmin() && $news->isSubmitted())
<div id="rejectModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200/80">
                <form id="rejectForm" method="POST" action="{{ route('admin.approvals.reject', $news) }}">
                    @csrf
                    <div class="bg-white px-6 pb-4 pt-6 sm:p-7">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-rose-50 border border-rose-100 sm:mx-0 sm:h-11 sm:w-11">
                                <svg class="h-6 w-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg font-extrabold leading-6 text-slate-900" id="modal-title">Tolak Pengajuan Berita</h3>
                                <div class="mt-2">
                                    <p class="text-xs text-slate-500 mb-3">Anda akan menolak pengajuan berita: <strong id="modal-news-title" class="text-slate-900 block mt-1 font-bold">{{ $news->title }}</strong></p>
                                    <label for="rejection_note" class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wider">Catatan Alasan Penolakan <span class="text-rose-500">*</span></label>
                                    <textarea id="rejection_note" name="rejection_note" rows="3" required class="w-full px-4 py-3 rounded-2xl border border-slate-300/80 focus:border-rose-500 focus:ring-2 focus:ring-rose-200 transition-colors text-xs font-medium text-slate-900 shadow-xs outline-none" placeholder="Tuliskan catatan perbaikan untuk penulis berita..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50/80 px-6 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                        <button type="submit" class="inline-flex w-full justify-center rounded-2xl bg-rose-600 px-5 py-2.5 text-xs font-extrabold text-white shadow-md hover:bg-rose-700 sm:ml-3 sm:w-auto transition-all cursor-pointer">Tolak Berita</button>
                        <button type="button" onclick="closeRejectModal()" class="mt-3 inline-flex w-full justify-center rounded-2xl bg-white px-5 py-2.5 text-xs font-bold text-slate-700 shadow-xs border border-slate-200 hover:bg-slate-100 sm:mt-0 sm:w-auto transition-all cursor-pointer">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
    function openRejectModal(newsId, newsTitle) {
        const modal = document.getElementById('rejectModal');
        if (modal) modal.classList.remove('hidden');
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        if (modal) modal.classList.add('hidden');
    }
</script>
@endpush
