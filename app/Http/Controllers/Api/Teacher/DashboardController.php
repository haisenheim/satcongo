<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\ExtendedController;
use App\Http\Resources\EmploiResource;
use App\Http\Resources\ExamenResource;
use App\Http\Resources\PointageResource;
use App\Models\Emploi;
use App\Models\Examen;
use App\Models\Mois;
use App\Models\Pointage;

class DashboardController extends ExtendedController
{
    public function index(){
        $id = auth()->user()->enseignant_id;
        $mois = Mois::all();
        $mois = $mois->pluck('name');
        $pointages = Pointage::orderBy('dt','DESC')->where('annee_id',$this->getAnneeId())->where('enseignant_id',$id)->get();
        $grp = $pointages->groupBy(function($item){
            return $item->mois->name;
        });
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
        $honoraires = $items->values();
        $items = Emploi::where('enseignant_id',auth()->user()->enseignant_id)->get();
        $emplois = EmploiResource::collection($items);

        $cours_ids = $emplois->pluck('cours_id');
        $items = Examen::orderBy('created_at','DESC')
                     ->where('annee_id',$this->getAnneeId())
                     ->whereIn('cours_id',$cours_ids)
                     ->get();
        $examens = ExamenResource::collection($items);
        $pointages = PointageResource::collection($pointages);
         return response()->json([
            'examens'=>$examens,
            'emplois'=>$emplois,
            'honoraires'=>$honoraires,
            'pointages'=>$pointages,
         ]);
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
}
