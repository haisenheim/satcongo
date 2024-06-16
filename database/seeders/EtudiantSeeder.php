<?php

namespace Database\Seeders;

use App\Models\Ecolage;
use App\Models\Inscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtudiantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inscriptions = Inscription::all();
        foreach($inscriptions as $ins){
            Ecolage::factory()->count(8)
                ->create([
                    'inscription_id'=>$ins->id,
                    'etudiant_id'=>$ins->etudiant_id,
                    'filiere_id'=>$ins->filiere_id,
                    'niveau_id'=>$ins->niveau_id,
                ]);
        }
    }
}
