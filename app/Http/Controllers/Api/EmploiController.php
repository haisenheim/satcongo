<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ExtendedController;
use App\Http\Resources\CoursResource;
use App\Http\Resources\EmploiResource;
use App\Http\Resources\EnseignantResource;
use App\Http\Resources\InscriptionResource;
use App\Http\Resources\PointageResource;
use App\Models\Absence;
use App\Models\Cours;
use App\Models\Emploi;
use App\Models\Enseignant;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\Matiere;
use App\Models\Pointage;
use App\Models\Salle;
use Carbon\Carbon;
use DateTime;

class EmploiController extends ExtendedController
{

    public function index(){
       // $items = Emploi::where('annee_id',$this->getAnneeId())->get();
        $items = Emploi::all();
        return response()->json($items);
    }

    public function store(){
        $data = request()->all();
        $cours = Cours::find($data['cours_id']);
        $data['matiere_id'] = $cours->matiere_id;
        $data['semestre'] = $cours->semestre;
        $data['niveau_id'] = $cours->niveau_id;
        $dt1 = Carbon::now();
        $dt2 = $dt1->clone();
        $dt1->addHours(explode(':',$data['end'])[0]);
        $dt1->addMinutes(explode(':',$data['end'])[1]);

        $dt2->addHours(explode(':',$data['start'])[0]);
        $dt2->addMinutes(explode(':',$data['start'])[1]);

        $gap = date_diff($dt1,$dt2);
        $h = $gap->h;
        $m = $gap->i;
        $gap = $m/60 + $h;
        $data['gap'] = $gap;
        $data['token'] = sha1(time());
        $data['annee_id'] = $this->getAnneeId();
        $item = Emploi::create($data);
        return response()->json('ok');
    }

    public function getCours(){
        $data = request()->all();
        $cours = Cours::where('filiere_id',$data['filiere_id'])->where('semestre',$data['semestre'])->get();
        $items = CoursResource::collection($cours);
        return response()->json($items);
    }

    public function setPointage(){
        $data = request()->all();
        if(!$data['dt']){
            $data['dt'] = new DateTime();
        }
        $data['mois_id'] = \Carbon\Carbon::parse($data['dt'])->month;
        $data['token'] = sha1(time());
        $emploi = Emploi::find($data['emploi_id']);
        if(!$emploi){
            return response()->json('Donnees invalides',403);
        }
        $absents = $data['absents'];
        unset($data['absents']);
        $data['enseignant_id'] = $emploi->enseignant_id;
        $data['day'] = $emploi->day;
        $data['start'] = $emploi->start;
        $data['end'] = $emploi->end;
        $data['pu'] = $emploi->pu;
        $data['gap'] = $emploi->gap;
        $data['semestre'] = $emploi->semestre;
        $data['annee_id'] = $emploi->annee_id;
        $data['niveau_id'] = $emploi->niveau_id;
        $data['filiere_id'] = $emploi->filiere_id;
        $data['cours_id'] = $emploi->cours_id;
        $data['matiere_id'] = $emploi->matiere_id;
        $data['user_id'] = auth()->user()->id;
        $pointage = Pointage::create($data);
        unset($data['pv']);
        unset($data['pu']);
        $dt = Carbon::parse($data['dt']);
        $data['mois_id'] = $dt->month;
        foreach($absents as $i){
            $data['token'] = sha1($i.time());
            $data['pointage_id'] = $pointage->id;
            $data['inscription_id'] = $i;
            $et = Inscription::find($i);
            $data['etudiant_id'] = $et->etudiant_id;
            $absence = Absence::create($data);
        }
        return response()->json($pointage);
    }

    public function create(){
        $filieres = Filiere::all();
        $matieres = Matiere::all();
        $enseignants = Enseignant::all();
        $salles = Salle::all();
        //$items = Emploi::where('annee_id',$this->getAnneeId())->get();
        $items = Emploi::all();
        $items = EmploiResource::collection($items);

        return response()->json([
            'filieres'=>$filieres,
            'matieres'=>$matieres,
            'salles'=>$salles,
            'emplois'=>$items,
            'enseignants'=>EnseignantResource::collection($enseignants),
        ]);
    }

    public function show($token){
        $emploi = Emploi::where('token',$token)->first();
        $emploi = new EmploiResource($emploi);
        $inscriptions = Inscription::where('filiere_id',$emploi->filiere_id)->where('niveau_id',$emploi->niveau_id)->get();
        $pointages = Pointage::where('emploi_id',$emploi->id)->get();
        return response()->json([
            'emploi'=>$emploi,
            'pointages'=>PointageResource::collection($pointages),
            'inscriptions'=>InscriptionResource::collection($inscriptions),
        ]);
    }
}
