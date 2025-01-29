<?php

namespace App\Http\Controllers\Comptable;

use App\Http\Controllers\Controller;
use App\Models\Dossier;
use Illuminate\Http\Request;

class DossierController extends Controller
{
    //

    public function index(){
        $items = Dossier::orderBy('created_at','DESC')->get();
        return view('Comptable/Dossiers/index',compact('items'));
    }

    public function show($token){
        $item = Dossier::where('token',$token)->first();
        return view('Comptable/Dossiers/show',compact('item'));
    }

    public function close($token){
        $item = Dossier::where('token',$token)->first();
        $item->closed_at = new \DateTime();
        //$item->closed_by = auth()->user()->id;
        $item->save();
        return back();
    }
}
