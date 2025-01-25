<?php

namespace App\Http\Controllers\Operateur;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{



    public function index()
	{
		return view('Operateur/dashboard');
	}

}
