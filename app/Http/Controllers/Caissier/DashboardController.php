<?php

namespace App\Http\Controllers\Caissier;

use App\Http\Controllers\Controller;
use App\Models\Caisse;
use App\Models\CaisseCompte;
use App\Models\Compte;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
	{
        $transactions = Transaction::orderBy('created_at','DESC')->where('user_id',auth()->user()->id)->whereNull('validated_at')->get();

		return view('Caissier/dashboard',compact('transactions'));
	}

    public function saveOperation(){
        $user = auth()->user();
        $caisse = Caisse::find($user->caisse_id);
        $cpt = Compte::find(request()->compte_id);
        $item = new Transaction();
        $item->user_id = $user->id;
        $item->caisse_id = $caisse->id;
        $item->agence_id = $caisse->agence_id;
        $item->ville_id = $caisse->ville_id;
        $item->montant = request()->montant;
        $item->compte_id = request()->compte_id;
        $item->credit = $cpt->credit;
        $item->ref = request()->ref;
        $item->day = request()->day;
        $dt = Carbon::parse(request()->day);
        $item->moi_id = $dt->month;
        $item->semaine = $dt->week;
        $item->annee = $dt->year;
        $item->token = sha1(time().$user->id);
        $item->save();
        Session::flash('success','Enregistrement effectué avec succès!');
        return back();
    }

    public function getComptes(){
        $type = request()->id; 
        $ccs = CaisseCompte::where('caisse_id',auth()->user()->caisse_id)->get();
        $ids = $ccs->pluck('compte_id');
        $comptes = Compte::whereIn('id',$ids)->where('credit',$type)->where('active',1)->get();
        return response()->json($comptes);
    }

}
