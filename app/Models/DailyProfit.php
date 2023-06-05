<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Doc;

class DailyProfit extends Model
{
    use HasFactory;
    protected $fillable = [
        "doc_id",
        "acte_id",
        "montant",
        "acte_date"
    ];


    public function doc(): BelongsTo
    {
        return $this->belongsTo(Doc::class);
    }
}
