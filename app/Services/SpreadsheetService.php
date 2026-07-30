<?php

namespace App\Services;

use Exception;
use DateTime;
use Illuminate\Support\Facades\Http;

class SpreadsheetService
{
    /**
     * Fetch population data from a public Google Sheet.
     * Supports both raw individual resident datasets and summary table formats.
     * 
     * @param string $spreadsheetId
     * @param string $range
     * @return array
     */
    public function fetchPopulationData(string $spreadsheetId, string $range = ''): array
    {
        if (!preg_match('/^[a-zA-Z0-9-_]+$/', $spreadsheetId)) {
            throw new Exception("Spreadsheet ID tidak valid.");
        }

        $url = "https://docs.google.com/spreadsheets/d/{$spreadsheetId}/gviz/tq?tqx=out:csv";
        if (!empty($range)) {
            $url .= "&range=" . urlencode($range);
        }

        $verifySsl = config('services.spreadsheet.verify_ssl', true);
        $httpRequest = $verifySsl ? Http::timeout(15) : Http::withoutVerifying()->timeout(15);
        $response = $httpRequest->get($url);

        if (!$response->successful()) {
            throw new Exception("Gagal mengambil data dari Google Sheets API (HTTP {$response->status()}). Pastikan Sheet bersifat Publik (Anyone with the link can view).");
        }

        $csv = $response->body();
        $lines = explode("\n", $csv);
        
        if (count($lines) < 2) {
            throw new Exception("Data tidak valid atau kosong di Google Sheet.");
        }

        $headerLine = str_getcsv($lines[0], ',', '"', '\\');
        $headerUpper = array_map(fn($col) => strtoupper(trim($col)), $headerLine);

        $genderIdx = array_search('JENIS KELAMIN', $headerUpper);
        $kkIdx = array_search('KK', $headerUpper);
        $dobIdx = array_search('TANGGAL LAHIR', $headerUpper);
        $eduIdx = array_search('PENDIDIKAN', $headerUpper);
        $occIdx = array_search('PEKERJAAN', $headerUpper);

        // If sheet is a raw resident list (contains JENIS KELAMIN & KK/NIK/TANGGAL LAHIR)
        if ($genderIdx !== false) {
            return $this->parseRawResidentData($lines, $genderIdx, $kkIdx, $dobIdx, $eduIdx, $occIdx);
        }

        // Fallback to summary row format
        return $this->parseSummaryData($lines);
    }

    /**
     * Parse raw individual resident rows and calculate demographics dynamically.
     */
    private function parseRawResidentData(array $lines, int $genderIdx, $kkIdx, $dobIdx, $eduIdx, $occIdx): array
    {
        $totalMale = 0;
        $totalFemale = 0;
        $kkList = [];
        $ageBracketCounts = [
            '0 - 4 Tahun' => 0,
            '5 - 9 Tahun' => 0,
            '10 - 14 Tahun' => 0,
            '15 - 19 Tahun' => 0,
            '20 - 24 Tahun' => 0,
            '25 - 29 Tahun' => 0,
            '30 - 39 Tahun' => 0,
            '40 - 49 Tahun' => 0,
            '50 - 59 Tahun' => 0,
            '60+ Tahun' => 0,
        ];
        $educationLevels = [];
        $occupationData = [];

        $now = new DateTime();

        foreach ($lines as $index => $line) {
            if ($index === 0 || empty(trim($line))) continue;

            $data = str_getcsv($line, ',', '"', '\\');
            if (count($data) <= $genderIdx) continue;

            // Gender
            $gender = strtoupper(trim($data[$genderIdx] ?? ''));
            if (str_contains($gender, 'LAKI')) {
                $totalMale++;
            } elseif (str_contains($gender, 'PEREMPUAN')) {
                $totalFemale++;
            }

            // Family KK (Clean invisible non-breaking spaces or zero-width unicode chars)
            if ($kkIdx !== false && isset($data[$kkIdx])) {
                $kk = trim($data[$kkIdx]);
                $kk = preg_replace('/[\x{00A0}\x{200B}-\x{200D}\x{FEFF}]/u', '', $kk);
                if (!empty($kk)) {
                    $kkList[$kk] = true;
                }
            }

            // Age / Date of Birth
            if ($dobIdx !== false && !empty($data[$dobIdx] ?? '')) {
                $dobStr = trim($data[$dobIdx]);
                $dob = DateTime::createFromFormat('d-m-Y', $dobStr);
                if (!$dob) {
                    $dob = DateTime::createFromFormat('Y-m-d', $dobStr);
                }

                if ($dob) {
                    $age = $now->diff($dob)->y;
                    if ($age < 5) $group = '0 - 4 Tahun';
                    elseif ($age < 10) $group = '5 - 9 Tahun';
                    elseif ($age < 15) $group = '10 - 14 Tahun';
                    elseif ($age < 20) $group = '15 - 19 Tahun';
                    elseif ($age < 25) $group = '20 - 24 Tahun';
                    elseif ($age < 30) $group = '25 - 29 Tahun';
                    elseif ($age < 40) $group = '30 - 39 Tahun';
                    elseif ($age < 50) $group = '40 - 49 Tahun';
                    elseif ($age < 60) $group = '50 - 59 Tahun';
                    else $group = '60+ Tahun';

                    $ageBracketCounts[$group]++;
                }
            }

            // Education
            if ($eduIdx !== false && !empty(trim($data[$eduIdx] ?? ''))) {
                $edu = $this->normalizeEducation(trim($data[$eduIdx]));
                $educationLevels[$edu] = ($educationLevels[$edu] ?? 0) + 1;
            }

            // Occupation
            if ($occIdx !== false && !empty(trim($data[$occIdx] ?? ''))) {
                $occ = $this->normalizeOccupation(trim($data[$occIdx]));
                $occupationData[$occ] = ($occupationData[$occ] ?? 0) + 1;
            }
        }

        // Sort Education & Occupation by highest count
        arsort($educationLevels);
        arsort($occupationData);

        return [
            'male_count' => $totalMale,
            'female_count' => $totalFemale,
            'total_families' => count($kkList),
            'age_groups' => array_filter($ageBracketCounts, fn($val) => $val > 0),
            'education_levels' => $educationLevels,
            'occupation_data' => $occupationData,
        ];
    }

