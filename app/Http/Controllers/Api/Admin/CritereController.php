<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FiliereResource;
use App\Models\Critere;

class CritereController extends Controller
{

    public function index(){
        $criteres = Critere::all();
        return response()->json($criteres);
    }

    public function store(){
        $data = request()->all();
        Critere::create($data);
        return response()->json('ok');
    }

    public function create(){}
}
