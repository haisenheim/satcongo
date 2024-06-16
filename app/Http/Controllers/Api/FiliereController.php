<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FiliereResource;
use App\Models\Filiere;

class FiliereController extends Controller
{

    public function index(){
        $filieres = Filiere::all();
        $filieres = FiliereResource::collection($filieres);
        return response()->json($filieres);
    }

    public function store(){
        $data = json_decode(request()->filiere,true);
        $filieres = Filiere::create($data);
        return response()->json('ok');
    }

    public function create(){}
}
