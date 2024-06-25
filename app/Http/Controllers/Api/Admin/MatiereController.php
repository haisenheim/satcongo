<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matiere;

class MatiereController extends Controller
{

    public function index(){
        $items = Matiere::all();
        return response()->json($items);
    }

    public function store(){
        $data = json_decode(request()->matiere,true);
        $item = Matiere::create($data);
        return response()->json('ok');
    }

    public function create(){}
}
