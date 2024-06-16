<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ExtendedController;
use App\Http\Resources\CoursResource;
use App\Http\Resources\EvaluationResource;
use App\Http\Resources\ExamenResource;
use App\Http\Resources\InscriptionResource;
use App\Http\Resources\NoteResource;
use App\Models\Cours;
use App\Models\Emploi;
use App\Models\Evaluation;
use App\Models\EvaluationPeriodicite;
use App\Models\EvaluationType;
use App\Models\Examen;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\Mois;
use App\Models\Note;
use Illuminate\Support\Facades\DB;

class EvaluationController extends ExtendedController
{

    public function index(){
        $items = EvaluationResource::collection(Evaluation::orderBy('created_at','DESC')->get());
        $mois = Mois::all();
        $types = EvaluationType::all();
        $periodes = EvaluationPeriodicite::all();

        return response()->json([
           'evaluations'=>$items,
           'mois'=>$mois,
           'types'=>$types,
           'periodes'=>$periodes,
        ]);
    }

    public function getExams(){
        $evaluations = EvaluationResource::collection(Evaluation::orderBy('created_at','DESC')->get());
        $mois = Mois::all();
        $filieres = Filiere::all();
        $types = EvaluationType::all();
        $periodes = EvaluationPeriodicite::all();
        $examens = ExamenResource::collection(Examen::orderBy('created_at','DESC')->get());
        $cours = CoursResource::collection(Cours::all());
        return response()->json([
           'evaluations'=>$evaluations,
           'examens'=>$examens,
           'mois'=>$mois,
           'types'=>$types,
           'periodes'=>$periodes,
           'cours'=>$cours,
           'filieres'=>$filieres,
        ]);
    }

    public function getExam($token){
        $examen = Examen::where('token',$token)->first();
        $notes = Note::where('examen_id',$examen->id)->get();
        $niveau_id = $examen->cours->niveau_id;

        $inscrits = Inscription::where('niveau_id',$niveau_id)
                        ->where('filiere_id',$examen->filiere_id)
                        ->where('annee_id',$this->getAnneeId())
                        ->get();
        return response()->json([
            'examen'=>new ExamenResource($examen),
            'notes'=>NoteResource::collection($notes),
            'inscrits'=>InscriptionResource::collection($inscrits),
        ]);
    }

    public function store(){
        $data = request()->all();
        $data['token'] = sha1(time());
        Evaluation::create($data);
        return response()->json('ok');
    }

    public function getNotes(){
        $annee_id = $this->getAnneeId();
        $notes = DB::table('notes')
        ->join('etudiants','notes.etudiant_id','=','etudiants.id')
        ->join('filieres','filieres.id','=','notes.filiere_id')
        ->join('matieres','matieres.id','=','notes.matiere_id')
        ->join('evaluation_types','evaluation_types.id','=','notes.type_id')
        ->join('mois','mois.id','=','notes.mois_id')
        ->join('evaluation_periodicites','evaluation_periodicites.id','=','notes.periodicite_id')
        ->select(
                   DB::raw('concat(first_name,"  ",last_name," - ",matricule) as etudiant'),
                    //'etudiants.matricule as matricule',
                    'niveau_id',
                    'filieres.code as filiere',
                    'semestre',
                    'note',
                    'pourcentage',
                    'evaluation_types.name as activite',
                    'mois.name as mois',
                    'evaluation_periodicites.name as periode',
                    'matieres.name as matiere'
                    )
        ->get();
        return response()->json($notes);
    }

    public function storeNotes(){
        $notes = request()->all();
        //dd($notes[0]['cours_id']);
        $emploi = Emploi::where('cours_id',$notes[0]['cours_id'])->where('annee_id',$this->getAnneeId())->first();
        //dd($emploi);
        if($emploi){
            foreach($notes as $note){
                $note['token'] = sha1(time().$note['inscription_id']);
                $note['enseignant_id'] = $emploi?$emploi->enseignant_id:0;
                $note['emploi_id'] = $emploi?$emploi->id:0;
                $inscription = Inscription::find($note['inscription_id']);
                $note['etudiant_id'] = $inscription->etudiant_id;
                Note::create($note);
            }
        }else{
            return response()->json('Action impossible! Ce cours n\'existe pas dans l\'emploi de temps',407);
        }

        return response()->json('ok');
    }

    public function storeExams(){
        $data = request()->all();
        $data['token'] = sha1(time());
        $evaluation = Evaluation::find($data['evaluation_id']);
        $data['type_id'] = $evaluation->type_id;
        $data['periodicite_id'] = $evaluation->periodicite_id;
        $data['pourcentage'] = $evaluation->pourcentage;
        $data['annee_id'] = $this->getAnneeId();
        $data['user_id'] = auth()->user()->id;
        $cours = Cours::find($data['cours_id']);
        $data['matiere_id'] = $cours->matiere_id;
        switch($data['semestre']){
            case 1:
            case 2:
                $data['niveau_id'] = 1;
                break;
                case 3:
                case 4:
                    $data['niveau_id'] = 2;
                    break;
                case 5:
                case 6:
                    $data['niveau_id'] = 3;
                    break;
                default:
                    $data['niveau_id'] = 0;
        }
        Examen::create($data);
        return response()->json('ok');
    }

    public function create(){}
}
