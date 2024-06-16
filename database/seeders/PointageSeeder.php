<?php

namespace Database\Seeders;

use App\Models\Absence;
use App\Models\Emploi;
use App\Models\Inscription;
use App\Models\Pointage;
use Illuminate\Database\Seeder;

class PointageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emplois = Emploi::all();
        foreach($emplois as $emploi){
           // $cours = $emploi->cours;
            Pointage::factory()->count(8)
                ->create([
                    'emploi_id'=>$emploi->id,
                    'enseignant_id'=>$emploi->enseignant_id,
                    'cours_id'=>$emploi->cours_id,
                    'filiere_id'=>$emploi->filiere_id,
                    'niveau_id'=>$emploi->niveau_id,
                    'matiere_id'=>$emploi->matiere_id,
                    'semestre'=>$emploi->semestre,
                    'pu'=>$emploi->pu,
                    'start'=>$emploi->start,
                    'end'=>$emploi->end,
                    'gap'=>$emploi->gap,
                    'day'=>$emploi->day,
                ])
                ->each(function($pointage){
                    $inscriptions = Inscription::where('filiere_id',$pointage->filiere_id)
                                    ->where('niveau_id',$pointage->niveau_id)
                                    ->get();
                    $ids = $inscriptions->pluck('id');
                    $etudiant_ids = $inscriptions->pluck('etudiant_id');
                    Absence::factory()
                    ->count(rand(3,6))
                    ->create([
                        'emploi_id'=>$pointage->emploi_id,
                        'enseignant_id'=>$pointage->enseignant_id,
                        'cours_id'=>$pointage->cours_id,
                        'filiere_id'=>$pointage->filiere_id,
                        'niveau_id'=>$pointage->niveau_id,
                        'matiere_id'=>$pointage->matiere_id,
                        'semestre'=>$pointage->semestre,
                        'start'=>$pointage->start,
                        'end'=>$pointage->end,
                        'gap'=>$pointage->gap,
                        'day'=>$pointage->day,
                        'pointage_id'=>$pointage->id,
                        'inscription_id'=>array_rand($ids->toArray()),
                        'etudiant_id'=>array_rand($etudiant_ids->toArray()),
                    ]);
                });
        }
    }
}
