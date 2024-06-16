<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tranche;

class TrancheController extends Controller
{

    public function index(){
        $items = Tranche::all();
        return response()->json($items);
    }

    public function store(){
        $data = json_decode(request()->tranche,true);
        $item = Tranche::create($data);
        return response()->json('ok');
    }

    public function create(){}
}
