<?php

namespace App\Http\Controllers\Comptable;

use App\Exports\OperationExport;
use App\Http\Controllers\Controller;
use App\Models\Caisse;
use App\Models\CaisseCompte;
use App\Models\Compte;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Ville;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index()
	{

       // $villes = Ville::all();
        $start = request()->start;
        $end = request()->end;
        $agence_id = request()->agence_id;
        $caisse_id = request()->caisse_id;
        $ready = false;
        if($start && $end && $agence_id && $caisse_id){
            $transactions = Transaction::orderBy('created_at','DESC')->whereBetween('day',[$start,$end])->where('caisse_id',$caisse_id)->get();
            $ready = true;
            return view('Comptable/dashboard',compact('transactions','ready','start','end','agence_id','caisse_id'));
        }else{
            $transactions = collect();
            return view('Comptable/dashboard',compact('transactions','ready'));
        }
        return view('Comptable/dashboard',compact('transactions','ready'));

	}

    public function blukValidate(){
        $start = request()->start;
        $end = request()->end;
        $caisse_id = request()->caisse_id;
        $ready = false;
        if($start && $end && $caisse_id){
            $transactions = Transaction::orderBy('created_at','DESC')->whereBetween('day',[$start,$end])->where('caisse_id',$caisse_id)->whereNull('validated_at')->get();
            foreach($transactions as $item){
                $item->validated_at = new \DateTime();
                $item->validated_by = auth()->user()->id;
                $item->save();
            }
            Session::flash('success','Operation effectuée avec succès!');
        }
        return back();
    }

    public function blukExport(){
        $start = request()->start;
        $end = request()->end;
        $caisse_id = request()->caisse_id;
        if($start && $end && $caisse_id){
            $caisse = Caisse::find($caisse_id);
            $transactions = Transaction::orderBy('created_at','DESC')->whereBetween('day',[$start,$end])->where('caisse_id',$caisse_id)->get();
            return Excel::download(new OperationExport($transactions,$caisse,$start,$end), $caisse->full_name.'_'.$start.' - '.$end.'.xlsx');
        }
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
