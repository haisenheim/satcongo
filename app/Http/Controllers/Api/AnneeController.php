<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AnneeResource;
use App\Models\Annee;

class AnneeController extends Controller
{

    public function index(){
        $items = AnneeResource::collection(Annee::orderBy('created_at','DESC')->get());
        return response()->json($items);
    }

    public function store(){
        $data = request()->all();
        $data['end'] = $data['start'] + 1;
        $data['token'] = sha1(time());
        $annees = Annee::all();
        foreach($annees as $an){
            $an->active = 0;
            $an->save();
        }
        $item = Annee::create($data);
        return response()->json('ok');
    }

    public function create(){}
}
