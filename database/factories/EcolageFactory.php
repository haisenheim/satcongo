<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etudiant>
 */
class EcolageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            //
            'montant'=>rand(20,85)*1000,
            'mois_id'=>rand(1,12),
            'annee_id'=>4,
            'user_id'=>1,
            'token'=>sha1(rand(100,999999)+rand(1,999))
        ];
    }
}
