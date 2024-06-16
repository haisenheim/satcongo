<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EcolageResource;
use App\Http\Resources\EtudiantResource;
use App\Http\Resources\InscriptionResource;
use App\Models\Ecolage;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Inscription;
use App\Models\Tarif;

class InscriptionController extends Controller
{

    public function index(){
        $items = Inscription::orderBy('created_at','DESC')->get();
        $items = InscriptionResource::collection($items);
        return response()->json($items);
    }

    public function store(){
        $data = json_decode(request()->inscription,true);
        $token = sha1(time().auth()->user()->id);
        $data['token'] = $token;
        $data['user_id'] = auth()->user()->id;
        $item = Inscription::create($data);
        return response()->json('ok');
    }

    public function create(){
        $etudiants = Etudiant::all();
        $filieres = Filiere::all();
        return response()->json([
            'students'=>EtudiantResource::collection($etudiants),
            'filieres'=>$filieres,
        ]);
    }

    public function getEcolages($id){
        $items = Ecolage::where('inscription_id',$id)->get();
        $inscription = Inscription::find($id);
        $tarif = Tarif::where('filiere_id',$inscription->filiere_id)->where('niveau_id',$inscription->niveau_id)->first();
        return response()->json([
            'ecolages'=>EcolageResource::collection($items),
            'montant'=>$tarif?$tarif->mensualite:0,
        ]);
    }
}
