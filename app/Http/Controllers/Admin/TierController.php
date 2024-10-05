<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Tier::all();
        return view('/Admin/Tiers/index')->with(compact('items'));
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
        $data['token'] = sha1(time());
        Tier::create($data);
        return back();
    }


    public function  enable($id){
        $item = Tier::find($id);
        $item->active = 1;
        $item->save();
        return back();
    }

    public function  disable($id){
        $item = Tier::find($id);
        $item->active = 0;
        $item->save();
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


}