    /**
     * Normalize raw education labels into 8 standard categories.
     */
    private function normalizeEducation(string $edu): string
    {
        $e = strtoupper(trim($edu));
        $e = preg_replace('/\s+/', ' ', $e);

        if (str_contains($e, 'TDK/BLM') || str_contains($e, 'TIDAK/BELUM') || $e === 'BELUM SEKOLAH') {
            return 'TIDAK/BELUM SEKOLAH';
        }
        if (str_contains($e, 'BELUM TAMAT SD')) {
            return 'BELUM TAMAT SD/SEDERAJAT';
        }
        if ($e === 'TAMAT SD/SEDERAJAT' || $e === 'SD/SEDERAJAT') {
            return 'TAMAT SD/SEDERAJAT';
        }
        if (str_contains($e, 'SLTP')) {
            return 'SLTP/SEDERAJAT';
        }
        if (str_contains($e, 'SLTA')) {
            return 'SLTA/SEDERAJAT';
        }
        if (str_contains($e, 'DIPLOMA I/') || str_contains($e, 'DIPLOMA I/II') || str_contains($e, 'DIPLOMA I/III') || str_contains($e, 'AKADEMI')) {
            return 'DIPLOMA I / II / III';
        }
        if (str_contains($e, 'DIPLOMA IV') || str_contains($e, 'STRATA I') || str_contains($e, 'SRATA I') || str_contains($e, 'STARTA I')) {
            return 'DIPLOMA IV / STRATA I';
        }
        if (str_contains($e, 'STRATA - II') || str_contains($e, 'STRATA II') || str_contains($e, 'STRATA III')) {
            return 'STRATA II / III';
        }

        return $e;
    }

    /**
     * Normalize raw occupation labels into standard categories.
     */
    private function normalizeOccupation(string $occ): string
    {
        $o = strtoupper(trim($occ));
        $o = preg_replace('/\s+/', ' ', $o);

        if (str_contains($o, 'BLM/TDK BEKERJA') || str_contains($o, 'BELUM/TIDAK BEKERJA')) {
            return 'BELUM/TIDAK BEKERJA';
        }
        if (str_contains($o, 'BURUH TANI') || str_contains($o, 'BURUIH TANI')) {
            return 'BURUH TANI/PERKEBUNAN';
        }
        if ($o === 'PNS' || str_contains($o, 'PEGAWAI NEGERI SIPIL')) {
            return 'PEGAWAI NEGERI SIPIL (PNS)';
        }
        if ($o === 'TNI' || str_contains($o, 'TENTARA NASIONAL')) {
            return 'TENTARA NASIONAL INDONESIA (TNI)';
        }
        if (str_contains($o, 'POLRI') || str_contains($o, 'KEPOLISIAN')) {
            return 'KEPOLISIAN RI (POLRI)';
        }
        if ($o === 'PERDAGANGAN') {
            return 'PEDAGANG';
        }
        if ($o === 'SWASTA') {
            return 'KARYAWAN SWASTA';
        }
        if (str_contains($o, 'ANGGOTA LEMBAGA TINGGI')) {
            return 'PEKERJAAN LAINNYA';
        }

        return $o;
    }

    /**
     * Parse summary pre-aggregated table rows.
     */
    private function parseSummaryData(array $lines): array
    {
        $ageGroups = [];
        $totalMale = 0;
        $totalFemale = 0;
        $totalFamilies = 0;

        foreach ($lines as $index => $line) {
            if ($index === 0) continue; // Skip header

            $data = str_getcsv($line, ',', '"', '\\');
            if (count($data) < 3) continue;

            $hasIndexCol = is_numeric(trim($data[0] ?? ''));
            $offset = $hasIndexCol ? 1 : 0;

            $ageLabel = $data[0 + $offset] ?? '';
            $male = (int) ($data[1 + $offset] ?? 0);
            $female = (int) ($data[2 + $offset] ?? 0);
            $total = (int) ($data[3 + $offset] ?? 0);
            $families = (int) ($data[4 + $offset] ?? 0);

            $ageLabelClean = strtolower(trim($ageLabel));

            if ($ageLabelClean === 'total' || $ageLabelClean === '') {
                if ($ageLabelClean === 'total') {
                    $totalMale = $male;
                    $totalFemale = $female;
                    $totalFamilies = $families;
                }
                continue;
            }

            $ageGroups[$ageLabel] = $total;
        }

        return [
            'male_count' => $totalMale,
            'female_count' => $totalFemale,
            'total_families' => $totalFamilies,
            'age_groups' => $ageGroups,
            'education_levels' => [],
            'occupation_data' => [],
        ];
    }
}

