<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\BudgetData;
use App\Services\ApbdesSpreadsheetService;
use Illuminate\Http\Request;

class BudgetDataController extends Controller
{
    public function index(Request $request)
    {
        $years = BudgetData::selectRaw('DISTINCT year')->orderByDesc('year')->pluck('year');
        $selectedYear = $request->get('year', $years->first());

        $budgetData = collect();
        if ($selectedYear) {
            $budgetData = BudgetData::forYear($selectedYear)->orderBy('type')->orderBy('category')->get();
        }

        return view('admin.budget.index', compact('budgetData', 'years', 'selectedYear'));
    }

    public function create()
    {
        return view('admin.budget.form', ['data' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        $budget = BudgetData::create($validated);

        ActivityLog::log('budget_create', "Menambahkan item APBDes ({$budget->type}): {$budget->category} (Tahun {$budget->year})", $budget);

        return redirect()
            ->route('admin.budget.index', ['year' => $validated['year']])
            ->with('success', 'Data anggaran berhasil ditambahkan.');
    }

    public function edit(BudgetData $budget)
    {
        return view('admin.budget.form', ['data' => $budget]);
    }

    public function update(Request $request, BudgetData $budget)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        $budget->update($validated);

        ActivityLog::log('budget_update', "Memperbarui item APBDes: {$budget->category} (Tahun {$budget->year})", $budget);

        return redirect()
            ->route('admin.budget.index', ['year' => $validated['year']])
            ->with('success', 'Data anggaran berhasil diperbarui.');
    }

    public function destroy(BudgetData $budget)
    {
        $year = $budget->year;
        $category = $budget->category;
        $budget->delete();

        ActivityLog::log('budget_delete', "Menghapus item APBDes: {$category} (Tahun {$year})");

        return redirect()
            ->route('admin.budget.index', ['year' => $year])
            ->with('success', 'Data anggaran berhasil dihapus.');
    }

    /**
     * Sync data from Google Sheets API
     */
    public function syncFromSpreadsheet(Request $request, ApbdesSpreadsheetService $spreadsheetService)
    {
        $spreadsheetId = env('BUDGET_SPREADSHEET_ID', '1Ze-RMNUgR6L9DLqUYTybf-_5RmgFf_zCxp-UJ0JLRmk');
        $range = env('BUDGET_SPREADSHEET_RANGE', "'APBDes Bawangan 2026'!A1:C23");
        $year = date('Y'); // Or extract from range/sheet name if needed

        try {
            $data = $spreadsheetService->fetchApbdesData($spreadsheetId, $range);
            
            // Clear existing budget data for this year before syncing to avoid duplicates
            BudgetData::forYear($year)->delete();
            
            foreach ($data as $item) {
                BudgetData::create([
                    'year' => $year,
                    'type' => $item['type'],
                    'category' => $item['category'],
                    'amount' => $item['amount'],
                ]);
            }

            ActivityLog::log('budget_sync', "Sinkronisasi data APBDes Tahun {$year} dari Google Sheets.");

            return redirect()->route('admin.budget.index', ['year' => $year])->with('success', "Data APBDes tahun {$year} berhasil disinkronisasi dari Google Sheets.");
        } catch (\Exception $e) {
            return redirect()->route('admin.budget.index', ['year' => $year])->with('error', 'Sinkronisasi gagal: ' . $e->getMessage());
        }
    }

    /**
     * JSON endpoint for Chart.js consumption.
     */
    public function chartData(int $year)
    {
        $income = BudgetData::forYear($year)->income()->get();
        $expense = BudgetData::forYear($year)->expense()->get();

        return response()->json([
            'year' => $year,
            'income' => [
                'labels' => $income->pluck('category')->toArray(),
                'data' => $income->pluck('amount')->map(fn($v) => (float) $v)->toArray(),
                'total' => (float) $income->sum('amount'),
            ],
            'expense' => [
                'labels' => $expense->pluck('category')->toArray(),
                'data' => $expense->pluck('amount')->map(fn($v) => (float) $v)->toArray(),
                'total' => (float) $expense->sum('amount'),
            ],
        ]);
    }
}
