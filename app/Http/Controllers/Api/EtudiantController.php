<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ExtendedController;
use App\Http\Resources\EtudiantResource;
use App\Models\Diplome;
use App\Models\Etudiant;
use App\Models\Pay;
use App\Models\Tuteur;

class EtudiantController extends ExtendedController
{

    public function index(){
        $items = Etudiant::orderBy('last_name','ASC')->get();
        return response()->json(EtudiantResource::collection($items));
    }

    public function store(){
        $data = json_decode(request()->etudiant,true);
        //$photo = $data['photo'];
        $photo = request()->photo;
        $token = sha1(time().auth()->user()->id);
        $data['token'] = $token;
        $data['user_id'] = auth()->user()->id;
        if($photo){
            $data['image_uri'] = $this->entityImgCreate($photo,'etudiants',$token);
        }
        unset($data['photo']);
        $item = Etudiant::create($data);
        $item->matricule = "DGC".str_pad($item->id,6,"0",STR_PAD_LEFT);
        $item->save();
        return response()->json('ok');
    }

    public function create(){
        $pays = Pay::all();
        $tuteurs = Tuteur::all();
        $diplomes = Diplome::all();

        return response()->json([
            'pays'=>$pays,
            'tuteurs'=>$tuteurs,
            'diplomes'=>$diplomes,
        ]);
    }
}
