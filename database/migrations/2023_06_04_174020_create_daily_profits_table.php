<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daily_profits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doc_id')->constrained()->onDelete("cascade");
            $table->foreignId('acte_id')->constrained()->onDelete("cascade");
            $table->integer("montant");
            $table->date("acte_date")->default(now());
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_profits');
    }
};
