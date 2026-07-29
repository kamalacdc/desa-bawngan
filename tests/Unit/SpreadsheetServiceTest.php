<?php

namespace Tests\Unit;

use App\Services\SpreadsheetService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SpreadsheetServiceTest extends TestCase
{
    public function test_it_returns_total_families_in_population_sync_payload(): void
    {
        Http::fake([
            'https://docs.google.com/spreadsheets/*' => Http::response(
                "label,male,female,total,families\n0-4,10,12,22,3\nTotal,100,120,220,30\n",
                200
            ),
        ]);

        $service = new SpreadsheetService();

        $result = $service->fetchPopulationData('spreadsheet-id', 'Sheet1!A1:F17');

        $this->assertSame(100, $result['male_count']);
        $this->assertSame(120, $result['female_count']);
        $this->assertSame(30, $result['total_families']);
        $this->assertSame(['0-4' => 22], $result['age_groups']);
    }
}
