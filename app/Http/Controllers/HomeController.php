<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index(){
        $user = auth()->user();
       // dd(auth()->user());
        if($user){
            $role_id = $user->role_id;
           // dd($role_id);
           if($role_id == 1){
            //Auth::logout();
            return redirect('/admin/dashboard');
           }
           if($role_id == 2){
            return redirect('/comptable/dashboard');
           }
           if($role_id == 3){
            return redirect('/caissier/dashboard');
           }


           return redirect('/login');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
