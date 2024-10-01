<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use App\Models\Agence;
use App\Models\Arrondissement;
use App\Models\Caisse;
use App\Models\Departement;
use App\Models\Village;
use App\Models\Cooperative;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function getAgencesByVilleId(){
        $id = request()->id;
        $items = Agence::where('ville_id',$id)->get();
        return response()->json($items);
    }

    public function getCaissesByAgenceId(){
        $id = request()->id;
        $items = Caisse::where('agence_id',$id)->get();
        return response()->json($items);
    }

    
}
