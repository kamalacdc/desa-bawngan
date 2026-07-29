@extends('layouts.admin')

@section('title', 'Kelola Slide Banner Hero')

@section('content')

<div class="max-w-5xl">
    <div class="mb-8">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-50 text-sky-800 text-xs font-extrabold tracking-wider uppercase border border-sky-200/70 mb-2">
            <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span>Pengaturan Hero Banner</span>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Slide Hero Carousel</h2>
        <p class="text-xs text-slate-600 font-medium mt-1">Kelola 3 slide utama yang tampil pada banner paling atas di halaman utama portal desa.</p>
    </div>

    <form action="{{ route('admin.content.slides.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            @foreach($slides as $index => $slide)
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                {{-- Slide Header --}}
                <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-200/80 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-sky-100 text-sky-800 flex items-center justify-center text-xs font-extrabold border border-sky-200/60">{{ $index + 1 }}</span>
                        <h3 class="font-extrabold text-slate-900 text-sm">Slide Hero Banner #{{ $index + 1 }}</h3>
                    </div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="slides[{{ $index }}][is_active]" value="1" {{ $slide->is_active ? 'checked' : '' }} class="w-4 h-4 rounded-lg border-slate-300 text-sky-600 focus:ring-sky-500 cursor-pointer">
                        <span class="text-xs font-extrabold text-slate-700 uppercase tracking-wider">Aktif</span>
                    </label>
                </div>

                <div class="p-6">
                    @if($slide->id)
                        <input type="hidden" name="slides[{{ $index }}][id]" value="{{ $slide->id }}">
                    @endif

                    <div class="grid md:grid-cols-3 gap-6">
                        {{-- Image Upload --}}
                        <div class="md:col-span-1">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Gambar Background Slide</label>
                            <div class="relative aspect-video bg-slate-100 rounded-2xl overflow-hidden border-2 border-dashed border-slate-300 flex items-center justify-center group">
                                @if($slide->image)
                                    <img src="{{ asset('storage/' . $slide->image) }}" alt="Slide {{ $index + 1 }}" class="w-full h-full object-cover" id="preview-{{ $index }}">
                                @else
                                    <div class="text-center p-4" id="placeholder-{{ $index }}">
                                        <svg class="w-8 h-8 mx-auto text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span class="text-xs font-bold text-slate-500">Pilih berkas foto...</span>
                                    </div>
                                @endif
                            </div>
                            <input type="file" name="slides[{{ $index }}][image]" accept="image/*" class="mt-3 w-full text-xs text-slate-500 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer" onchange="previewImage(this, {{ $index }})">
                            @if($slide->image)
                                <label class="flex items-center gap-2 mt-2.5 cursor-pointer">
                                    <input type="checkbox" name="slides[{{ $index }}][remove_image]" value="1" class="w-3.5 h-3.5 rounded border-slate-300 text-rose-600 focus:ring-rose-500 cursor-pointer">
                                    <span class="text-xs text-rose-600 font-bold">Hapus gambar ini</span>
                                </label>
                            @endif
                            @error("slides.{$index}.image")
                                <p class="text-xs text-rose-600 mt-1 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Text Fields --}}
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Utama <span class="text-rose-500">*</span></label>
                                <input type="text" name="slides[{{ $index }}][title]" value="{{ old("slides.{$index}.title", $slide->title) }}" required class="w-full px-4 py-2.5 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-xs font-semibold text-slate-900 outline-none transition-colors shadow-xs" placeholder="Judul slide utama...">
                                @error("slides.{$index}.title")
                                    <p class="text-xs text-rose-600 mt-1 font-bold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Subtitle Badge</label>
                                <input type="text" name="slides[{{ $index }}][subtitle]" value="{{ old("slides.{$index}.subtitle", $slide->subtitle) }}" class="w-full px-4 py-2.5 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-xs font-semibold text-slate-900 outline-none transition-colors shadow-xs" placeholder="Subtitle badge (opsional)...">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                                <textarea name="slides[{{ $index }}][description]" rows="2" class="w-full px-4 py-2.5 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-xs font-semibold text-slate-900 outline-none transition-colors resize-none shadow-xs" placeholder="Penjelasan singkat mengenai slide (opsional)...">{{ old("slides.{$index}.description", $slide->description) }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Teks Tombol Aksi</label>
                                    <input type="text" name="slides[{{ $index }}][button_text]" value="{{ old("slides.{$index}.button_text", $slide->button_text) }}" class="w-full px-4 py-2.5 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-xs font-semibold text-slate-900 outline-none transition-colors shadow-xs" placeholder="Lihat Selengkapnya">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Link URL Tombol</label>
                                    <input type="text" name="slides[{{ $index }}][button_url]" value="{{ old("slides.{$index}.button_url", $slide->button_url) }}" class="w-full px-4 py-2.5 rounded-2xl border border-slate-300/80 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 text-xs font-semibold text-slate-900 outline-none transition-colors shadow-xs" placeholder="/berita atau https://...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8 flex items-center gap-4">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl font-extrabold text-xs bg-gradient-to-r from-sky-700 to-emerald-600 hover:from-sky-800 hover:to-emerald-700 text-white shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                <span>Simpan Perubahan Slide</span>
            </button>
            <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl text-xs font-bold text-slate-700 bg-white border border-slate-200/80 hover:bg-slate-50 transition-colors shadow-xs cursor-pointer">
                <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Pratinjau Portal Utama</span>
            </a>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
function previewImage(input, index) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = input.closest('.md\\:col-span-1').querySelector('.aspect-video');
            let img = container.querySelector('img');
            const placeholder = container.querySelector('[id^="placeholder-"]');
            if (placeholder) placeholder.style.display = 'none';
            if (!img) {
                img = document.createElement('img');
                img.className = 'w-full h-full object-cover';
                container.appendChild(img);
            }
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

