<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doc;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Acte extends Model
{
    use HasFactory;

    protected $fillable = [
        "nom",
        "prenom",
        "acte",
        "montant",
        "method",
        "doc_id",
        "date",
    ];

    public function doc(): BelongsTo
    {
        return $this->belongsTo(Doc::class);
    }
}
