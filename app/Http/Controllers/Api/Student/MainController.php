<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\ExtendedController;
use App\Http\Resources\AbsenceResource;
use App\Http\Resources\CoursResource;
use App\Http\Resources\EcolageResource;
use App\Http\Resources\EmploiResource;
use App\Http\Resources\FicheResource;
use App\Http\Resources\InscriptionResource;
use App\Http\Resources\LivreResource;
use App\Http\Resources\NoteResource;
use App\Models\Absence;
use App\Models\Cours;
use App\Models\Critere;
use App\Models\Ecolage;
use App\Models\Emploi;
use App\Models\Etudiant;
use App\Models\Fiche;
use App\Models\FicheItem;
use App\Models\Inscription;
use App\Models\Livre;
use App\Models\Note;

class MainController extends ExtendedController
{
    public function index(){
        $matricule = request()->matricule;
        $etudiant = Etudiant::where('matricule',$matricule)->first();
        $inscription = Inscription::where('etudiant_id',$etudiant->id)->where('annee_id',$this->getAnneeId())->first();
        if($inscription){
            $cours = Cours::where('filiere_id',$inscription->filiere_id)
                        ->where('niveau_id',$inscription->niveau_id)
                        //->where('annee_id',$this->getAnneeId())
                        ->get();
            $emplois = Emploi::where('filiere_id',$inscription->filiere_id)
                                ->where('niveau_id',$inscription->niveau_id)
                                ->where('annee_id',$this->getAnneeId())
                                ->get();
            //$emplois = EmploiResource::collection($emplois);
            $notes = Note::where('inscription_id',$inscription->id)->get();
            $absences = Absence::where('inscription_id',$inscription->id)->get();
            $group = $absences->groupBy(function($item){
                return $item->mois->name;
            });

            $items = $group->map(function($v,$k){
                return $v->reduce(function($c,$it){
                    return $c+$it->gap;
                });
            });
            $data=[];
            foreach($items as $k=>$v){
                $data[]=['mois'=>$k, 'nb'=>$v];
            }
            $ecolages = Ecolage::where('inscription_id',$inscription->id)->get();
            $livres = Livre::orderBy('created_at','DESC')->where('active',1)->get();
            return response()->json([
                'inscription'=>new InscriptionResource($inscription),
                'notes'=>NoteResource::collection($notes),
                //'absences'=>AbsenceResource::collection($absences),
                'absences'=>$data,
                'emplois'=>EmploiResource::collection($emplois),
                'cours'=>CoursResource::collection($cours),
                'livres'=>LivreResource::collection($livres),
                'ecolages'=>EcolageResource::collection($ecolages)
            ]);
        }else{
            return response()->json('Access non autorise!',401);
        }
    }

    public function getFiche(){
        $inscription_id = request()->inscription_id;
        $emploi_id = request()->emploi_id;
        $fiche = Fiche::where('inscription_id',$inscription_id)->where('emploi_id',$emploi_id)->first();
        if(!$fiche){
            $inscription = Inscription::find($inscription_id);
            $emploi = Emploi::find($emploi_id);
            $criteres = Critere::where('active',1)->get();
            $fiche = new Fiche();
            $fiche->inscription_id = $inscription_id;
            $fiche->emploi_id = $emploi_id;
            $fiche->cours_id = $emploi->cours_id;
            $fiche->filiere_id = $emploi->filiere_id;
            $fiche->etudiant_id = $inscription->etudiant_id;
            $fiche->matiere_id = $emploi->matiere_id;
            $fiche->enseignant_id = $emploi->enseignant_id;
            $fiche->semestre = $emploi->semestre;
            $fiche->niveau_id = $inscription->niveau_id;
            $fiche->annee_id = $inscription->annee_id;
            $fiche->token = sha1(time().rand(1,9999));
            $fiche->name = $emploi_id.$inscription->etudiant->matricule.$inscription_id;
            //dd($fiche);
            $fiche->save();
            foreach($criteres as $critere){
                FicheItem::create([
                    'fiche_id'=>$fiche->id,
                    'critere_id'=>$critere->id,
                    'coef'=>$critere->coef,
                ]);
            }
        }

        return response()->json(new FicheResource($fiche));

    }

    public function saveFiche(){
        $id = request()->id;
        $answer = request()->answer;
        $item = FicheItem::find($id);
        $item->vdiscontented = 0;
        $item->discontented = 0;
        $item->happy = 0;
        $item->vhappy = 0;
        if($answer == -2){
            $item->vdiscontented = 1;
        }
        if($answer == -1){
            $item->discontented = 1;
        }
        if($answer == 1){
            $item->happy = 1;
        }
        if($answer == 2){
            $item->vhappy = 1;
        }
        $item->save();
        $fiche = Fiche::find($item->fiche_id);
        return response(new FicheResource($fiche));

    }
}
