<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetData extends Model
{
    protected $table = 'budget_data';

    protected $fillable = [
        'year',
        'type',
        'category',
        'amount',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeForYear($query, int $year)
    {
        return $query->where('year', $year);
    }

    /**
     * Format amount as Indonesian Rupiah.
     */
    public function formattedAmount(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
