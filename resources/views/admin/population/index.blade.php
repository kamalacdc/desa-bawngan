@extends('layouts.admin')

@section('title', 'Data Kependudukan & Demografi')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 text-xs font-extrabold tracking-wider uppercase border border-emerald-200/70 mb-2">
            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <span>Statistik Desa</span>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Demografi Penduduk</h2>
        <p class="text-xs text-slate-600 font-medium mt-1">Kelola catatan statistik jumlah penduduk dan kelompok umur Desa Bawangan per tahun.</p>
    </div>
    
    <div class="flex gap-3">
        <form action="{{ route('admin.population.sync') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold rounded-2xl flex items-center gap-2 shrink-0 shadow-md hover:shadow-lg transition-all cursor-pointer" onclick="return confirm('Tarik data terbaru dari Google Sheets API? Data tahun ini akan diperbarui.');">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span>Sinkronkan Sheets</span>
            </button>
        </form>
        <a href="{{ route('admin.population.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-sky-700 to-emerald-600 hover:from-sky-800 hover:to-emerald-700 text-white text-xs font-extrabold rounded-2xl flex items-center gap-2 shrink-0 shadow-md hover:shadow-lg transition-all cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Data Baru</span>
        </a>
    </div>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-3 shadow-xs">
    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold flex items-center gap-3 shadow-xs">
    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <span>{{ session('error') }}</span>
</div>
@endif

@php
    $latestPop = $populationData->first();
@endphp

@if($latestPop)
<div class="mb-8 bg-white rounded-3xl border border-slate-200/80 shadow-xs p-7 flex flex-col md:flex-row items-center gap-8 max-w-5xl">
    <div class="flex-1 w-full grid grid-cols-2 gap-4">
        <div class="col-span-2 bg-slate-50/80 border border-slate-200/70 rounded-2xl p-5 text-center">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Penduduk (Tahun {{ $latestPop->year }})</p>
            <p class="text-3xl font-extrabold text-slate-900">{{ number_format($latestPop->totalPopulation(), 0, ',', '.') }} <span class="text-sm font-bold text-slate-500">Jiwa</span></p>
        </div>
        <div class="bg-sky-50/80 rounded-2xl p-4 text-center border border-sky-100">
            <p class="text-xs font-bold text-sky-700 uppercase tracking-wider mb-1">Laki-laki</p>
            <p class="text-2xl font-extrabold text-slate-900">{{ number_format($latestPop->male_count, 0, ',', '.') }}</p>
        </div>
        <div class="bg-rose-50/80 rounded-2xl p-4 text-center border border-rose-100">
            <p class="text-xs font-bold text-rose-700 uppercase tracking-wider mb-1">Perempuan</p>
            <p class="text-2xl font-extrabold text-slate-900">{{ number_format($latestPop->female_count, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <div class="flex-1 w-full h-[250px] relative">
        <canvas id="populationChart"></canvas>
    </div>
    <script>
        window.villagePopulationData = {
            total: {{ $latestPop->totalPopulation() }},
            male: {{ $latestPop->male_count }},
            female: {{ $latestPop->female_count }},
            ageGroups: {!! json_encode($latestPop->age_groups ?? []) !!}
        };
    </script>
</div>
@endif

<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden max-w-5xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs whitespace-nowrap">
            <thead class="bg-slate-50/80 text-slate-700 font-extrabold border-b border-slate-200/80 uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="px-6 py-4">Tahun</th>
                    <th class="px-6 py-4">Total Jiwa</th>
                    <th class="px-6 py-4">Total Kepala Keluarga (KK)</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($populationData as $data)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-6 py-4 font-extrabold text-slate-900 text-sm">{{ $data->year }}</td>
                    <td class="px-6 py-4 font-bold text-slate-700">{{ number_format($data->totalPopulation()) }} Jiwa</td>
                    <td class="px-6 py-4 text-slate-600 font-semibold">{{ number_format($data->total_families) }} KK</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.population.edit', $data) }}" class="p-2 rounded-xl text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-colors cursor-pointer" title="Edit Data">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.population.destroy', $data) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data tahun ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer" title="Hapus Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-10 text-center font-bold text-slate-500">Belum ada data kependudukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

