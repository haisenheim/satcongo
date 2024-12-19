<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Caisse;
use App\Models\Agence;
use App\Models\CaisseCompte;
use App\Models\CaisseUser;
use App\Models\Compte;
use App\Models\User;
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
        return view('/Admin/Caisses/index')->with(compact('items'));
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
       // $ag = Agence::find($data['agence_id']);
        //$data['departement_id'] = $ag->departement_id;
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

    public function setCompte(){
        $item = Caisse::find(request()->caisse_id);
        $item->compte = request()->compte;
        $item->save();
        Session::flash('success','Enregistrement effectué avec succès!');
        return back();
    }

    public function setUser(){
        //dd(request()->all());
        $data = request()->except('_token');
        CaisseUser::updateOrCreate($data,$data);
        Session::flash('success','Enregistrement effectué avec succès!');
        return back();
    }

    public function addCompte(){
        $item = new CaisseCompte();
        CaisseCompte::updateOrCreate([
            'caisse_id'=>request()->caisse_id,
            'compte_id'=>request()->compte_id,],
            [
                'caisse_id'=>request()->caisse_id,
                'compte_id'=>request()->compte_id,
            ]
        );
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
        $item = Caisse::find($id);
        $comptes = Compte::where('active',1)->get();
        $users = User::where('active',1)->where('role_id',3)->get();
		return view('/Admin/Caisses/show')->with(compact('item','comptes','users'));
	}


}
