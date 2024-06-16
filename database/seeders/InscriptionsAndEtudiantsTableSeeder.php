<?php

namespace Database\Seeders;

use App\Models\Etudiant;
use App\Models\Inscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InscriptionsAndEtudiantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Etudiant::factory()
            ->has(Inscription::factory()->count(1))
            ->count(100)
            ->create();
    }
}
