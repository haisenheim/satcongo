<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if($user->role_id!=1){
            return redirect('/login');
        }
        $path = request()->getPathInfo();
        $parts = explode('/',$path);
        $active = 1;
        if(in_array('protocole',$parts) || in_array('protocoles',$parts)){
            $active = 202;
        }
        if(in_array('contrat',$parts) || in_array('contrats',$parts)){
            $active = 201;
        }
        if(in_array('banks',$parts)){
            $active = 301;
        }
        if(in_array('client',$parts) || in_array('clients',$parts)){
            $active = 302;
        }
        if(in_array('cooperative',$parts) || in_array('cooperatives',$parts)){
            $active = 303;
        }
        if(in_array('villages',$parts)){
            $active = 401;
        }
        if(in_array('arrondissements',$parts)){
            $active = 402;
        }
        if(in_array('departements',$parts)){
            $active = 403;
        }
        if(in_array('regions',$parts)){
            $active = 404;
        }
        if(in_array('saisons',$parts)){
            $active = 701;
        }
        if(in_array('operateurs',$parts)){
            $active = 702;
        }
        if(in_array('rbassins',$parts)){
            $active = 703;
        }
        if(in_array('pays',$parts)){
            $active = 704;
        }
        if(in_array('a_transactions',$parts)){
            $active = 501;
        }
        if(in_array('livraisons',$parts)){
            $active = 2;
        }
        Session::put('active',$active);
        return $next($request);
    }
}
