<?php

namespace Database\Factories;

use App\Models\Doc;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Acte>
 */
class ActeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $docIds = Doc::pluck('id')->toArray();
        $now = Carbon::now()->format('Y-m-d');
        $dateRange = [
            Carbon::now()->subDays(2)->format('Y-m-d'),
            Carbon::now()->addDays(2)->format('Y-m-d')
        ];
        $procedures = [
            "Examen bucco-dentaire",
            "Nettoyage dentaire",
            "Obturation dentaire",
            "Dévitalisation dentaire",
            "Extraction dentaire",
            "Pose de couronne dentaire",
            "Pose de bridge dentaire",
            "Implant dentaire",
            "Blanchiment dentaire",
            "Orthodontie"
        ];

        return [

            'nom' => fake()->firstName(),
            'prenom' => fake()->lastName(),
            'acte' => fake()->randomElement($procedures),
            'montant' => fake()->randomNumber(4),
            'date' => fake()->dateTimeBetween($dateRange[0], $dateRange[1])->format('Y-m-d'),
            'method' => fake()->randomElement(['chéque', 'espece', 'card']),
            'doc_id' => fake()->randomElement($docIds),
        ];
    }
}
