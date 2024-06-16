<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EcolageResource;
use App\Http\Resources\InscriptionResource;
use App\Http\Resources\TarifResource;
use App\Models\Ecolage;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\Mois;
use App\Models\Tarif;

class EcolageController extends Controller
{
    public function index(){
        $items = Ecolage::all();
        $items = EcolageResource::collection($items);
        return response()->json($items);
    }

    public function store(){
        $data = request()->all();
        $inscription = Inscription::find($data['inscription_id']);
        $data['etudiant_id'] = $inscription->etudiant_id;
        $data['filiere_id'] = $inscription->filiere_id;
        $data['niveau_id'] = $inscription->niveau_id;
        $data['annee_id'] = $inscription->annee_id;
        $data['token'] = sha1(time());
        $data['user_id'] = auth()->user()->id;
        $ecolage = Ecolage::create($data);
        return response()->json($ecolage);
    }

    public function show($token){
    }

    public function create(){
        $inscriptions = Inscription::all();
        $inscriptions = InscriptionResource::collection($inscriptions);
        $mois = Mois::all();
        $tarifs = Tarif::all();
        return response()->json([
            'mois'=>$mois,
            'tarifs'=>$tarifs,
            'inscriptions'=>$inscriptions,
        ]);
    }
}
