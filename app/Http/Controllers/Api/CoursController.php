<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CoursResource;
use App\Models\Cours;
use App\Models\Filiere;
use App\Models\Matiere;

class CoursController extends Controller
{

    public function index(){
        $items = Cours::all();
        $items = CoursResource::collection($items);
        return response()->json($items);
    }

    public function store(){
        $data = json_decode(request()->cours,true);
        $data['token'] = sha1(time());
        switch($data['semestre']){
            case 1:
            case 2:
                $data['niveau_id'] = 1;
                break;
                case 3:
                case 4:
                    $data['niveau_id'] = 2;
                    break;
                case 5:
                case 6:
                    $data['niveau_id'] = 3;
                    break;
                default:
                    $data['niveau_id'] = 0;
        }
        Cours::create($data);
        return response()->json('ok');
    }

    public function show($token){

    }

    public function create(){
        $matieres = Matiere::all();
        $filieres = Filiere::all();
        return response()->json(
            [
                'filieres'=>$filieres,
                'matieres'=>$matieres,
            ]
        );
    }
}
