<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\EtudiantResource;
use App\Http\Resources\TuteurResource;
use App\Models\Etudiant;
use App\Models\Tuteur;

class TuteurController extends Controller
{

    public function index(){
        $items = Tuteur::all();
        return response()->json($items);
    }

    public function store(){
        $data = json_decode(request()->tuteur,true);
        $data['token'] = sha1(time());
        $data['user_id'] = auth()->user()->id;
        $item = Tuteur::create($data);
        return response()->json('ok');
    }

    public function show($token){
        $tuteur = Tuteur::where('token',$token)->first();
        $etudiants = Etudiant::where('tuteur_id',$tuteur->id)->get();
        return response()->json(
            [
                'tuteur'=>$tuteur,
                'etudiants'=>EtudiantResource::collection($etudiants)
            ]
        );
    }

    public function create(){}
}
