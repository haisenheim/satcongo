<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etudiant>
 */
class InscriptionFactory extends Factory
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
            'amount'=>25000,
            'niveau_id'=>rand(1,2),
            'filiere_id'=>rand(1,3),
            'annee_id'=>4,
            'user_id'=>1,
            'token'=>sha1(rand(100,999999)+rand(1,999))
        ];
    }
}
