@extends('layouts.admin')

@section('title', 'Manajemen Perangkat Desa')

@section('content')

<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-50 text-sky-800 text-xs font-extrabold tracking-wider uppercase border border-sky-200/70 mb-2">
            <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <span>Struktur Pemerintahan</span>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Perangkat Desa Bawangan</h2>
        <p class="text-xs text-slate-600 font-medium mt-1">Kelola profil Kepala Desa, Sekretaris, dan aparat desa lainnya yang tampil di portal publik.</p>
    </div>
    
    <a href="{{ route('admin.leaders.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-sky-700 to-emerald-600 hover:from-sky-800 hover:to-emerald-700 text-white text-xs font-extrabold rounded-2xl flex items-center gap-2 shrink-0 shadow-md hover:shadow-lg transition-all cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        <span>Tambah Perangkat Baru</span>
    </a>
</div>

<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden max-w-5xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs whitespace-nowrap">
            <thead class="bg-slate-50/80 text-slate-700 font-extrabold border-b border-slate-200/80 uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="px-6 py-4 w-20 text-center">Urutan</th>
                    <th class="px-6 py-4">Profil Perangkat</th>
                    <th class="px-6 py-4">Jabatan</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($leaders as $leader)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-6 py-4 text-center font-mono font-bold text-slate-500">
                        #{{ $leader->sort_order }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-100 to-emerald-100 shrink-0 overflow-hidden border border-slate-200/60 flex items-center justify-center text-slate-600 font-extrabold">
                                @if($leader->photo)
                                    <img src="{{ asset('storage/' . $leader->photo) }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($leader->name, 0, 1)) }}
                                @endif
                            </div>
                            <p class="font-extrabold text-slate-900 text-sm">{{ $leader->name }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sky-800 bg-sky-50 px-3 py-1 rounded-xl text-xs font-bold border border-sky-200/60">{{ $leader->position }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($leader->is_active)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-[10px] font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-[10px] font-extrabold uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.leaders.edit', $leader) }}" class="p-2 rounded-xl text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-colors cursor-pointer" title="Edit Perangkat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.leaders.destroy', $leader) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perangkat ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer" title="Hapus Perangkat">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-14 text-center text-slate-500">
                        <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center mx-auto mb-3 border border-sky-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <p class="font-extrabold text-slate-900 text-sm">Belum ada data perangkat desa.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($leaders->hasPages())
        <div class="p-4 border-t border-slate-200/80 bg-slate-50/50">
            {{ $leaders->links() }}
        </div>
    @endif
</div>

@endsection

