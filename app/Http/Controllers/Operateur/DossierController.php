<?php

namespace App\Http\Controllers\Operateur;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Dossier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
        $items = Dossier::where('user_id',auth()->user()->id)->get();
        $clients = Client::where('site_id',$this->site_id)->get();
        return view('/Operateur/Dossiers/index')->with(compact('items','clients'));
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
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:dossiers|max:25',
        ]);
 
        if ($validator->fails()) {
            Session::flash('error','Ce code de dossier existe déja!');
            return redirect()->back();
        }
        $data['user_id'] = auth()->user()->id;
        $data['site_id'] = $this->site_id;
        $data['token'] = sha1(time());
        Session::flash('success','Nouveau dossier créé avec succès!');
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

	}


}
