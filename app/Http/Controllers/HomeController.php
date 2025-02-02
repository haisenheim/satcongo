<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

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
           if($role_id == 4){
            return redirect('/dcomptable/dashboard');
           }

           if($role_id == 5){
            return redirect('/operateur/dashboard');
           }


           return redirect('/login');
        }
    }

    public function profile(){
        $user = User::find(auth()->user()->id);
        return view('Auth.profile',compact('user'));
    }

    public function storeProfile(){
        $user = User::where('token',request()->id)->first();
        if($user){
            //$user->name = request()->name;
            $user->password = bcrypt(request()->password);
            //$user->email = request()->email;
            $user->save();
            Auth::logout();
            return redirect('/login');
            //Session::flash('success','Mise à jour effectuée avec succès!');
        }
        return back();
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
