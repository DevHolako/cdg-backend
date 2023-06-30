<?php

namespace App\Observers;

use App\Models\Acte;
use App\Models\DailyProfit;
use App\Models\Doc;
use App\Models\MonthlyProfit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ActeObserver
{
    /**
     * Handle the Acte "created" event.
     */
    public function created(Acte $acte): void
    {

        $this->updateProfit($acte, false);
    }

    /**
     * Handle the Acte "updated" event.
     */
    public function updated(Acte $acte): void
    {
        $this->updateProfit($acte, false);
    }

    /**
     * Handle the Acte "deleted" event.
     */
    public function deleted(Acte $acte): void
    {
        $this->updateProfit($acte, true);
    }



    // HELPERS;


    // main fn
    private function updateProfit(Acte $acte, bool $deleted): void
    {
        $doc = $acte->doc;
        $date = $acte->date;

        if ($deleted) {
            $this->updateDailyDoc($doc, $date);
            $this->saveMonthlyProfit($doc, $acte);
            return;
        }
        $this->saveDailyProfit($doc, $acte);
        $this->saveMonthlyProfit($doc, $acte);
        return;
    }



    // for DailyUpdate 
    private function saveDailyProfit(Doc $doc, Acte $acte): void
    {
        $date = $acte->date;
        $existingProfit = DailyProfit::where('doc_id', $doc->id)
            ->where('acte_id', $acte->id)
            ->first();

        if ($existingProfit) {
            $existingProfit->update([
                "montant" => $acte->montant,
                "acte_date" => $acte->date,
            ]);
        } else {
            DailyProfit::create([
                "doc_id" => $doc->id,
                "acte_id" => $acte->id,
                "montant" => $acte->montant,
                "acte_date" => $acte->date,
            ]);
        }

        $this->updateDailyDoc($doc, $date);
    }

    private function updateDailyDoc(Doc $doc,  $date,): void
    {
        if (gettype($date) === 'string') {
            $date = date('Y-m-d', strtotime($date));
        }
        $currentDate = Carbon::now()->format('Y-m-d');

        $sum = DB::table('daily_profits')
            ->where('acte_date', $date)
            ->where('doc_id', $doc->id)
            ->sum('montant');
        if ($date === $currentDate) {
            DB::table('docs')
                ->where('id', $doc->id)
                ->update(['journalier' => $sum]);
        }
    }


    // for MonthlyUpdate 
    private function saveMonthlyProfit(Doc $doc, Acte $acte): void
    {

        $date = $acte->date;
        $montant = $acte->montant;

        if (gettype($acte->date) === 'string') {
            $date = date('Y-m-d', strtotime($acte->date));
        }

        $existingProfit = MonthlyProfit::where('doc_id', $doc->id)
            ->where('year', Carbon::parse($date)->year)
            ->where('month', Carbon::parse($date)->month)
            ->first();

        if ($existingProfit) {
            $totalMontant = DailyProfit::whereYear('acte_date', Carbon::parse($date)->year)
                ->whereMonth('acte_date', Carbon::parse($date)->month)
                ->where('doc_id', $doc->id)
                ->sum('montant');

            $existingProfit->update([
                "montant" => $totalMontant,
            ]);
        } else {
            MonthlyProfit::create([
                "doc_id" => $doc->id,
                "montant" => $montant,
                "month" => Carbon::parse($date)->month,
                "year" => Carbon::parse($date)->year,
            ]);
        }

        $this->updateMonthlyDoc($doc, $date);
    }

    private function updateMonthlyDoc(Doc $doc, $date): void
    {

        $currentMonth = Carbon::now()->format('Y-m');

        $montant = MonthlyProfit::where('doc_id', $doc->id)
            ->where("month", Carbon::parse($date)->month)
            ->where("year", Carbon::parse($date)->year)
            ->value('montant');

        if (Carbon::parse($date)->format('Y-m') === $currentMonth) {
            DB::table('docs')
                ->where('id', $doc->id)
                ->update(['mensuel' => $montant]);
        }
    }
}
