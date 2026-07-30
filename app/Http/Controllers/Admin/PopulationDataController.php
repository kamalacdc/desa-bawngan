<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\PopulationData;
use App\Services\SpreadsheetService;
use Illuminate\Http\Request;

class PopulationDataController extends Controller
{
    public function index()
    {
        $populationData = PopulationData::orderByDesc('year')->paginate(10);
        return view('admin.population.index', compact('populationData'));
    }

    public function create()
    {
        return view('admin.population.form', ['data' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100|unique:population_data,year',
            'male_count' => 'required|integer|min:0',
            'female_count' => 'required|integer|min:0',
            'total_families' => 'required|integer|min:0',
            'age_groups' => 'nullable|json',
            'education_levels' => 'nullable|json',
            'occupation_data' => 'nullable|json',
        ]);

        // Decode JSON fields
        foreach (['age_groups', 'education_levels', 'occupation_data'] as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = json_decode($validated[$field], true);
            }
        }

        $pop = PopulationData::create($validated);

        ActivityLog::log('population_create', "Menambahkan data kependudukan Tahun {$pop->year}", $pop);

        return redirect()
            ->route('admin.population.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function edit(PopulationData $population)
    {
        return view('admin.population.form', ['data' => $population]);
    }

    public function update(Request $request, PopulationData $population)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100|unique:population_data,year,' . $population->id,
            'male_count' => 'required|integer|min:0',
            'female_count' => 'required|integer|min:0',
            'total_families' => 'required|integer|min:0',
            'age_groups' => 'nullable|json',
            'education_levels' => 'nullable|json',
            'occupation_data' => 'nullable|json',
        ]);

        foreach (['age_groups', 'education_levels', 'occupation_data'] as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = json_decode($validated[$field], true);
            }
        }

        $population->update($validated);

        ActivityLog::log('population_update', "Memperbarui data kependudukan Tahun {$population->year}", $population);

        return redirect()
            ->route('admin.population.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy(PopulationData $population)
    {
        $year = $population->year;
        $population->delete();

        ActivityLog::log('population_delete', "Menghapus data kependudukan Tahun {$year}");

        return redirect()
            ->route('admin.population.index')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }

    /**
     * Sync data from Google Sheets API
     */
    public function syncFromSpreadsheet(Request $request, SpreadsheetService $spreadsheetService)
    {
        $spreadsheetId = config('services.spreadsheet.population_id');
        $range = config('services.spreadsheet.population_range');

        try {
            $data = $spreadsheetService->fetchPopulationData($spreadsheetId, $range);
            
            // Create or update data for the current year
            $year = date('Y');
            
            $pop = PopulationData::updateOrCreate(
                ['year' => $year],
                [
                    'male_count' => $data['male_count'] ?? 0,
                    'female_count' => $data['female_count'] ?? 0,
                    'total_families' => $data['total_families'] ?? 0,
                    'age_groups' => $data['age_groups'] ?? [],
                    'education_levels' => $data['education_levels'] ?? [],
                    'occupation_data' => $data['occupation_data'] ?? [],
                ]
            );

            ActivityLog::log('population_sync', "Sinkronisasi data kependudukan Tahun {$year} dari Google Sheets.", $pop);

            return redirect()->route('admin.population.index')->with('success', "Data penduduk tahun {$year} berhasil disinkronisasi dari Google Sheets.");
        } catch (\Exception $e) {
            return redirect()->route('admin.population.index')->with('error', 'Sinkronisasi gagal: ' . $e->getMessage());
        }
    }

    /**
     * JSON endpoint for Chart.js consumption.
     */
    public function chartData(int $year)
    {
        $data = PopulationData::where('year', $year)->firstOrFail();

        return response()->json([
            'year' => $data->year,
            'gender' => [
                'labels' => ['Laki-laki', 'Perempuan'],
                'data' => [$data->male_count, $data->female_count],
            ],
            'age_groups' => $data->age_groups ? [
                'labels' => array_keys($data->age_groups),
                'data' => array_values($data->age_groups),
            ] : null,
            'education_levels' => $data->education_levels ? [
                'labels' => array_keys($data->education_levels),
                'data' => array_values($data->education_levels),
            ] : null,
            'occupation_data' => $data->occupation_data ? [
                'labels' => array_keys($data->occupation_data),
                'data' => array_values($data->occupation_data),
            ] : null,
            'total_families' => $data->total_families,
        ]);
    }
}
