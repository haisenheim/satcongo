<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Operateur
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if($user->role_id!=5){
            return redirect('/login');
        }
        $path = request()->getPathInfo();
        $parts = explode('/',$path);
        $active = 1;

        if(in_array('dashboard',$parts)){
            $active = 1;
        }
        if(in_array('dossiers',$parts)){
            $active = 2;
        }
        if(in_array('clients',$parts)){
            $active = 3;
        }
        Session::put('active',$active);
        return $next($request);
    }
}
