@extends('layouts.app')

@section('title', $news->title)
@section('meta_description', $news->excerpt)

@section('content')
<section class="pt-10 pb-24 bg-slate-50/80 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb --}}
        <nav class="flex text-xs text-slate-500 font-semibold mb-8 animate-fade-in-up" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1.5 md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-sky-700 transition-colors cursor-pointer">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3.5 h-3.5 text-slate-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        <a href="{{ route('berita') }}" class="hover:text-sky-700 transition-colors cursor-pointer">Berita</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3.5 h-3.5 text-slate-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        <a href="{{ route('berita', ['kategori' => $news->category->slug]) }}" class="hover:text-sky-700 transition-colors cursor-pointer text-slate-700 font-bold">{{ $news->category->name }}</a>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Article Header --}}
        <header class="mb-10 animate-fade-in-up animation-delay-100">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 mb-4 rounded-xl bg-sky-100 text-sky-800 text-xs font-bold tracking-wide uppercase border border-sky-200/60">{{ $news->category->name }}</span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 leading-tight tracking-tight mb-6">
                {{ $news->title }}
            </h1>
            <div class="flex flex-wrap items-center gap-4 text-xs sm:text-sm text-slate-600 border-y border-slate-200/80 py-4 bg-white/60 backdrop-blur-sm rounded-2xl px-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-600 to-emerald-600 flex items-center justify-center text-white font-bold overflow-hidden shadow-xs shrink-0">
                        @if($news->author->avatar)
                            <img src="{{ asset('storage/' . $news->author->avatar) }}" alt="{{ $news->author->name }}" class="w-full h-full object-cover">
                        @else
                            {{ substr($news->author->name, 0, 1) }}
                        @endif
                    </div>
                    <div>
                        <p class="font-bold text-slate-900">{{ $news->author->name }}</p>
                        <p class="text-xs text-slate-500 font-medium">{{ $news->author->jabatan ?? 'Pemerintah Desa Bawangan' }}</p>
                    </div>
                </div>
                <div class="hidden sm:block w-px h-8 bg-slate-200"></div>
                <div class="flex items-center gap-4 text-xs font-semibold text-slate-600 ml-auto sm:ml-0 flex-wrap">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Dipublikasikan: <strong class="text-slate-900">{{ $news->published_at->translatedFormat('d F Y, H:i') }} WIB</strong></span>
                    </span>
                    <span class="flex items-center gap-1.5 text-slate-700 bg-slate-100/90 px-3 py-1 rounded-full border border-slate-200/80 font-extrabold text-xs">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>{{ number_format($news->views_count) }}x Dilihat</span>
                    </span>
                </div>
            </div>
        </header>

        {{-- Featured Image --}}
        @if($news->featured_image)
        <figure class="mb-12 rounded-3xl overflow-hidden shadow-2xl border border-slate-200/80 animate-fade-in-up animation-delay-200">
            <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}" class="w-full max-h-[520px] object-cover">
        </figure>
        @endif

        {{-- Article Body --}}
        <article class="prose prose-slate lg:prose-lg max-w-none bg-white p-8 sm:p-12 rounded-3xl shadow-sm border border-slate-200/80 animate-fade-in-up animation-delay-300 leading-relaxed">
            {!! nl2br(e($news->body)) !!}
        </article>

        {{-- Share Buttons --}}
        <div class="mt-10 py-6 flex items-center justify-center gap-3 sm:gap-4 flex-wrap border-t border-slate-200/80 animate-fade-in-up">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Bagikan Berita:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" title="Bagikan ke Facebook" class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-[#1877F2] flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-all shadow-xs hover:shadow-md cursor-pointer">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($news->title) }}" target="_blank" title="Bagikan ke X / Twitter" class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-[#1DA1F2] flex items-center justify-center hover:bg-[#1DA1F2] hover:text-white transition-all shadow-xs hover:shadow-md cursor-pointer">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
            </a>
            <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' - ' . request()->url()) }}" target="_blank" title="Bagikan ke WhatsApp" class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-[#25D366] flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-all shadow-xs hover:shadow-md cursor-pointer">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M18.403 5.633A8.919 8.919 0 0 0 12.053 3c-4.948 0-8.976 4.027-8.978 8.977 0 1.582.413 3.126 1.198 4.488L3 21.116l4.759-1.249a8.981 8.981 0 0 0 4.29 1.093h.004c4.947 0 8.975-4.027 8.977-8.977a8.926 8.926 0 0 0-2.627-6.35m-6.35 13.812h-.003a7.446 7.446 0 0 1-3.798-1.041l-.272-.162-2.824.741.753-2.753-.177-.282a7.448 7.448 0 0 1-1.141-3.971c.002-4.114 3.349-7.464 7.465-7.464 1.993.001 3.869.778 5.277 2.188 1.41 1.411 2.187 3.286 2.188 5.279-.002 4.114-3.349 7.464-7.465 7.464m4.097-5.589c-.225-.113-1.327-.655-1.533-.73-.205-.075-.354-.112-.504.112-.15.225-.58.729-.711.879-.131.15-.262.168-.486.056-.225-.113-.948-.35-1.804-1.113-.667-.595-1.117-1.329-1.248-1.554-.131-.225-.014-.347.099-.459.101-.101.224-.262.337-.393.112-.131.149-.224.224-.374.075-.15.038-.281-.019-.393-.056-.113-.504-1.214-.689-1.664-.181-.439-.365-.379-.504-.386-.131-.007-.281-.007-.43-.007a.825.825 0 0 0-.599.281c-.205.225-.786.768-.786 1.873s.804 2.171.916 2.321c.112.15 1.582 2.415 3.832 3.387.536.231.954.369 1.279.473.537.171 1.026.146 1.413.089.431-.064 1.327-.542 1.514-1.066.187-.524.187-.973.131-1.067-.056-.094-.207-.151-.43-.263"/></svg>
            </a>
            <button onclick="copyArticleLink(this)" type="button" title="Salin Link Berita" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white border border-slate-200 text-slate-700 text-xs font-extrabold hover:bg-sky-50 hover:text-sky-700 hover:border-sky-200 transition-all shadow-xs hover:shadow-md cursor-pointer">
                <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                <span class="btn-copy-text">Salin Link</span>
            </button>
        </div>

        {{-- Related News --}}
        @if($related->isNotEmpty())
        <div class="mt-16 pt-10 border-t border-slate-200/80">
            <h3 class="text-2xl font-extrabold text-slate-900 mb-8">Berita Terkait Lainnya</h3>
            <div class="grid sm:grid-cols-3 gap-6">
                @foreach($related as $item)
                <a href="{{ route('berita.detail', $item->slug) }}" class="group block bg-white rounded-3xl overflow-hidden shadow-xs hover:shadow-xl border border-slate-200/80 transition-all duration-300 hover:-translate-y-1 cursor-pointer">
                    <div class="h-36 bg-slate-100 overflow-hidden">
                        @if($item->featured_image)
                            <img src="{{ asset('storage/' . $item->featured_image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <span class="text-xs font-bold text-sky-700 block mb-2">{{ $item->published_at->translatedFormat('d M Y') }}</span>
                        <h4 class="font-extrabold text-slate-900 text-sm leading-snug group-hover:text-sky-700 transition-colors line-clamp-2">{{ $item->title }}</h4>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

@push('scripts')
<script>
    function copyArticleLink(btn) {
        const url = window.location.href;
        const textSpan = btn.querySelector('.btn-copy-text');
        
        navigator.clipboard.writeText(url).then(() => {
            const originalText = textSpan.textContent;
            textSpan.textContent = 'Link Tersalin!';
            btn.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
            
            setTimeout(() => {
                textSpan.textContent = originalText;
                btn.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
            }, 2000);
        }).catch(() => {
            // Fallback for older browsers
            const input = document.createElement('input');
            input.value = url;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            
            textSpan.textContent = 'Link Tersalin!';
            btn.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
            setTimeout(() => {
                textSpan.textContent = 'Salin Link';
                btn.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
            }, 2000);
        });
    }
</script>
@endpush
@endsection

