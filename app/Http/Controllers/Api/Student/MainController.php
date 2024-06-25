<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\ExtendedController;
use App\Http\Resources\AbsenceResource;
use App\Http\Resources\CoursResource;
use App\Http\Resources\EcolageResource;
use App\Http\Resources\EmploiResource;
use App\Http\Resources\InscriptionResource;
use App\Http\Resources\LivreResource;
use App\Http\Resources\NoteResource;
use App\Models\Absence;
use App\Models\Cours;
use App\Models\Ecolage;
use App\Models\Emploi;
use App\Models\Etudiant;
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
}
