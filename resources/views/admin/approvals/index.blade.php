@extends('layouts.admin')

@section('title', 'Persetujuan Berita & Konten')

@section('content')

<div class="mb-6 max-w-3xl">
    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-50 text-amber-800 text-xs font-extrabold tracking-wider uppercase border border-amber-200/70 mb-3">
        <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>Verifikasi Konten</span>
    </div>
    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight mb-2">Antrean Persetujuan Publikasi</h2>
    <p class="text-xs text-slate-600 font-medium leading-relaxed">Daftar berita yang diajukan oleh Admin Staff. Tinjau dan berikan persetujuan sebelum dipublikasikan ke portal publik Desa Bawangan.</p>
</div>

<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs whitespace-nowrap">
            <thead class="bg-slate-50/80 text-slate-700 font-extrabold border-b border-slate-200/80 uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="px-6 py-4">Judul Berita</th>
                    <th class="px-6 py-4">Penulis</th>
                    <th class="px-6 py-4">Tanggal Pengajuan</th>
                    <th class="px-6 py-4 text-center">Tindakan (Approve / Reject)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pendingNews as $item)
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
                                <p class="font-extrabold text-slate-900 text-sm truncate mb-1">
                                    <a href="{{ route('admin.news.edit', $item) }}" target="_blank" class="hover:text-sky-700 transition-colors inline-flex items-center gap-1.5 cursor-pointer" title="Pratinjau detail berita">
                                        <span>{{ $item->title }}</span>
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </p>
                                <span class="text-[10px] font-bold text-slate-700 bg-slate-100 px-2.5 py-0.5 rounded-lg border border-slate-200/60">{{ $item->category->name }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-700 font-semibold">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] font-extrabold overflow-hidden border border-slate-300">
                                @if($item->author->avatar)
                                    <img src="{{ asset('storage/' . $item->author->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($item->author->name, 0, 1) }}
                                @endif
                            </div>
                            <span>{{ $item->author->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-500 text-xs">
                        <span class="font-bold text-slate-700">{{ $item->updated_at->format('d M Y, H:i') }}</span>
                        <span class="block mt-0.5 text-[10px] font-bold text-amber-700">{{ $item->updated_at->diffForHumans() }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2.5">
                            {{-- Approve Action --}}
                            <form action="{{ route('admin.approvals.approve', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI dan MEMPUBLIKASIKAN berita ini?');">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-50 text-emerald-800 hover:bg-emerald-600 hover:text-white rounded-xl text-xs font-extrabold transition-all border border-emerald-200/80 shadow-2xs hover:shadow-md cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span>Setujui</span>
                                </button>
                            </form>

                            {{-- Reject Action (Triggers Modal) --}}
                            <button type="button" onclick="openRejectModal({{ $item->id }}, '{{ addslashes($item->title) }}')" class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-50 text-rose-800 hover:bg-rose-600 hover:text-white rounded-xl text-xs font-extrabold transition-all border border-rose-200/80 shadow-2xs hover:shadow-md cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                <span>Tolak</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-14 text-center text-slate-500">
                        <div class="w-14 h-14 mx-auto bg-emerald-50 border border-emerald-100 rounded-3xl flex items-center justify-center text-emerald-600 mb-3">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="font-extrabold text-base text-slate-900">Tidak ada antrean persetujuan</p>
                        <p class="text-xs text-slate-500 mt-1">Semua pengajuan berita sudah diperiksa dan disetujui.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pendingNews->hasPages())
        <div class="p-4 border-t border-slate-200/80 bg-slate-50/50">
            {{ $pendingNews->links() }}
        </div>
    @endif
</div>

{{-- Reject Modal --}}
<div id="rejectModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200/80">
                <form id="rejectForm" method="POST" action="">
                    @csrf
                    <div class="bg-white px-6 pb-4 pt-6 sm:p-7">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-rose-50 border border-rose-100 sm:mx-0 sm:h-11 sm:w-11">
                                <svg class="h-6 w-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg font-extrabold leading-6 text-slate-900" id="modal-title">Tolak Pengajuan Berita</h3>
                                <div class="mt-2">
                                    <p class="text-xs text-slate-500 mb-3">Anda akan menolak pengajuan berita: <strong id="modal-news-title" class="text-slate-900 block mt-1 font-bold"></strong></p>
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

@endsection

@push('scripts')
<script>
    function openRejectModal(newsId, newsTitle) {
        document.getElementById('rejectForm').action = '/admin/approvals/' + newsId + '/reject';
        document.getElementById('modal-news-title').innerText = newsTitle;
        document.getElementById('rejection_note').value = '';
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>
@endpush

