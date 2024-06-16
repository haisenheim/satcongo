<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ExtendedController;
use App\Http\Resources\EnseignantResource;
use App\Http\Resources\EtudiantResource;
use App\Models\Diplome;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Pay;

class EnseignantController extends ExtendedController
{

    public function index(){
        $items = Enseignant::orderBy('last_name','ASC')->get();
        return response()->json(EnseignantResource::collection($items));
    }

    public function store(){
        $data = json_decode(request()->enseignant,true);
        //$photo = $data['photo'];
        $photo = request()->photo;
        $token = sha1(time().auth()->user()->id);
        $data['token'] = $token;
        $data['user_id'] = auth()->user()->id;
        if($photo){
            $data['image_uri'] = $this->entityImgCreate($photo,'etudiants',$token);
        }
        unset($data['photo']);
        $item = Enseignant::create($data);
        $item->matricule = "DGC".str_pad($item->id,6,"0",STR_PAD_LEFT);
        $item->save();
        return response()->json('ok');
    }

    public function create(){
        $pays = Pay::all();
        $diplomes = Diplome::all();

        return response()->json([
            'pays'=>$pays,
            'diplomes'=>$diplomes,
        ]);
    }
}
