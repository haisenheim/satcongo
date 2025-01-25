<?php

namespace App\Http\Controllers\Comptable;

use App\Exports\OperationExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Caisse;
use App\Models\CaisseCompte;
use App\Models\Compte;
use App\Models\Operation;
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

        $caisses = Caisse::all();
        $comptes = Compte::where('active',1)->get();
        return view('Comptable/dashboard',compact('comptes','caisses'));

	}

    public function getOperations(){
        $start = request()->start;
        $end = request()->end;
        $caisse_id = request()->caisse_id;
        if($start && $end && $caisse_id){
            $transactions = Transaction::orderBy('created_at','DESC')->where('caisse_id',$caisse_id)->get();
            $ready = true;
            $transactions = $transactions->filter(function($item)use($start,$end){
                $day = Carbon::parse($item->operation->day);
                return $day>=$start && $day<=$end;
            });
            //$transactions = Transaction::orderBy('created_at','DESC')->whereNull('validated_at')->get();
            return response()->json(TransactionResource::collection($transactions));
            //return view('Comptable/dashboard',compact('transactions','ready','start','end','caisses','caisse_id'));
        }else{
            //$transactions = collect();
            return response()->json([]);
            return view('Comptable/dashboard',compact('transactions','caisses','ready'));
        }
        //$transactions = Transaction::orderBy('created_at','DESC')->whereNull('validated_at')->get();
        //return response()->json(TransactionResource::collection($transactions));
    }

    public function store(){
        $user = auth()->user();
        $montant = request()->montant;
        $caisse = Caisse::find(request()->caisse_id);
        $op = new Operation();
        $op->user_id = $user->id;
        $op->caisse_id = $caisse->id;
        $op->libelle = request()->libelle;
        $op->type_id = 0;
        $op->day = request()->day;
        $dt = Carbon::parse(request()->day);
        $op->moi_id = $dt->month;
        $op->semaine = $dt->week;
        $op->annee = $dt->year;
        $op->token = sha1(time().$user->id);
        $op->save();


            //Je renseigne le compte lie a la caisse au credit
            $item = new Transaction();
            $item->operation_id = $op->id;
            $item->user_id = $user->id;
            $item->caisse_id = $caisse->id;
            $item->montant = request()->montant;
            $item->credit = 0;
            $item->compte = $caisse->compte;
            $item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();
            $caisse->solde = $caisse->solde + request()->montant;
            $caisse->save();

            //Et je renseigne le compte saisi au credit
            $item = new Transaction();
            $compte = Compte::find(request()->compte_id);
            $item->operation_id = $op->id;
            $item->user_id = $user->id;
            $item->caisse_id = $caisse->id;
            $item->montant = request()->montant;
            $item->credit = 1;
            $item->compte = 53;
            $item->token = sha1(time().$op->id.rand(0,9999));
        $item->save();
         return back();
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

            $transactions = Transaction::orderBy('created_at','DESC')->where('caisse_id',$caisse_id)->get();
            $transactions = $transactions->filter(function($item)use($start,$end){
                $day = Carbon::parse($item->operation->day);
                return $day>=$start && $day<=$end;
            });

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
