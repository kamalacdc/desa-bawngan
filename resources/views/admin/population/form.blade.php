@extends('layouts.admin')

@section('title', $data ? 'Edit Data Penduduk' : 'Tambah Data Penduduk')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 max-w-2xl">
    <form action="{{ $data ? route('admin.population.update', $data) : route('admin.population.store') }}" method="POST" class="space-y-6">
        @csrf
        @if($data) @method('PUT') @endif

        <div class="grid sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold mb-2">Tahun</label>
                <input type="number" name="year" value="{{ old('year', $data->year ?? date('Y')) }}" class="w-full px-4 py-2 border border-slate-300 rounded-xl" required>
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">Total KK</label>
                <input type="number" name="total_families" value="{{ old('total_families', $data->total_families ?? 0) }}" class="w-full px-4 py-2 border border-slate-300 rounded-xl" required>
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">Jumlah Laki-laki</label>
                <input type="number" name="male_count" value="{{ old('male_count', $data->male_count ?? 0) }}" class="w-full px-4 py-2 border border-slate-300 rounded-xl" required>
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">Jumlah Perempuan</label>
                <input type="number" name="female_count" value="{{ old('female_count', $data->female_count ?? 0) }}" class="w-full px-4 py-2 border border-slate-300 rounded-xl" required>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="px-6 py-2.5 bg-sky-600 text-white font-bold rounded-xl hover:bg-sky-700">Simpan Data</button>
        </div>
    </form>
</div>
@endsection
