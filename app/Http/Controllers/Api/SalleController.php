<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Salle;

class SalleController extends Controller
{

    public function index(){
        $items = Salle::all();
        return response()->json($items);
    }

    public function store(){
        $data = json_decode(request()->salle,true);
        $item = Salle::create($data);
        return response()->json('ok');
    }

    public function create(){}
}
