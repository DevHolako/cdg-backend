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
        $after5days = Carbon::now()->addDays(5)->format('Y-m-d');
        return [

            'nom' => fake()->firstName(),
            'prenom' => fake()->lastName(),
            'acte' => fake()->word(),
            'montant' => fake()->randomNumber(4),
            'date' => fake()->dateTimeBetween($now, $after5days)->format('Y-m-d'),
            'method' => fake()->randomElement(['chéque', 'espece', 'card']),
            'doc_id' => fake()->randomElement($docIds),
        ];
    }
}
