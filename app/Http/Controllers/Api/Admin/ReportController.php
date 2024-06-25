<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ExtendedController;
use App\Http\Resources\EmploiResource;
use App\Http\Resources\EnseignantResource;
use App\Http\Resources\InscriptionResource;
use App\Http\Resources\PointageResource;
use App\Models\Absence;
use App\Models\Ecolage;
use App\Models\Emploi;
use App\Models\Enseignant;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\Mois;
use App\Models\Pointage;
use App\Models\Tarif;

class ReportController extends ExtendedController
{

    public function getReportByInscriptionId($id){
        $mois = Mois::all();
        $mois = $mois->pluck('name');
        $inscription = Inscription::find($id);
        $tarif = Tarif::where('filiere_id',$inscription->filiere_id)->where('niveau_id',$inscription->niveau_id)->first();
        $ecolages = $inscription->ecolages;
        $absences = $inscription->absences;
        $grp = $ecolages->groupBy(function($item){
            return $item->mois->name;
        });

        $grps = $absences->groupBy(function($item){
            return $item->mois->name;
        });

        $abs = $grps->map(function($gp,$k){
            $t = $gp->reduce(function($c,$item){
                return $c + $item->gap;
            });
            return $t;

        });



        $items = $grp->map(function($gp,$k){
            $t = $gp->reduce(function($c,$item){
                return $c + $item->montant;
            });
            $count = $gp->count();
            $eco = $gp[0];
            $tarif = Tarif::where('filiere_id',$eco->filiere_id)->where('niveau_id',$eco->niveau_id)->first();
            $m = $tarif?$tarif->mensualite:80000;
            $r = $t>=$m?0:$m-$t;
            return [
                'mois'=>$k,
                'total'=>number_format($t,0,',','.'),
                't'=>$t,
                'reste'=>number_format($r,0,',','.'),
                'r'=>$r,
                'montant'=>$m,
                'count'=>$count,
            ];
        });
        $data = $items->values();
        //$abs = $elts->values();
        $tr = 0;
        $somme = 0;
        foreach($data as $d){
            $tr = $tr + $d['r'];
            $somme = $somme + $d['t'];
        }

        //dd($elts['Juin']);

        $elts = $mois->map(function($elt,$cl)use($data,$tarif,$abs){
            //$ab = isset($abs[$elt])?$abs[$elt]:0;
            $keys = array_keys($abs->toArray());
            $ab = in_array($elt,$keys)?$abs[$elt]:0;
            $return = [
                'mois'=>$elt,
                'absences'=>$ab,
                'total'=>0,
                't'=>0,
                'reste'=>number_format($tarif?$tarif->mensualite:80000,0,',','.'),
                'r'=>$tarif?$tarif->mensualite:80000,
                'montant'=>0,
                'count'=>0,
            ];
            foreach($data as $d){
                if($elt == $d['mois']){
                    $ab = in_array($elt,$keys)?$abs[$elt]:0;
                    $d['absences'] = $ab;
                    //dd($d);
                    $return = $d;
                }
            }

            return $return;
        });
        //dd($elts);
        $v = [];
        $r = [];
        foreach($elts as $elt){
            $v[] = $elt['t'];
            $r[] = $elt['r'];
        }
        return response()->json([
            'groups'=>$elts,
            'labels'=>$mois,
            'v'=>$v,
            'r'=>$r,
            'somme'=>number_format($somme,0,',','.'),
            'reste'=>number_format($tr,0,',','.'),
        ]);
    }

    public function getReportByMonth($id){
        $filieres = Filiere::all();
        $filieres = $filieres->pluck('name');
        //$inscription = Inscription::find($id);
        //$tarif = Tarif::where('filiere_id',$inscription->filiere_id)->where('niveau_id',$inscription->niveau_id)->first();
        $ecolages = Ecolage::where('mois_id',$id)->where('annee_id',$this->getAnneeId())->get();
        $absences = Absence::where('mois_id',$id)->where('annee_id',$this->getAnneeId())->get();
        $grp = $ecolages->groupBy(function($item){
            return $item->filiere->name;
        });

        $grps = $absences->groupBy(function($item){
            return $item->filiere->name;
        });

        $abs = $grps->map(function($gp,$k){
            $t = $gp->reduce(function($c,$item){
                return $c + $item->gap;
            });
            return $t;

        });


        //dd($grp);
        $items = $grp->map(function($gp,$k){
            $t = $gp->reduce(function($c,$item){
                return $c + $item->montant;
            });
            $count = $gp->count();
            $eco = $gp[0];
            $tarif = Tarif::where('filiere_id',$eco->filiere_id)->where('niveau_id',$eco->niveau_id)->first();
            $m = $tarif?$tarif->mensualite:80000;
            $r = $t>=$m?0:$m-$t;
            return [
                'mois'=>$k,
                'total'=>number_format($t,0,',','.'),
                't'=>$t,
                //'reste'=>number_format($r,0,',','.'),
               // 'r'=>$r,
                'montant'=>$m,
                //'count'=>$count,
            ];
        });
        $data = $items->values();
        //dd($data);
        //$abs = $elts->values();


        //dd($elts['Juin']);

        $elts = $filieres->map(function($elt,$cl)use($data,$abs){
            //$ab = isset($abs[$elt])?$abs[$elt]:0;
            $keys = array_keys($abs->toArray());
            $ab = in_array($elt,$keys)?$abs[$elt]:0;
            $return = [
                'mois'=>$elt,
                'absences'=>$ab,
                'total'=>0,
                't'=>0,
                //'reste'=>number_format($tarif?$tarif->mensualite:80000,0,',','.'),
                //'r'=>$tarif?$tarif->mensualite:80000,
                'montant'=>0,
                'count'=>0,
            ];
            foreach($data as $d){
                if($elt == $d['mois']){
                    $ab = in_array($elt,$keys)?$abs[$elt]:0;
                    $d['absences'] = $ab;
                    //dd($d);
                    $return = $d;
                }
            }
            return $return;
        });
       // dd($elts);
        $v = [];
        //$r = [];
        foreach($elts as $elt){
            $v[] = $elt['t'];
           // $r[] = $elt['r'];
        }
        return response()->json([
            'groups'=>$elts,
            'labels'=>$filieres,
            'v'=>$v,
            //'somme'=>number_format($somme,0,',','.'),
            //'reste'=>number_format($tr,0,',','.'),
        ]);
    }

    public function getReportByEnseignantId($id){
        $mois = Mois::all();
        $mois = $mois->pluck('name');
        $enseignant = Enseignant::find($id);
        $pointages = Pointage::orderBy('dt','DESC')->where('annee_id',$this->getAnneeId())->where('enseignant_id',$id)->get();
        $emplois = Emploi::where('enseignant_id',$id)->get();

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
        $items = Inscription::where('annee_id',$this->getAnneeId())->get();
        $mois = Mois::all();
        $filieres = Filiere::all();
        return response()->json([
            'inscriptions'=>InscriptionResource::collection($items),
            'mois'=>$mois,
            'filieres'=>$filieres,
        ]);
    }

    public function init(){

        $mois = Mois::all();
        $filieres = Filiere::all();
        $enseignants = EnseignantResource::collection(Enseignant::all());
        return response()->json([
            'mois'=>$mois,
            'filieres'=>$filieres,
            'enseignants'=>$enseignants,
        ]);
    }



}
