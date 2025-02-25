<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaisseUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = User::all();
        $roles = Role::all();
        return view('Admin/Users/index')->with(compact('items','roles'));
    }

    public function setCaisse(){
        $item = CaisseUser::where('user_id',request()->user_id)->where('caisse_id',request()->caisse_id)->first();
        if(!$item){
            $item = new CaisseUser();
            $item->user_id = request()->user_id;
            $item->caisse_id = request()->caisse_id;
            $item->save();
            Session::flash('success','Enregistrement effectué avec succès!');
        }
        return back();
    }

    public function setDepartement(){
        $item = User::find(request()->user_id);
        $item->departement_id = request()->departement_id;
        $item->save();
        return back();
     }

    public function _setCaisse(){
       $item = User::find(request()->user_id);
       $item->caisse_id = request()->caisse_id;
       $item->save();
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
        $user = new User();
        $user->name = request()->name;
        $user->token = sha1(date('Yhmdsi'). auth()->user()->id);
        $user->password = bcrypt(request()->password);
        $user->role_id = request()->role_id;
        $user->phone = request()->phone;
        $user->email = request()->email;
        $user->site_id = $this->site_id;
        $user->save();
        return back();
    }

    public function  enable($token){
        $user = User::where('token',$token)->first();
        $user->active = 1;
        $user->save();
        return back();
    }

    public function  disable($token){
        $user = User::where('token',$token)->first();
        $user->active = 0;
        $user->save();
        return back();
    }

    public function  setPassword(){
        $user = User::find(request()->user_id);
        $user->password = bcrypt(request()->password);
        $user->save();
        Session::flash('success','Mot de passe réinitialisé avec succès!');
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
