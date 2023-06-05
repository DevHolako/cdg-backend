<?php

namespace Database\Factories;

use App\Models\Doc;
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
        return [

            'nom' => fake()->firstName(),
            'prenom' => fake()->lastName,
            'acte' => fake()->sentence,
            'montant' => fake()->randomNumber(4),
            'date' => fake()->dateTimeBetween('2023-06-04', '2023-06-06')->format('Y-m-d'),
            'method' => fake()->randomElement(['chéque', 'espece', 'card']),
            'doc_id' => fake()->randomElement($docIds),
        ];
    }
}
