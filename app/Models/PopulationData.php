<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopulationData extends Model
{
    protected $table = 'population_data';

    protected $fillable = [
        'year',
        'male_count',
        'female_count',
        'total_families',
        'age_groups',
        'education_levels',
        'occupation_data',
    ];

    protected function casts(): array
    {
        return [
            'age_groups' => 'array',
            'education_levels' => 'array',
            'occupation_data' => 'array',
        ];
    }

    public function totalPopulation(): int
    {
        return $this->male_count + $this->female_count;
    }
}
