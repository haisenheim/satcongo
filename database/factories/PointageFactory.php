<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etudiant>
 */
class PointageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = Carbon::today();
        $dt = $date->subDays(rand(4,280));
        return [
            //
            'pv'=>fake()->text(),
            'dt'=>$dt,
            'annee_id'=>4,
            'user_id'=>1,
            'token'=>sha1(rand(100,999999)+rand(1,999))
        ];
    }
}
