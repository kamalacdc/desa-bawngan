<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class ApbdesSpreadsheetService
{
    /**
     * Fetch APBDes data from a public Google Sheet.
     * Uses Google Visualization API to get CSV data.
     * 
     * @param string $spreadsheetId
     * @param string $range
     * @return array
     */
    public function fetchApbdesData(string $spreadsheetId, string $range): array
    {
        if (!preg_match('/^[a-zA-Z0-9-_]+$/', $spreadsheetId)) {
            throw new Exception("Spreadsheet ID tidak valid.");
        }

        $url = "https://docs.google.com/spreadsheets/d/{$spreadsheetId}/gviz/tq?tqx=out:csv&range=" . urlencode($range);

        $verifySsl = config('services.spreadsheet.verify_ssl', true);
        $httpRequest = $verifySsl ? Http::timeout(15) : Http::withoutVerifying()->timeout(15);
        $response = $httpRequest->get($url);

        if (!$response->successful()) {
            throw new Exception("Gagal mengambil data dari Google Sheets API (HTTP {$response->status()}). Pastikan Sheet bersifat Publik.");
        }

        $csv = $response->body();
        $lines = explode("\n", $csv);
        
        if (count($lines) < 2) {
            throw new Exception("Data tidak valid atau kosong di range: {$range}");
        }

        $data = [];
        $currentType = null;

        foreach ($lines as $line) {
            if (empty(trim($line))) continue;

            $row = str_getcsv($line, ',', '"', '\\');
            $label = trim($row[0] ?? '');
            $amountStr = trim($row[2] ?? '');

            if (empty($label)) continue;

            // Detect section
            if (stripos($label, 'PENDAPATAN DESA') !== false) {
                $currentType = 'income';
                continue;
            } elseif (stripos($label, 'BELANJA DESA') !== false) {
                $currentType = 'expense';
                continue;
            } elseif (stripos($label, 'PEMBIAYAAN DESA') !== false) {
                $currentType = 'financing';
                continue;
            }

            // Skip Totals and Sisa
            if (stripos($label, 'TOTAL') !== false || stripos($label, 'SISA') !== false || stripos($label, 'PEMBIAYAAN NETTO') !== false) {
                continue;
            }

            // Parse amount (Remove "Rp", dots, commas, spaces)
            $amountStr = str_ireplace(['Rp', '.', ',', ' '], '', $amountStr);
            $amount = (float) $amountStr;

            if ($currentType && $amount >= 0 && $amountStr !== '') {
                $type = $currentType;
                if ($type === 'financing') {
                    if (stripos($label, 'Penerimaan') !== false) $type = 'income';
                    else if (stripos($label, 'Pengeluaran') !== false) $type = 'expense';
                    else $type = 'income';
                }

                $data[] = [
                    'type' => $type,
                    'category' => $label,
                    'amount' => $amount,
                ];
            }
        }

        return $data;
    }
}
