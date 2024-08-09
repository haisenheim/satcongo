<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\ExtendedController;
use App\Http\Resources\ChapterResource;
use App\Http\Resources\CoursResource;
use App\Http\Resources\EmploiResource;
use App\Http\Resources\ExerciceResource;
use App\Http\Resources\InscriptionResource;
use App\Http\Resources\PointageResource;
use App\Models\Absence;
use App\Models\Cours;
use App\Models\Emploi;
use App\Models\Enseignant;
use App\Models\Exercice;
use App\Models\Inscription;
use App\Models\Mois;
use App\Models\Plan;
use App\Models\PlanItem;
use App\Models\Pointage;
use Carbon\Carbon;
use DateTime;

class EmploiController extends ExtendedController
{

    public function index(){
        $items = Emploi::where('enseignant_id',auth()->user()->enseignant_id)->get();
        $items = EmploiResource::collection($items);
        return response()->json($items);
    }

    public function store(){
    }

    public function getCours(){
        $data = request()->all();
        $cours = Cours::where('filiere_id',$data['filiere_id'])->where('semestre',$data['semestre'])->get();
        $items = CoursResource::collection($cours);
        return response()->json($items);
    }


    public function setChapter(){
        $item = request()->all();

        $data['token'] = sha1(time());
        $emploi = Emploi::find($item['emploi_id']);
        if(!$emploi){
            return response()->json('Donnees invalides',403);
        }
        $data['enseignant_id'] = $emploi->enseignant_id;
        $data['semestre'] = $emploi->semestre;
        $data['annee_id'] = $emploi->annee_id;
        $data['niveau_id'] = $emploi->niveau_id;
        $data['filiere_id'] = $emploi->filiere_id;
        $data['cours_id'] = $emploi->cours_id;
        $data['matiere_id'] = $emploi->matiere_id;
        $data['emploi_id'] = $item['emploi_id'];
        $plan = $emploi->plan;
        if(!$plan){
           $plan = Plan::create($data);
        }
        $item['plan_id'] = $plan->id;
        $item['cours_id'] = $plan->cours_id;
        $item['matiere_id'] = $plan->matiere_id;
        $chapter = PlanItem::create($item);
        return response()->json($chapter);
    }

