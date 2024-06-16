<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TarifResource;
use App\Models\Filiere;
use App\Models\Tarif;

class TarifController extends Controller
{

    public function index(){
        $items = Tarif::all();
        $items = TarifResource::collection($items);
        $filieres = Filiere::all();
        return response()->json(['tarifs'=>$items,'filieres'=>$filieres]);
    }

    public function store(){
        $data = request()->all();
        $tarifs = Tarif::all();
        $filiere_id = $data['filiere_id'];
        $niveau_id = $data['niveau_id'];
        $tarif = null;
        foreach($tarifs as $t){
            if($t->filiere_id == $data['filiere_id'] && $t->niveau_id == $data['niveau_id']){
                $tarif = $t;
                break;
            }
        }
        if($tarif){
            $tarif->mensualite = $data['mensualite'];
            $tarif->inscription = $data['inscription'];
            $tarif->save();
        }else{
            $item = Tarif::create($data);
        }

        return response()->json('ok');
    }

    public function show($token){
    }

    public function create(){}
}
