@extends('layouts.admin')

@section('title', $data ? 'Edit Anggaran' : 'Tambah Anggaran')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 max-w-2xl">
    <form action="{{ $data ? route('admin.budget.update', $data) : route('admin.budget.store') }}" method="POST" class="space-y-6">
        @csrf
        @if($data) @method('PUT') @endif

        <div class="grid sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold mb-2">Tahun</label>
                <input type="number" name="year" value="{{ old('year', $data->year ?? date('Y')) }}" class="w-full px-4 py-2 border border-slate-300 rounded-xl" required>
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">Tipe</label>
                <select name="type" class="w-full px-4 py-2 border border-slate-300 rounded-xl" required>
                    <option value="income" {{ (old('type', $data->type ?? '') == 'income') ? 'selected' : '' }}>Pendapatan</option>
                    <option value="expense" {{ (old('type', $data->type ?? '') == 'expense') ? 'selected' : '' }}>Belanja</option>
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-bold mb-2">Kategori (Contoh: Dana Desa / Bidang Pembangunan)</label>
                <input type="text" name="category" value="{{ old('category', $data->category ?? '') }}" class="w-full px-4 py-2 border border-slate-300 rounded-xl" required>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-bold mb-2">Jumlah (Rp)</label>
                <input type="number" name="amount" value="{{ old('amount', $data->amount ?? 0) }}" class="w-full px-4 py-2 border border-slate-300 rounded-xl" required>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-bold mb-2">Keterangan Tambahan</label>
                <textarea name="description" class="w-full px-4 py-2 border border-slate-300 rounded-xl">{{ old('description', $data->description ?? '') }}</textarea>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="px-6 py-2.5 bg-sky-600 text-white font-bold rounded-xl hover:bg-sky-700">Simpan Data</button>
        </div>
    </form>
</div>
@endsection