    public function setExercice(){
        $data = json_decode(request()->exercice,true);
        $token = sha1(time());

        if(request()->pdf){
            $data['pdf_uri'] = $this->entityDocumentCreate(request()->pdf,'exercices',$token);
        }
        $emploi = Emploi::find($data['emploi_id']);
        if(!$emploi){
            return response()->json('Donnees invalides',403);
        }
        $data['niveau_id'] = $emploi->niveau_id;
        $data['filiere_id'] = $emploi->filiere_id;
        $data['cours_id'] = $emploi->cours_id;
        $data['matiere_id'] = $emploi->matiere_id;
        $item = Exercice::create($data);
        return response()->json('ok');
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

    public function getHonoraires(){
        $mois = Mois::all();
        $mois = $mois->pluck('name');
        $id = auth()->user()->enseignant_id;
        $pointages = Pointage::orderBy('dt','DESC')->where('annee_id',$this->getAnneeId())->where('enseignant_id',$id)->get();
        $grp = $pointages->groupBy(function($item){
            return $item->mois->name;
        });

        $mats = $pointages->groupBy(function($it){
            return $it->matiere->name;
        });

        $mats = $mats->map(function($m,$key){
            $s = $m->reduce(function($c,$i){
                return $c + $i->gap*$i->pu;
            });
            return $s;
        });

        $filieres = $pointages->groupBy(function($it){
            return $it->filiere->code ."-".$it->semestre;
        });

        $filieres = $filieres->map(function($m,$key){
            $s = $m->reduce(function($c,$i){
                return $c + $i->gap*$i->pu;
            });
            return $s;
        });

        $_data = [
            'matieres'=>[
                'labels'=>$mats->keys(),
                'data'=>$mats->values(),
            ],
            'filieres'=>[
                'labels'=>$filieres->keys(),
                'data'=>$filieres->values(),
            ]
        ];
        $pointages = PointageResource::collection($pointages);
        $items = $grp->map(function($gp,$k){
            $thono = $gp->reduce(function($c,$item){
                return $c + $item->gap*$item->pu;
            });
            $theures = $gp->reduce(function($c,$item){
                return $c + $item->gap;
            });

            return [
                'mois'=>$k,
                'heures'=>$theures,
                '_heures'=>$theures,
                'honoraires'=>number_format($thono,0,',','.'),
                '_honoraires'=>$thono,
            ];
        });
        $data = $items->values();

        $v = [];
        $r = [];
        foreach($data as $elt){
            $v[] = $elt['_heures'];
            $r[] = $elt['_honoraires'];
        }

        return response()->json([
            'groups'=>$data,
            'labels'=>$mois,
            'heures'=>$v,
            'honoraires'=>$r,
            'pointages'=>$pointages,
            'data'=>$_data,
        ]);
    }

    public function _getHonoraires(){
        $mois = Mois::all();
        $mois = $mois->pluck('name');
        $id = auth()->user()->enseignant_id;
        $enseignant = Enseignant::find($id);
        $pointages = Pointage::orderBy('dt','DESC')->where('annee_id',$this->getAnneeId())->where('enseignant_id',$id)->get();
        //$emplois = Emploi::where('enseignant_id',$id)->get();

        //dd( $pointages);

        $grp = $pointages->groupBy(function($item){
            return $item->mois->name;
        });

        $mats = $pointages->groupBy(function($it){
            return $it->matiere->name;
        });

        $mats = $mats->map(function($m,$key){
            $s = $m->reduce(function($c,$i){
                return $c + $i->gap*$i->pu;
            });
            return $s;
        });

        $filieres = $pointages->groupBy(function($it){
            return $it->filiere->code ."-".$it->semestre;
        });

        $filieres = $filieres->map(function($m,$key){
            $s = $m->reduce(function($c,$i){
                return $c + $i->gap*$i->pu;
            });
            return $s;
        });

        $_data = [
            'matieres'=>[
                'labels'=>$mats->keys(),
                'data'=>$mats->values(),
            ],
            'filieres'=>[
                'labels'=>$filieres->keys(),
                'data'=>$filieres->values(),
            ]
        ];

       // dd($data);

        $pointages = PointageResource::collection($pointages);
        //dd($pointages);

        $items = $grp->map(function($gp,$k){
            $thono = $gp->reduce(function($c,$item){
                return $c + $item->gap*$item->pu;
            });
            $theures = $gp->reduce(function($c,$item){
                return $c + $item->gap;
            });

            return [
                'mois'=>$k,
                'heures'=>$theures,
                '_heures'=>$theures,
                'honoraires'=>number_format($thono,0,',','.'),
                '_honoraires'=>$thono,
                //'matieres'=>$mats,
            ];
        });
        $data = $items->values();

        $v = [];
        $r = [];
        foreach($data as $elt){
            $v[] = $elt['_heures'];
            $r[] = $elt['_honoraires'];
        }

        return response()->json([
            'groups'=>$data,
            'labels'=>$mois,
            'heures'=>$v,
            'honoraires'=>$r,
            'emplois'=>EmploiResource::collection($emplois),
            'pointages'=>$pointages,
            'data'=>$_data,
        ]);
    }

    public function create(){

    }

    public function setInProgress($id){
        $chapter = PlanItem::find($id);
        $chapter->in_progress_at = new \DateTime();
        $chapter->save();
        return response()->json('ok');
    }

    public function setCompleted($id){
        $chapter = PlanItem::find($id);
        $chapter->completed_at = new \DateTime();
        $chapter->save();
        return response()->json('ok');
    }

    public function show($token){
        $emploi = Emploi::where('token',$token)->first();
        $emploi = new EmploiResource($emploi);
        $inscriptions = Inscription::where('filiere_id',$emploi->filiere_id)->where('niveau_id',$emploi->niveau_id)->get();
        $pointages = Pointage::where('emploi_id',$emploi->id)->get();
        $chapters = PlanItem::where('emploi_id',$emploi->id)->get();
        $exercices = Exercice::where('emploi_id',$emploi->id)->get();
        return response()->json([
            'emploi'=>$emploi,
            'pointages'=>PointageResource::collection($pointages),
            'inscriptions'=>InscriptionResource::collection($inscriptions),
            'chapters'=>ChapterResource::collection($chapters),
            'exercices'=>ExerciceResource::collection($exercices),
        ]);
    }
}
