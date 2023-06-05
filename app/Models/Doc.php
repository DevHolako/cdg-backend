<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Acte;
use App\Models\DailyProfit;
use App\Models\MonthlyProfit;

class Doc extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomComplete',
        'journalier',
        'mensuel',
    ];


    public function acts(): HasMany
    {
        return $this->hasMany(Acte::class);
    }

    public function dailyProfits(): HasMany
    {
        return $this->hasMany(DailyProfit::class);
    }

    public function monthlyProfits(): HasMany
    {
        return $this->hasMany(MonthlyProfit::class);
    }
}
