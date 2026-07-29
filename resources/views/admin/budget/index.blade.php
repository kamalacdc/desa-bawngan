@extends('layouts.admin')

@section('title', 'Transparansi APBDes')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 text-xs font-extrabold tracking-wider uppercase border border-emerald-200/70 mb-2">
            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Transparansi Keuangan</span>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Anggaran APBDes</h2>
        <p class="text-xs text-slate-600 font-medium mt-1">Kelola rincian data Pendapatan dan Belanja Desa Bawangan untuk publikasi transparansi anggaran.</p>
    </div>
    
    <div class="flex gap-3">
        <form action="{{ route('admin.budget.sync') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold rounded-2xl flex items-center gap-2 shrink-0 shadow-md hover:shadow-lg transition-all cursor-pointer" onclick="return confirm('Tarik data terbaru dari Google Sheets API? Data anggaran tahun ini akan diperbarui (data lama tahun ini akan ditimpa).');">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span>Sinkronkan Sheets</span>
            </button>
        </form>
        <a href="{{ route('admin.budget.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-sky-700 to-emerald-600 hover:from-sky-800 hover:to-emerald-700 text-white text-xs font-extrabold rounded-2xl flex items-center gap-2 shrink-0 shadow-md hover:shadow-lg transition-all cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Pos Anggaran</span>
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

@if($budgetData->isNotEmpty())
@php
    $totalIncome = $budgetData->where('type', 'income')->sum('amount');
    $totalExpense = $budgetData->where('type', 'expense')->sum('amount');
@endphp
<div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-7 flex flex-col justify-center items-center">
        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Pendapatan Desa</p>
        <p class="text-3xl font-extrabold text-emerald-700">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-7 flex flex-col justify-center items-center">
        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Belanja Desa</p>
        <p class="text-3xl font-extrabold text-amber-700">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
    </div>
    <div class="md:col-span-2 bg-white rounded-3xl border border-slate-200/80 shadow-xs p-7">
        <h3 class="text-lg font-extrabold text-slate-900 mb-6 text-center">Perbandingan Pendapatan & Belanja</h3>
        <div class="relative w-full h-[300px]">
            <canvas id="budgetChart"></canvas>
        </div>
        <script>
            window.villageBudgetData = {
                income: {{ $totalIncome }},
                expense: {{ $totalExpense }}
            };
        </script>
    </div>
</div>
@endif

<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden max-w-5xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs whitespace-nowrap">
            <thead class="bg-slate-50/80 text-slate-700 font-extrabold border-b border-slate-200/80 uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="px-6 py-4">Kategori Anggaran</th>
                    <th class="px-6 py-4">Tipe APBDes</th>
                    <th class="px-6 py-4">Jumlah Nomina (Rp)</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($budgetData as $data)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-6 py-4 font-extrabold text-slate-900 text-sm">{{ $data->category }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-xl text-[10px] font-extrabold uppercase tracking-wider border {{ $data->type === 'income' ? 'bg-emerald-50 text-emerald-700 border-emerald-200/60' : 'bg-amber-50 text-amber-700 border-amber-200/60' }}">
                            {{ $data->type === 'income' ? 'Pendapatan' : 'Belanja' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold text-slate-800 text-sm">Rp {{ number_format($data->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.budget.edit', $data) }}" class="p-2 rounded-xl text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-colors cursor-pointer" title="Edit Anggaran">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.budget.destroy', $data) }}" method="POST" onsubmit="return confirm('Hapus pos anggaran ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer" title="Hapus Anggaran">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-10 text-center font-bold text-slate-500">Belum ada data anggaran APBDes.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

