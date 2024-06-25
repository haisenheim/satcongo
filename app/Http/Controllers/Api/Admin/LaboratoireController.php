<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laboratoire;

class LaboratoireController extends Controller
{

    public function index(){
        $items = Laboratoire::all();
        return response()->json($items);
    }

    public function store(){
        $data = json_decode(request()->laboratoire,true);
        $item = Laboratoire::create($data);
        return response()->json('ok');
    }

    public function create(){}
}
