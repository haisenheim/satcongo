<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agence;
use App\Models\Ville;
use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $departements = Departement::all();
        return view('/Admin/Agences/index')->with(compact('departements'));
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
        Departement::create($data);
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
		
	}

    public function  enable($id){
        $item = Departement::find($id);
        $item->active = 1;
        $item->save();
        return back();
    }

    public function  disable($id){
        $item = Departement::find($id);
        $item->active = 0;
        $item->save();
        return back();
    }

    


}
