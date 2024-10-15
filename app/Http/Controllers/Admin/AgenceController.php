<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agence;
use App\Models\Ville;
use App\Models\Departement;
use App\Models\Libelle;
use App\Models\LibelleAgence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AgenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Agence::all();
        $villes = Ville::all();
        $departements = Departement::all();
        $libelles = Libelle::where('active',1)->get();
        return view('/Admin/Agences/index')->with(compact('items','villes','departements','libelles'));
    }


    public function setLibelle(){
        
       LibelleAgence::updateOrCreate([
        'libelle_id'=>request()->libelle_id,
        'agence_id'=>request()->agence_id,],
        [
            'libelle_id'=>request()->libelle_id,
            'agence_id'=>request()->agence_id,
        ]
    );
       Session::flash('success','Enregistrement effectué avec succès!');
        return back();
    }






    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Agence::create($data);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projet  $projet
     * @return \Illuminate\Http\Response
     */
	public function show($id)
	{
		$item = Agence::find($id);
        $libelles = Libelle::where('active',1)->get();
        return view('/Admin/Agences/show')->with(compact('item','libelles'));
	}

    public function  enable($id){
        $item = Agence::find($id);
        $item->active = 1;
        $item->save();
        return back();
    }

    public function  disable($id){
        $item = Agence::find($id);
        $item->active = 0;
        $item->save();
        return back();
    }

    


}
