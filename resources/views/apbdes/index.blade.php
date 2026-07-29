@extends('layouts.app')

@section('title', 'Transparansi APBDes')
@section('meta_description', 'Laporan Realisasi Anggaran Pendapatan dan Belanja Desa (APBDes) Bawangan, Kecamatan Ploso, Kabupaten Jombang.')

@section('content')
{{-- ═══ HERO BANNER ═══ --}}
<section class="relative bg-gradient-to-br from-slate-900 via-emerald-950 to-slate-900 py-16 lg:py-20 text-white overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%23ffffff%22%20fill-opacity%3D%220.03%22%3E%3Ccircle%20cx%3D%2230%22%20cy%3D%2230%22%20r%3D%221.5%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-300 mb-6">
            <a href="{{ route('home') }}" class="hover:text-emerald-300 transition-colors">Beranda</a>
            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-emerald-400 font-semibold">Transparansi APBDes</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-400/20 text-emerald-300 text-xs font-semibold mb-4">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Keterbukaan Informasi Keuangan Desa
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight">
                    Transparansi <span class="bg-gradient-to-r from-emerald-400 to-amber-300 bg-clip-text text-transparent">APBDes</span>
                </h1>
                <p class="text-slate-300 text-sm sm:text-base mt-3 max-w-2xl leading-relaxed">
                    Laporan Anggaran Pendapatan dan Belanja Desa (APBDes) Bawangan. Wujud komitmen akuntabilitas dan keterbukaan tata kelola keuangan pemerintah desa.
                </p>
            </div>

            {{-- Year Selector --}}
            <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/15 shrink-0">
                <form method="GET" action="{{ route('apbdes') }}" class="flex items-center gap-3">
                    <label for="tahun" class="text-xs font-bold text-slate-200 uppercase tracking-wider">Tahun Anggaran:</label>
                    <div class="relative">
                        <select name="tahun" id="tahun" onchange="this.form.submit()"
                            class="appearance-none bg-slate-900/90 text-white font-bold text-sm pl-4 pr-10 py-2 rounded-xl border border-emerald-400/30 focus:outline-none focus:ring-2 focus:ring-emerald-400 cursor-pointer">
                            @foreach ($availableYears as $year)
                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                    Tahun {{ $year }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-emerald-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ═══ KPI HIGHLIGHT CARDS ═══ --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            {{-- Total Pendapatan --}}
            <div class="bg-white rounded-3xl p-6 border border-emerald-100 shadow-xs hover:shadow-xl transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Pendapatan Desa</span>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-emerald-600 mb-1">
                    Rp {{ number_format($totalIncome, 0, ',', '.') }}
                </div>
                <p class="text-xs text-slate-500">{{ $incomeItems->count() }} pos/sumber pendapatan tercatat</p>
            </div>

            {{-- Total Belanja --}}
            <div class="bg-white rounded-3xl p-6 border border-amber-100 shadow-xs hover:shadow-xl transition-all group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Belanja Desa</span>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    </div>
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-amber-600 mb-1">
                    Rp {{ number_format($totalExpense, 0, ',', '.') }}
                </div>
                <p class="text-xs text-slate-500">{{ $expenseItems->count() }} pos/kegiatan belanja terealisasi</p>
            </div>

            {{-- Surplus / Defisit --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-xl transition-all group sm:col-span-2 lg:col-span-1">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pembiayaan / Selisih</span>
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold {{ $surplusDeficit >= 0 ? 'text-emerald-700' : 'text-rose-600' }} mb-1">
                    Rp {{ number_format(abs($surplusDeficit), 0, ',', '.') }}
                </div>
                <div class="flex items-center gap-2">
                    @if ($surplusDeficit > 0)
                        <span class="px-2.5 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-xs font-bold">Surplus Anggaran</span>
                    @elseif ($surplusDeficit < 0)
                        <span class="px-2.5 py-0.5 rounded-md bg-rose-100 text-rose-800 text-xs font-bold">Defisit Anggaran</span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-700 text-xs font-bold">Anggaran Seimbang</span>
                    @endif
                    <span class="text-xs text-slate-400">Tahun {{ $selectedYear }}</span>
                </div>
            </div>
        </div>

        {{-- ═══ CHARTS SECTION ═══ --}}
        <div class="grid lg:grid-cols-3 gap-8 mb-12">
            {{-- Chart 1: Perbandingan Pendapatan vs Belanja --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-xs flex flex-col lg:col-span-1">
                <h3 class="text-lg font-bold text-slate-800 mb-2">Total Pendapatan vs Belanja</h3>
                <p class="text-xs text-slate-500 mb-6">Perbandingan nilai agregat APBDes Bawangan</p>
                <div class="relative flex-1 min-h-[300px] w-full">
                    <canvas id="budgetBarChart"></canvas>
                </div>
            </div>

            {{-- Chart 2: Pendapatan per Kategori --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-xs flex flex-col lg:col-span-1">
                <h3 class="text-lg font-bold text-slate-800 mb-2">Sumber Pendapatan Desa</h3>
                <p class="text-xs text-slate-500 mb-6">Komposisi pendapatan menurut kategori</p>
                <div class="relative flex-1 min-h-[300px] w-full flex items-center justify-center">
                    <canvas id="incomeDonutChart"></canvas>
                </div>
            </div>

            {{-- Chart 3: Belanja per Kategori --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-xs flex flex-col lg:col-span-1">
                <h3 class="text-lg font-bold text-slate-800 mb-2">Alokasi Belanja Desa</h3>
                <p class="text-xs text-slate-500 mb-6">Komposisi belanja menurut bidang kegiatan</p>
                <div class="relative flex-1 min-h-[300px] w-full flex items-center justify-center">
                    <canvas id="expenseDonutChart"></canvas>
                </div>
            </div>
        </div>

        {{-- ═══ RINCIAN PENDAPATAN & BELANJA (TABLES) ═══ --}}
        <div class="grid lg:grid-cols-2 gap-8 mb-12">
            {{-- Tabel Pendapatan --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            Rincian Pendapatan Desa
                        </h3>
                        <p class="text-xs text-slate-500">Realisasi penerimaan keuangan desa tahun {{ $selectedYear }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200/60">
                        {{ number_format($totalIncome, 0, ',', '.') }}
                    </span>
                </div>

                @if($incomeItems->isNotEmpty())
                    <div class="space-y-4">
                        @foreach($incomeItems as $item)
                            @php $pct = $totalIncome > 0 ? round(($item->amount / $totalIncome) * 100, 1) : 0; @endphp
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/70 hover:border-emerald-300 transition-colors">
                                <div class="flex justify-between items-start mb-2 gap-2">
                                    <div>
                                        <span class="inline-block px-2.5 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[11px] font-bold mb-1">
                                            {{ $item->category }}
                                        </span>
                                        @if($item->description)
                                            <p class="text-xs text-slate-600 leading-relaxed font-medium">{{ $item->description }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="block text-sm font-extrabold text-slate-900">Rp {{ number_format($item->amount, 0, ',', '.') }}</span>
                                        <span class="text-xs text-slate-400 font-semibold">{{ $pct }}% dari pendapatan</span>
                                    </div>
                                </div>
                                {{-- Progress bar --}}
                                <div class="w-full bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ min(100, $pct) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-400 italic text-center py-8">Belum ada data pendapatan untuk tahun ini.</p>
                @endif
            </div>

            {{-- Tabel Belanja --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            Rincian Belanja Desa
                        </h3>
                        <p class="text-xs text-slate-500">Realisasi pengeluaran dan kegiatan desa tahun {{ $selectedYear }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-xl bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200/60">
                        {{ number_format($totalExpense, 0, ',', '.') }}
                    </span>
                </div>

                @if($expenseItems->isNotEmpty())
                    <div class="space-y-4">
                        @foreach($expenseItems as $item)
                            @php $pct = $totalExpense > 0 ? round(($item->amount / $totalExpense) * 100, 1) : 0; @endphp
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/70 hover:border-amber-300 transition-colors">
                                <div class="flex justify-between items-start mb-2 gap-2">
                                    <div>
                                        <span class="inline-block px-2.5 py-0.5 rounded-md bg-amber-100 text-amber-800 text-[11px] font-bold mb-1">
                                            {{ $item->category }}
                                        </span>
                                        @if($item->description)
                                            <p class="text-xs text-slate-600 leading-relaxed font-medium">{{ $item->description }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="block text-sm font-extrabold text-slate-900">Rp {{ number_format($item->amount, 0, ',', '.') }}</span>
                                        <span class="text-xs text-slate-400 font-semibold">{{ $pct }}% dari belanja</span>
                                    </div>
                                </div>
                                {{-- Progress bar --}}
                                <div class="w-full bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ min(100, $pct) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-400 italic text-center py-8">Belum ada data belanja untuk tahun ini.</p>
                @endif
            </div>
        </div>

        {{-- ═══ AKUNTABILITAS & CATATAN PENGESAHAN ═══ --}}
        <div class="bg-gradient-to-r from-slate-900 via-sky-950 to-slate-900 rounded-3xl p-8 text-white shadow-xl">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold mb-3 border border-emerald-500/30">
                        ✓ Terverifikasi & Transparan
                    </div>
                    <h3 class="text-xl font-extrabold text-white mb-2">Komitmen Transparansi Keuangan Publik</h3>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                        Data realisasi APBDes Bawangan dipublikasikan secara terbuka untuk mendukung tata kelola pemerintah desa yang bersih, akuntabel, dan berorientasi pada kemajuan serta kesejahteraan seluruh masyarakat Desa Bawangan.
                    </p>
                </div>
                <div class="shrink-0 bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/15 text-center">
                    <span class="block text-[11px] text-slate-400 font-medium uppercase tracking-wider mb-1">Pemerintah Desa</span>
                    <span class="block text-sm font-extrabold text-sky-300">Desa Bawangan</span>
                    <span class="block text-[11px] text-slate-400">Kec. Ploso, Kab. Jombang</span>
                </div>
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Chart === 'undefined') return;

    // 1. Budget Bar Chart (Pendapatan vs Belanja)
    const budgetBarCtx = document.getElementById('budgetBarChart');
    if (budgetBarCtx) {
        new Chart(budgetBarCtx, {
            type: 'bar',
            data: {
                labels: ['Pendapatan', 'Belanja'],
                datasets: [{
                    label: 'Jumlah (Rp)',
                    data: [{{ $totalIncome }}, {{ $totalExpense }}],
                    backgroundColor: ['#10b981', '#f59e0b'],
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000000) return 'Rp ' + (value / 1000000000).toFixed(1) + 'M';
                                if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + 'Jt';
                                return value;
                            },
                            font: { family: "'Plus Jakarta Sans', sans-serif" }
                        },
                        grid: { color: '#f1f5f9' }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // 2. Income Donut Chart
    const incomeDonutCtx = document.getElementById('incomeDonutChart');
    if (incomeDonutCtx) {
        const incomeLabels = {!! json_encode($incomeByCategory->keys()) !!};
        const incomeValues = {!! json_encode($incomeByCategory->values()) !!};

        new Chart(incomeDonutCtx, {
            type: 'doughnut',
            data: {
                labels: incomeLabels,
                datasets: [{
                    data: incomeValues,
                    backgroundColor: ['#10b981', '#06b6d4', '#3b82f6', '#8b5cf6', '#ec4899'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 12, usePointStyle: true, font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 } }
                    }
                }
            }
        });
    }

    // 3. Expense Donut Chart
    const expenseDonutCtx = document.getElementById('expenseDonutChart');
    if (expenseDonutCtx) {
        const expenseLabels = {!! json_encode($expenseByCategory->keys()) !!};
        const expenseValues = {!! json_encode($expenseByCategory->values()) !!};

        new Chart(expenseDonutCtx, {
            type: 'doughnut',
            data: {
                labels: expenseLabels,
                datasets: [{
                    data: expenseValues,
                    backgroundColor: ['#f59e0b', '#ef4444', '#8b5cf6', '#0284c7', '#10b981'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
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
@endsection
