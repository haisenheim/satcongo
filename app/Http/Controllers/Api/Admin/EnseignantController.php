<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ExtendedController;
use App\Http\Resources\EnseignantResource;
use App\Http\Resources\EtudiantResource;
use App\Models\Diplome;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Pay;
use App\Models\User;

class EnseignantController extends ExtendedController
{

    public function index(){
        $items = Enseignant::orderBy('last_name','ASC')->get();
        return response()->json(EnseignantResource::collection($items));
    }

    public function store(){
        $data = json_decode(request()->enseignant,true);
        $photo = request()->photo;
        $token = sha1(time().auth()->user()->id);
        $data['token'] = $token;
        $data['created_by'] = auth()->user()->id;
        if($photo){
            $data['image_uri'] = $this->entityImgCreate($photo,'etudiants',$token);
        }
        unset($data['photo']);
        $item = Enseignant::create($data);
        $item->matricule = "DGC".str_pad($item->id,6,"0",STR_PAD_LEFT);
        $user = new User();
        $user->name = $item->name;
        $user->email = $item->email;
        $user->role_id = 2;
        $user->password = bcrypt($item->email);
        $user->enseignant_id = $item->id;
        $user->save();
        $item->user_id = $user->id;
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
