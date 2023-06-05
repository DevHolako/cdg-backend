<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Doc;

class MonthlyProfit extends Model
{

    use HasFactory;


    protected $fillable = [
        'doc_id',
        "montant",
        "month",
        "year"
    ];


    public function doc(): BelongsTo
    {
        return $this->belongsTo(Doc::class);
    }
}
