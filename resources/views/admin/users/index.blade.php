@extends('layouts.admin')

@section('title', 'Manajemen Akun Administrator')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-50 text-sky-800 text-xs font-extrabold tracking-wider uppercase border border-sky-200/70 mb-2">
            <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span>Manajemen Pengguna</span>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Akun Pengelola Portal</h2>
        <p class="text-xs text-slate-600 font-medium mt-1">Kelola akun administrator dan staf yang memiliki hak akses ke panel admin.</p>
    </div>

    <a href="{{ route('admin.users.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-sky-700 to-emerald-600 hover:from-sky-800 hover:to-emerald-700 text-white text-xs font-extrabold rounded-2xl flex items-center gap-2 shrink-0 shadow-md hover:shadow-lg transition-all cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        <span>Tambah Akun Admin Baru</span>
    </a>
</div>

<div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden max-w-5xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs whitespace-nowrap">
            <thead class="bg-slate-50/80 text-slate-700 font-extrabold border-b border-slate-200/80 uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="px-6 py-4">Pengguna</th>
                    <th class="px-6 py-4">Jabatan</th>
                    <th class="px-6 py-4">Role Akses</th>
                    <th class="px-6 py-4">Dibuat</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-sky-600 to-emerald-600 flex items-center justify-center text-white text-xs font-extrabold shrink-0 shadow-xs border border-white/20 overflow-hidden">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <p class="font-extrabold text-slate-900 text-sm mb-0.5">{{ $user->name }}</p>
                                <p class="text-xs font-medium text-slate-500">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-slate-700 font-semibold">{{ $user->jabatan ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-xl text-[10px] font-extrabold uppercase tracking-wider bg-{{ $user->roleBadgeColor() }}-50 text-{{ $user->roleBadgeColor() }}-700 border border-{{ $user->roleBadgeColor() }}-200/60 inline-block">
                            {{ $user->roleLabel() }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-500 font-medium">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($user->isSuperAdmin() && $user->id !== auth()->id())
                            <span class="p-2 text-slate-300 cursor-not-allowed" title="Akun sesama Super Admin tidak dapat diedit dari menu ini">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            @else
                            <a href="{{ route('admin.users.edit', $user) }}" class="p-2 rounded-xl text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-colors cursor-pointer" title="Edit Akun">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            @endif

                            @if($user->isSuperAdmin())
                            <span class="p-2 text-slate-300 cursor-not-allowed" title="Akun Super Admin tidak dapat dihapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </span>
                            @else
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus akun {{ $user->name }}?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors cursor-pointer" title="Hapus Akun">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-10 text-center font-bold text-slate-500">Belum ada akun admin terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

