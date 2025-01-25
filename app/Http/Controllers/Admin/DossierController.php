<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Dossier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DossierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Dossier::where('site_id',$this->site_id)->get();
        $clients = Client::where('site_id',$this->site_id)->get();
        return view('/Admin/Dossiers/index')->with(compact('items','clients'));
    }

    public function close($token){
        $dossier = Dossier::where('token',$token)->first();
        $dossier->closed_at = new \DateTime();
        $dossier->save();
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
        $data['user_id'] = auth()->user()->id;
        $data['site_id'] = $this->site_id;
        $data['token'] = sha1(time());
        Dossier::create($data);
        return back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projet  $projet
     * @return \Illuminate\Http\Response
     */
	public function show($token)
	{
        $item = Dossier::where('token',$token)->first();
        return view('/Admin/Dossiers/show')->with(compact('item'));

	}


}
