<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Caisse;
use App\Models\Agence;
use App\Models\CaisseCompte;
use App\Models\Compte;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CaisseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Caisse::all();
        $villes = Ville::all();
        return view('/Admin/Caisses/index')->with(compact('items','villes'));
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
        Caisse::create($data);
        return back();
    }


    public function  enable($id){
        $item = Caisse::find($id);
        $item->active = 1;
        $item->save();
        return back();
    }

    public function  disable($id){
        $item = Caisse::find($id);
        $item->active = 0;
        $item->save();
        return back();
    }

    public function addCompte(){
        $item = new CaisseCompte();
       $item->caisse_id = request()->caisse_id;
       $item->compte_id = request()->compte_id;
       $item->save();
       Session::flash('success','Enregistrement effectué avec succès!');
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
		//$projet = Creance::where('token',$token)->first();
        $item = Caisse::find($id);
        $comptes = Compte::where('active',1)->get();
		return view('/Admin/Caisses/show')->with(compact('item','comptes'));
	}


}
