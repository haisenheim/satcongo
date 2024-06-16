<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etudiant>
 */
class EtudiantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dtn = now()->subYears(15);
        return [
            //
            'first_name' => fake()->firstName(),
            'last_name'=> fake()->lastName(),
            'matricule'=>'DGC000'.random_int(10,60),
            'dtn'=>fake()->date('Y-m-d',$dtn),
            'lieu'=>fake()->city(),
            'tuteur_id'=>rand(1,4),
            'pay_id'=>rand(1,4),
            'pere'=>fake()->name('male'),
            'mere'=>fake()->name('female'),
            'diplome_id'=>rand(1,3),
            'user_id'=>1,
            'address'=>fake()->address(),
            'phone'=>fake()->phoneNumber(),
            'email'=>fake()->email(),
            'token'=>sha1(rand(1,10000).fake()->name()),
            'image_uri'=>'etudiants/image_'.rand(1,5),
        ];
    }
}
