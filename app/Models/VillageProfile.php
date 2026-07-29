<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageProfile extends Model
{
    protected $fillable = [
        'name',
        'vision',
        'mission',
        'history',
        'welcome_title',
        'welcome_speech',
        'address',
        'phone',
        'email',
        'area',
    ];

    /**
     * Get the singleton village profile (or create a default one).
     */
    public static function current(): self
    {
        return self::firstOrCreate(
            ['id' => 1],
            ['name' => 'Desa Bawangan']
        );
    }
}
