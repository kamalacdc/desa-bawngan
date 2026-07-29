@extends('layouts.admin')

@section('title', 'Log Aktivitas Sistem')

@section('content')

{{-- Header Info --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-amber-500/20 text-amber-800 border border-amber-500/30">
                Khusus Super Admin
            </span>
            <span class="text-xs text-slate-500 font-semibold">• Total {{ number_format($logs->total()) }} Catatan</span>
        </div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Audit Log Aktivitas Pengguna</h2>
        <p class="text-xs text-slate-500">Rekam jejak seluruh aktivitas administrasi, perubahan data, dan akses sistem.</p>
    </div>

    @if($logs->total() > 0)
    <form method="POST" action="{{ route('admin.activity-logs.clear') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SELURUH riwayat log aktivitas? Tindakan ini tidak dapat dibatalkan!');">
        @csrf
        @method('DELETE')
        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-extrabold text-xs border border-rose-200/80 transition-colors cursor-pointer">
            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            <span>Bersihkan Semua Log</span>
        </button>
    </form>
    @endif
</div>

{{-- Filter Card --}}
<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs p-6 mb-8">
    <form method="GET" action="{{ route('admin.activity-logs') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        {{-- Search Input --}}
        <div>
            <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-1.5">Pencarian</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas, nama, dsb..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 bg-slate-50/50">
        </div>

        {{-- Filter User --}}
        <div>
            <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-1.5">Pengguna</label>
            <select name="user_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 bg-slate-50/50 cursor-pointer">
                <option value="">Semua Pengguna</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->roleLabel() }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filter Action --}}
        <div>
            <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-1.5">Jenis Akses</label>
            <select name="action" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 bg-slate-50/50 cursor-pointer">
                <option value="">Semua Aktivitas</option>
                @foreach($actions as $act)
                    <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>
                        {{ str_replace('_', ' ', strtoupper($act)) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filter Date & Actions --}}
        <div class="flex items-end gap-2">
            <div class="flex-1">
                <label class="block text-[11px] font-extrabold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal</label>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-sky-500 bg-slate-50/50 cursor-pointer">
            </div>
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs transition-colors cursor-pointer">
                Filter
            </button>
            @if(request()->hasAny(['search', 'user_id', 'action', 'date']))
                <a href="{{ route('admin.activity-logs') }}" class="px-3 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs transition-colors cursor-pointer" title="Reset Filter">
                    ✕
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Activity Logs Table --}}
<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                    <th class="py-4 px-6">Waktu</th>
                    <th class="py-4 px-6">Pengguna</th>
                    <th class="py-4 px-6">Aktivitas</th>
                    <th class="py-4 px-6">Deskripsi & Rincian</th>
                    <th class="py-4 px-6 text-right">IP Address</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs">
                @forelse($logs as $log)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    
                    {{-- Timestamp --}}
                    <td class="py-4 px-6 whitespace-nowrap">
                        <div class="font-extrabold text-slate-900">{{ $log->created_at->translatedFormat('d M Y') }}</div>
                        <div class="text-[11px] font-semibold text-slate-400 font-mono">{{ $log->created_at->format('H:i:s') }} WIB ({{ $log->created_at->diffForHumans() }})</div>
                    </td>

                    {{-- User Profile --}}
                    <td class="py-4 px-6 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-slate-900 text-white font-extrabold text-xs flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($log->user_name ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-900">{{ $log->user_name ?? 'Sistem' }}</p>
                                <p class="text-[10px] font-extrabold uppercase text-slate-400">
                                    {{ $log->user_role === 'super_admin' ? 'Super Admin' : ($log->user_role === 'admin' ? 'Staf Admin' : 'System') }}
                                </p>
                            </div>
                        </div>
                    </td>

                    {{-- Action Badge --}}
                    <td class="py-4 px-6 whitespace-nowrap">
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-{{ $log->actionBadgeColor() }}-50 text-{{ $log->actionBadgeColor() }}-700 border border-{{ $log->actionBadgeColor() }}-200/80">
                            {{ $log->actionLabel() }}
                        </span>
                    </td>

                    {{-- Description --}}
                    <td class="py-4 px-6">
                        <p class="font-semibold text-slate-800 max-w-xl leading-relaxed">{{ $log->description }}</p>
                        @if($log->subject_type)
                        <p class="text-[10px] text-slate-400 font-mono mt-0.5">Subject: {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}</p>
                        @endif
                    </td>

                    {{-- IP & Agent --}}
                    <td class="py-4 px-6 text-right whitespace-nowrap">
                        <span class="inline-block font-mono text-[11px] font-bold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200/80">
                            {{ $log->ip_address ?? '127.0.0.1' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 px-6 text-center text-slate-500 font-medium">
                        Tidak ada catatan log aktivitas yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
    <div class="p-6 border-t border-slate-100 bg-slate-50/50">
        {{ $logs->links() }}
    </div>
    @endif
</div>

@endsection
