<?php

namespace Database\Seeders;

use App\Models\Ecolage;
use App\Models\Etudiant;
use App\Models\Inscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $etudiants = Etudiant::all();
        foreach($etudiants as $etudiant){
            Inscription::factory()->count(1)
                ->create([
                    'etudiant_id'=>$etudiant->id,
                    'filiere_id'=>rand(1,4),
                    'niveau_id'=>rand(1,3),
                    'annee_id'=>4,
                    'user_id'=>1,
                    'token'=>sha1(time().rand(1,9999))
                ]);
        }
    }
}
