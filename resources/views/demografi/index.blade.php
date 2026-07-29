@extends('layouts.app')

@section('title', 'Demografi Penduduk')
@section('meta_description', 'Data dan Informasi Statistik Demografi Penduduk Desa Bawangan, Kecamatan Ploso, Kabupaten Jombang.')

@section('content')
{{-- ═══ HERO BANNER ═══ --}}
<section class="relative bg-gradient-to-br from-slate-900 via-sky-950 to-slate-900 py-16 lg:py-20 text-white overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.03%22%3E%3Ccircle%20cx%3D%2230%22%20cy%3D%2230%22%20r%3D%221.5%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-300 mb-6">
            <a href="{{ route('home') }}" class="hover:text-sky-300 transition-colors">Beranda</a>
            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-sky-400 font-semibold">Demografi Penduduk</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-500/10 border border-sky-400/20 text-sky-300 text-xs font-semibold mb-4">
                    <span class="w-2 h-2 rounded-full bg-sky-400 animate-pulse"></span>
                    Sistem Informasi Kependudukan
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight">
                    Demografi & Data <span class="bg-gradient-to-r from-sky-400 to-emerald-400 bg-clip-text text-transparent">Penduduk</span>
                </h1>
                <p class="text-slate-300 text-sm sm:text-base mt-3 max-w-2xl leading-relaxed">
                    Informasi komprehensif mengenai struktur kependudukan, kelompok umur, tingkat pendidikan, serta mata pencaharian warga Desa Bawangan.
                </p>
            </div>

            {{-- Year Selector --}}
            <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/15 shrink-0">
                <form method="GET" action="{{ route('demografi') }}" class="flex items-center gap-3">
                    <label for="tahun" class="text-xs font-bold text-slate-200 uppercase tracking-wider">Tahun Data:</label>
                    <div class="relative">
                        <select name="tahun" id="tahun" onchange="this.form.submit()"
                            class="appearance-none bg-slate-900/90 text-white font-bold text-sm pl-4 pr-10 py-2 rounded-xl border border-sky-400/30 focus:outline-none focus:ring-2 focus:ring-sky-400 cursor-pointer">
                            @foreach ($availableYears as $year)
                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                    Tahun {{ $year }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-sky-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@if ($population)
@php
    $total = $population->male_count + $population->female_count;
    $malePct = $total > 0 ? round(($population->male_count / $total) * 100, 1) : 0;
    $femalePct = $total > 0 ? round(($population->female_count / $total) * 100, 1) : 0;
    $sexRatio = $population->female_count > 0 ? round(($population->male_count / $population->female_count) * 100, 1) : 100;
    $avgFamilyMembers = ($population->total_families > 0 && $total > 0) ? round($total / $population->total_families, 1) : '-';
    
    $ageGroups = $population->age_groups ?? [
        '0-4 Th' => 180,
        '5-14 Th' => 350,
        '15-24 Th' => 410,
        '25-54 Th' => 1120,
        '55+ Th' => 500,
    ];

    $educationLevels = $population->education_levels ?? [
        'Tidak/Belum Sekolah' => 280,
        'SD / Sederajat' => 650,
        'SMP / Sederajat' => 540,
        'SMA / Sederajat' => 820,
        'Diploma / Sarjana' => 270,
    ];

    $occupations = $population->occupation_data ?? [
        'Petani / Pekebun' => 780,
        'Pedagang / Wiraswasta' => 420,
        'Karyawan Swasta' => 510,
        'PNS / TNI / Polri' => 85,
        'Buruh Harian Lepas' => 340,
        'Belum / Tidak Bekerja' => 425,
    ];
@endphp

<section class="py-12 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ═══ KPI HIGHLIGHT CARDS ═══ --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            {{-- Total Penduduk --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Penduduk</span>
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-slate-900 mb-1">
                    {{ number_format($total, 0, ',', '.') }} <span class="text-sm font-normal text-slate-500">Jiwa</span>
                </div>
                <p class="text-xs text-slate-500">Tercatat pada tahun {{ $population->year }}</p>
            </div>

            {{-- Laki-laki --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Laki-Laki</span>
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-slate-900 mb-1">
                    {{ number_format($population->male_count, 0, ',', '.') }} <span class="text-sm font-normal text-slate-500">Jiwa</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 text-xs font-bold">{{ $malePct }}%</span>
                    <span class="text-xs text-slate-400">dari total populasi</span>
                </div>
            </div>

            {{-- Perempuan --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Perempuan</span>
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-slate-900 mb-1">
                    {{ number_format($population->female_count, 0, ',', '.') }} <span class="text-sm font-normal text-slate-500">Jiwa</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded-md bg-rose-50 text-rose-700 text-xs font-bold">{{ $femalePct }}%</span>
                    <span class="text-xs text-slate-400">dari total populasi</span>
                </div>
            </div>

            {{-- Kepala Keluarga (KK) --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kepala Keluarga (KK)</span>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                </div>
                <div class="text-3xl font-extrabold text-slate-900 mb-1">
                    {{ number_format($population->total_families, 0, ',', '.') }} <span class="text-sm font-normal text-slate-500">KK</span>
                </div>
                <p class="text-xs text-slate-500">Rata-rata {{ $avgFamilyMembers }} jiwa / KK</p>
            </div>
        </div>

        {{-- ═══ CHARTS SECTION ═══ --}}
        <div class="grid lg:grid-cols-2 gap-8 mb-12">
            {{-- Chart 1: Donut Gender --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-xs flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Komposisi Jenis Kelamin</h3>
                        <p class="text-xs text-slate-500">Perbandingan jumlah warga Laki-laki & Perempuan</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-sky-50 text-sky-700 text-xs font-bold">Rasio: {{ $sexRatio }}</span>
                </div>
                <div class="relative flex-1 min-h-[280px] w-full flex items-center justify-center">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>

            {{-- Chart 2: Bar Age Groups --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-xs flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Distribusi Kelompok Umur</h3>
                        <p class="text-xs text-slate-500">Pengelompokan usia penduduk Desa Bawangan</p>
                    </div>
                </div>
                <div class="relative flex-1 min-h-[280px] w-full">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>

            {{-- Chart 3: Education Level --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-xs flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Tingkat Pendidikan Masyarakat</h3>
                        <p class="text-xs text-slate-500">Statistik pendidikan jenjang sekolah warga</p>
                    </div>
                </div>
                <div class="relative flex-1 min-h-[280px] w-full">
                    <canvas id="eduChart"></canvas>
                </div>
            </div>

            {{-- Chart 4: Occupation --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-xs flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Mata Pencaharian Utama</h3>
                        <p class="text-xs text-slate-500">Sebaran bidang mata pencaharian penduduk</p>
                    </div>
                </div>
                <div class="relative flex-1 min-h-[280px] w-full">
                    <canvas id="occChart"></canvas>
                </div>
            </div>
        </div>
<!-- 
        {{-- ═══ TABEL RINCIAN DEMOGRAFI ═══ --}}
        <div class="grid lg:grid-cols-3 gap-8 mb-12">
            {{-- Tabel Kelompok Umur --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
                <h3 class="text-base font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                    Rincian Kelompok Umur
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100">
                                <th class="pb-3">Kategori</th>
                                <th class="pb-3 text-right">Jumlah</th>
                                <th class="pb-3 text-right">Persentase</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            @foreach ($ageGroups as $group => $count)
                                @php $pct = $total > 0 ? round(($count / $total) * 100, 1) : 0; @endphp
                                <tr class="hover:bg-slate-50">
                                    <td class="py-3 font-semibold text-slate-900">{{ $group }}</td>
                                    <td class="py-3 text-right font-bold text-slate-800">{{ number_format($count, 0, ',', '.') }}</td>
                                    <td class="py-3 text-right">
                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-bold">{{ $pct }}%</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tabel Pendidikan --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
                <h3 class="text-base font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    Rincian Tingkat Pendidikan
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100">
                                <th class="pb-3">Jenjang</th>
                                <th class="pb-3 text-right">Jumlah</th>
                                <th class="pb-3 text-right">Persentase</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            @foreach ($educationLevels as $edu => $count)
                                @php $pct = $total > 0 ? round(($count / $total) * 100, 1) : 0; @endphp
                                <tr class="hover:bg-slate-50">
                                    <td class="py-3 font-semibold text-slate-900">{{ $edu }}</td>
                                    <td class="py-3 text-right font-bold text-slate-800">{{ number_format($count, 0, ',', '.') }}</td>
                                    <td class="py-3 text-right">
                                        <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 font-bold">{{ $pct }}%</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tabel Pekerjaan --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs">
                <h3 class="text-base font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                    Rincian Mata Pencaharian
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100">
                                <th class="pb-3">Sektor</th>
                                <th class="pb-3 text-right">Jumlah</th>
                                <th class="pb-3 text-right">Persentase</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            @foreach ($occupations as $occ => $count)
                                @php $pct = $total > 0 ? round(($count / $total) * 100, 1) : 0; @endphp
                                <tr class="hover:bg-slate-50">
                                    <td class="py-3 font-semibold text-slate-900">{{ $occ }}</td>
                                    <td class="py-3 text-right font-bold text-slate-800">{{ number_format($count, 0, ',', '.') }}</td>
                                    <td class="py-3 text-right">
                                        <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 font-bold">{{ $pct }}%</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->

        {{-- ═══ HISTORICAL DATA TABLE ═══ --}}
        @if ($history->count() > 1)
        <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-xs mb-12">
            <h3 class="text-lg font-bold text-slate-900 mb-2">Riwayat Perkembangan Populasi</h3>
            <p class="text-xs text-slate-500 mb-6">Perbandingan data kependudukan antar tahun di Desa Bawangan</p>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wider font-bold border-b border-slate-200">
                            <th class="py-3.5 px-4 rounded-l-xl">Tahun</th>
                            <th class="py-3.5 px-4">Laki-Laki</th>
                            <th class="py-3.5 px-4">Perempuan</th>
                            <th class="py-3.5 px-4">Total Penduduk</th>
                            <th class="py-3.5 px-4 rounded-r-xl">Kepala Keluarga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                        @foreach ($history as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3.5 px-4 font-bold text-sky-700">Tahun {{ $item->year }}</td>
                                <td class="py-3.5 px-4">{{ number_format($item->male_count, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-4">{{ number_format($item->female_count, 0, ',', '.') }}</td>
                                <td class="py-3.5 px-4 font-bold text-slate-900">{{ number_format($item->male_count + $item->female_count, 0, ',', '.') }} Jiwa</td>
                                <td class="py-3.5 px-4">{{ number_format($item->total_families, 0, ',', '.') }} KK</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Chart === 'undefined') return;

    // 1. Gender Donut Chart
    const genderCtx = document.getElementById('genderChart');
    if (genderCtx) {
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [{{ $population->male_count }}, {{ $population->female_count }}],
                    backgroundColor: ['#0284c7', '#f43f5e'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 20, usePointStyle: true, font: { family: "'Plus Jakarta Sans', sans-serif", weight: '600' } }
                    }
                }
            }
        });
    }

    // 2. Age Bar Chart
    const ageCtx = document.getElementById('ageChart');
    if (ageCtx) {
        const ageLabels = {!! json_encode(array_keys($ageGroups)) !!};
        const ageData = {!! json_encode(array_values($ageGroups)) !!};

        new Chart(ageCtx, {
            type: 'bar',
            data: {
                labels: ageLabels,
                datasets: [{
                    label: 'Jumlah Jiwa',
                    data: ageData,
                    backgroundColor: '#38bdf8',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // 3. Education Chart
    const eduCtx = document.getElementById('eduChart');
    if (eduCtx) {
        const eduLabels = {!! json_encode(array_keys($educationLevels)) !!};
        const eduData = {!! json_encode(array_values($educationLevels)) !!};

        new Chart(eduCtx, {
            type: 'bar',
            data: {
                labels: eduLabels,
                datasets: [{
                    label: 'Jumlah Jiwa',
                    data: eduData,
                    backgroundColor: '#10b981',
                    borderRadius: 8
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    y: { grid: { display: false } }
                }
            }
        });
    }

    // 4. Occupation Chart
    const occCtx = document.getElementById('occChart');
    if (occCtx) {
        const occLabels = {!! json_encode(array_keys($occupations)) !!};
        const occData = {!! json_encode(array_values($occupations)) !!};

        new Chart(occCtx, {
            type: 'doughnut',
            data: {
                labels: occLabels,
                datasets: [{
                    data: occData,
                    backgroundColor: ['#f59e0b', '#06b6d4', '#8b5cf6', '#ec4899', '#10b981', '#64748b'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 12, usePointStyle: true, font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 } }
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endif
@endsection
