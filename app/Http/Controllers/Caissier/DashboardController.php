<?php

namespace App\Http\Controllers\Caissier;

use App\Http\Controllers\Controller;
use App\Models\Caisse;
use App\Models\CaisseCompte;
use App\Models\CaisseUser;
use App\Models\Compte;
use App\Models\Departement;
use App\Models\Libelle;
use App\Models\Operation;
use App\Models\Tier;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Agent;
use App\Http\Resources\TransactionResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use function Spatie\LaravelPdf\Support\pdf;
//use Spatie\LaravelPdf\Facades\Pdf;
//use Spatie\LaravelPdf\Enums\Format;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\NombreHelper;

class DashboardController extends Controller
{
    public function index()
	{
        $transactions = Transaction::orderBy('created_at','DESC')->where('user_id',auth()->user()->id)->whereNull('validated_at')->get();
        $user = User::find(auth()->user()->id);
        $caisses = $user->caisses;
        //$caisses = Caisse::where('active',1)->get();
        $departements = Departement::where('active',1)->get();
        $tiers = Tier::where('active',1)->get();
        $comptes = Compte::where('active',1)->get();
        $agents = Agent::where('active',1)->get();
		return view('Caissier/dashboard',compact('transactions','caisses','departements','tiers','comptes','agents'));
	}

    public function getOperations(){
        $transactions = Transaction::orderBy('created_at','DESC')->where('user_id',auth()->user()->id)->whereNull('validated_at')->get();
        return response()->json(TransactionResource::collection($transactions));
    }



    public function create(){
        $cus = CaisseUser::where('user_id',auth()->user()->id)->get();
        $ids = $cus->pluck('caisse_id');
        $caisses = Caisse::whereIn('id',$ids)->get();
       // $libelles = Libelle::where('active',1)->get();
        $tiers = Tier::where('active',1)->get();
		return view('Caissier/create',compact('caisses','libelles','tiers'));
    }

    public function store(){
        $user = auth()->user();
        $montant = request()->montant;
        $caisse = Caisse::find(request()->caisse_id);
        $op = new Operation();
        $op->user_id = $user->id;
        $op->caisse_id = $caisse->id;
        $op->libelle = request()->libelle;
        $op->dossier = request()->dossier;
        $op->type_id = 1;
        $op->agent_id = request()->agent_id;
        $op->departement_un_id = request()->departement_un_id;
        $op->departement_deux_id = request()->departement_deux_id;
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
            $item->credit = 1;
            $item->compte = $caisse->compte;
            $item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();
            $caisse->solde = $caisse->solde - request()->montant;
            $caisse->save();

            //Et je renseigne le compte saisi au credit
            $item = new Transaction();
            $compte = Compte::find(request()->compte_id);
            $item->operation_id = $op->id;
            $item->user_id = $user->id;
            $item->caisse_id = $caisse->id;
            $item->montant = request()->montant;
            $item->credit = 0;
            $item->compte = $compte->code;
            $item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();
            $lettre = NombreHelper::convertirEnLettres($montant);
            $pdf = Pdf::loadView('Pdf.type_1', ['item' => $op,'ml'=>$lettre,'mc'=>$montant])->setPaper('a5', 'landscape');
        
         return $pdf->stream();
         return back();
    }

    public function store2(){
        $user = auth()->user();
        $caisse = Caisse::find(request()->caisse_id);
        $op = new Operation();
        $op->user_id = $user->id;
        $op->caisse_id = $caisse->id;
        $op->dossier = request()->dossier;
        $op->type_id = 2;
        $op->agent_id = request()->agent_id;
        $op->camion = request()->camion;
        $op->chauffeur = request()->chauffeur;
        $op->hotel = request()->mt_hotel;
        $op->ration = request()->mt_ration;
        $op->peage = request()->mt_peage;
        $op->prime = request()->mt_prime;
        $op->bac = request()->mt_bac;
        $op->autres = request()->mt_autres;

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
            $item->credit = 1;
            $item->compte = $caisse->compte;
            $item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();
            $caisse->solde = $caisse->solde - request()->montant;
            $caisse->save();

            //Et je renseigne le compte saisi au credit
            $item = new Transaction();
            $compte = Compte::find(request()->compte_id);
            $item->operation_id = $op->id;
            $item->user_id = $user->id;
            $item->caisse_id = $caisse->id;
            $item->montant = request()->montant;
            $item->credit = 0;
            $item->compte = $compte->code;
            $item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();
            $montant = request()->montant;
            $lettre = NombreHelper::convertirEnLettres($montant);
            $pdf = Pdf::loadView('Pdf.type_2', ['item' => $op,'ml'=>$lettre,'mc'=>$montant])->setPaper('a5', 'landscape');
            return $pdf->stream();

        Session::flash('success','Enregistrement effectué avec succès!');
        return redirect(route('caissier.dashboard'));
    }

    public function store3(){
        //dd(request()->all());
        $user = auth()->user();
        $caisse = Caisse::find(request()->caisse_id);
        $op = new Operation();
        $op->user_id = $user->id;
        $op->caisse_id = $caisse->id;
        $op->dossier = request()->dossier;
        $op->type_id = 3;
        $op->agent_id = request()->agent_id;
        $op->tier_id = request()->tier_id;
        $op->mt_especes = request()->mt_especes;
        $op->mt_cheque = request()->mt_cheque;
        $op->num_cheque = request()->num_cheque;
        $op->is_debours = request()->is_debours;
        $op->libelle = request()->libelle;

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
            $item->credit = 1;
            $item->compte = $caisse->compte;
            $item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();
            $caisse->solde = $caisse->solde - request()->montant;
            $caisse->save();

            //Et je renseigne le compte saisi au credit
            $item = new Transaction();
            $compte = Compte::find(request()->compte_id);
            $item->operation_id = $op->id;
            $item->user_id = $user->id;
            $item->caisse_id = $caisse->id;
            $item->montant = request()->montant;
            $item->credit = 0;
            $item->compte = $compte->code;
            $item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();

        $montant = request()->montant;
        $lettre = NombreHelper::convertirEnLettres($montant);
        $pdf = Pdf::loadView('Pdf.type_3', ['item' => $op,'ml'=>$lettre,'mc'=>$montant])->setPaper('a5', 'landscape');
        return $pdf->stream();

        Session::flash('success','Enregistrement effectué avec succès!');
        return redirect(route('caissier.dashboard'));
    }

    public function _store(){

        //dd(request()->all());
        $user = auth()->user();
        $caisse = Caisse::find(request()->caisse_id);
        $op = new Operation();
        $op->user_id = $user->id;
        $op->caisse_id = $caisse->id;
        $op->agence_id = $caisse->agence_id;
        $op->ville_id = $caisse->ville_id;
        $op->ref = request()->ref;
        $op->facture = request()->facture;
        $op->tier_id = request()->tier_id??0;
        $op->day = request()->day;
        $dt = Carbon::parse(request()->day);
        $op->moi_id = $dt->month;
        $op->semaine = $dt->week;
        $op->annee = $dt->year;
        $op->token = sha1(time().$user->id);
        $op->save();
        $sens = request()->sens;

        //Si c'est une entree
        if($sens == 1){
            //Je renseigne le compte lie a la caisse au debit
            $item = new Transaction();
            $item->operation_id = $op->id;
            $item->user_id = $user->id;
            $item->caisse_id = $caisse->id;
            $item->agence_id = $caisse->agence_id;
            $item->ville_id = $caisse->ville_id;
            $item->montant = request()->montant;

            $item->credit = 0;
            $item->compte = $caisse->compte;
            $item->ref = $op->ref;
            $item->facture = $op->facture;
            $item->tier_id = $op->tier_id;
            $item->day = $op->day;
            $item->moi_id = $dt->month;
            $item->semaine = $dt->week;
            $item->annee = $dt->year;
            $item->libelle_id = $libelle->id;
            $item->name = $libelle->name;
            $item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();
            $caisse->solde = $caisse->solde + request()->montant;
            $caisse->save();

            //Et je renseigne le compte saisi au credit
            $item = new Transaction();
            $item->operation_id = $op->id;
            $item->user_id = $user->id;
            $item->caisse_id = $caisse->id;
            $item->agence_id = $caisse->agence_id;
            $item->ville_id = $caisse->ville_id;
            $item->montant = request()->montant;
            $item->credit = 1;
            $item->compte = request()->compte;
            $item->ref = $op->ref;
            $item->facture = $op->facture;
            $item->tier_id = $op->tier_id;
            $item->day = $op->day;
            $item->moi_id = $dt->month;
            $item->semaine = $dt->week;
            $item->annee = $dt->year;
            $item->libelle_id = $libelle->id;
            $item->name = $libelle->name;
            $item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();
        }else{ //Sinon

            //Je renseigne le compte lie a la caisse au credit
            $item = new Transaction();
            $item->operation_id = $op->id;
            $item->user_id = $user->id;
            $item->caisse_id = $caisse->id;
            $item->agence_id = $caisse->agence_id;
            $item->ville_id = $caisse->ville_id;
            $item->montant = request()->montant;
            $item->credit = 1;
            $item->compte = $caisse->compte;
            $item->ref = $op->ref;
            $item->facture = $op->facture;
            $item->tier_id = $op->tier_id;
            $item->day = $op->day;
            $item->moi_id = $dt->month;
            $item->semaine = $dt->week;
            $item->annee = $dt->year;
            $item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();
            $caisse->solde = $caisse->solde - request()->montant;
            $caisse->save();

            //Et je renseigne le compte saisi au credit
            $item = new Transaction();
            $item->operation_id = $op->id;
            $item->user_id = $user->id;
            $item->caisse_id = $caisse->id;
            $item->agence_id = $caisse->agence_id;
            $item->ville_id = $caisse->ville_id;
            $item->montant = request()->montant;
            $item->credit = 0;
            $item->compte = request()->compte;
            $item->ref = $op->ref;
            $item->facture = $op->facture;
            $item->tier_id = $op->tier_id;
            $item->day = $op->day;
            $item->moi_id = $dt->month;
            $item->semaine = $dt->week;
            $item->annee = $dt->year;
            $item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();
        }

        Session::flash('success','Enregistrement effectué avec succès!');
        return redirect(route('caissier.dashboard'));
    }

    public function createOperation()
	{
        $cus = CaisseUser::where('user_id',auth()->user()->id)->get();
        $ids = $cus->pluck('caisse_id');
        $caisses = Caisse::whereIn('id',$ids)->get();
		return view('Caissier/create',compact('caisses'));
	}

    public function saveOperation(){
        $user = auth()->user();
        $caisse = Caisse::find($user->caisse_id);
        $op = new Operation();
        $op->user_id = $user->id;
        $op->caisse_id = $caisse->id;
        $op->agence_id = $caisse->agence_id;
        $op->ville_id = $caisse->ville_id;
        $op->ref = request()->ref;
        $op->day = request()->day;
        $dt = Carbon::parse(request()->day);
        $op->moi_id = $dt->month;
        $op->semaine = $dt->week;
        $op->annee = $dt->year;
        $op->token = sha1(time().$user->id);
        $op->save();

        $items = request()->items;
        foreach($items as $tr){
            $cpt = Compte::find($tr['compte_id']);
            $item = new Transaction();
            $item->operation_id = $op->id;
            $item->user_id = $user->id;
            $item->caisse_id = $caisse->id;
            $item->agence_id = $caisse->agence_id;
            $item->ville_id = $caisse->ville_id;
            $item->montant = $tr['montant'];
            $item->compte_id = $tr['compte_id'];
            $item->credit = $cpt->credit;
            $item->ref = $op->ref;
            $item->day = $op->day;
            $item->moi_id = $dt->month;
            $item->semaine = $dt->week;
            $item->annee = $dt->year;
            $item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();
        }

       // Session::flash('success','Enregistrement effectué avec succès!');
        return response()->json('ok');
    }

    public function __updateOperation(){
        $sens = request('sens');
        $data = request()->except('sens');
        $libelle = request()->libelle_id;
        $data['name'] = $libelle->name;
        //$cpt = Compte::find(request()->compte_id);
        Transaction::updateOrCreate(['id'=>$data['id']],$data);
        $operation = Operation::find($data['operation_id']);

        Session::flash('success','Enregistrement effectué avec succès!');
        return back();
    }

    public function updateOperation(){

        //dd(request()->all());
        $user = auth()->user();
        $caisse = Caisse::find(request()->caisse_id);
        $op = Operation::find(request()->operation_id);
        $op->user_id = $user->id;
        $op->caisse_id = $caisse->id;
        $op->agence_id = $caisse->agence_id;
        $op->ville_id = $caisse->ville_id;
        $op->ref = request()->ref;
        $op->facture = request()->facture;
      //  $op->tier_id = request()->tier_id;
        $op->day = request()->day;
        $dt = Carbon::parse(request()->day);
        $op->moi_id = $dt->month;
        $op->semaine = $dt->week;
        $op->annee = $dt->year;
        $op->token = sha1(time().$user->id);
        $op->save();
        $sens = request()->sens;
        $libelle = Libelle::find(request()->libelle_id);
        //dd($libelle);

        //Si c'est une entree
        if($sens == 1){
            //Je renseigne le compte lie a la caisse au debit
            $item = Transaction::find(request()->id);
            //$item->operation_id = $op->id;
            $item->user_id = $user->id;
            $item->caisse_id = $caisse->id;
            $item->agence_id = $caisse->agence_id;
            $item->ville_id = $caisse->ville_id;
            $item->montant = request()->montant;

            $item->credit = 0;
            $item->compte = $caisse->compte;
            $item->ref = $op->ref;
            $item->facture = $op->facture;
           // $item->tier_id = $op->tier_id;
            $item->day = $op->day;
            $item->moi_id = $dt->month;
            $item->semaine = $dt->week;
            $item->annee = $dt->year;
            $item->libelle_id = $libelle->id;
            $item->name = $libelle->name;
           // $item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();
            $caisse->solde = $caisse->solde + request()->montant;
            $caisse->save();

            //Et je renseigne le compte saisi au credit
            $item = Transaction::where('operation_id',$op->id)->where('id','!=',request()->id)->first();
            //$item->operation_id = $op->id;
            $item->user_id = $user->id;
            $item->caisse_id = $caisse->id;
            $item->agence_id = $caisse->agence_id;
            $item->ville_id = $caisse->ville_id;
            $item->montant = request()->montant;
            $item->credit = 1;
            $item->compte = request()->compte;
            $item->ref = $op->ref;
            $item->facture = $op->facture;
           // $item->tier_id = $op->tier_id;
            $item->day = $op->day;
            $item->moi_id = $dt->month;
            $item->semaine = $dt->week;
            $item->annee = $dt->year;
            $item->libelle_id = $libelle->id;
            $item->name = $libelle->name;
            $item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();
        }else{ //Sinon

            //Je renseigne le compte lie a la caisse au credit
            $item = Transaction::find(request()->id);
            //$item->operation_id = $op->id;
            $item->user_id = $user->id;
            $item->caisse_id = $caisse->id;
            $item->agence_id = $caisse->agence_id;
            $item->ville_id = $caisse->ville_id;
            $item->montant = request()->montant;
            $item->credit = 1;
            $item->compte = $caisse->compte;
            $item->ref = $op->ref;
            $item->facture = $op->facture;
           // $item->tier_id = $op->tier_id;
            $item->day = $op->day;
            $item->moi_id = $dt->month;
            $item->semaine = $dt->week;
            $item->annee = $dt->year;
            $item->libelle_id = $libelle->id;
            $item->name = $libelle->name;
            //$item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();
            $caisse->solde = $caisse->solde - request()->montant;
            $caisse->save();

            //Et je renseigne le compte saisi au credit
            $item = Transaction::where('operation_id',$op->id)->where('id','!=',request()->id)->first();
            //$item->operation_id = $op->id;
            $item->user_id = $user->id;
            $item->caisse_id = $caisse->id;
            $item->agence_id = $caisse->agence_id;
            $item->ville_id = $caisse->ville_id;
            $item->montant = request()->montant;
            $item->credit = 0;
            $item->compte = request()->compte;
            $item->ref = $op->ref;
            $item->facture = $op->facture;
            //$item->tier_id = $op->tier_id;
            $item->day = $op->day;
            $item->moi_id = $dt->month;
            $item->semaine = $dt->week;
            $item->annee = $dt->year;
            $item->libelle_id = $libelle->id;
            $item->name = $libelle->name;
            //$item->token = sha1(time().$op->id.rand(0,9999));
            $item->save();
        }

        Session::flash('success','Modification effectuée avec succès!');
        return redirect(route('caissier.dashboard'));
    }

    public function _updateOperation(){
        // dd(request()->all());
         $cpt = Compte::find(request()->compte_id);
         $item =  Transaction::find(request()->id);
         $item->montant = request()->montant;
         $item->compte_id = request()->compte_id;
         $item->credit = $cpt->credit;
         $item->save();
         Session::flash('success','Enregistrement effectué avec succès!');
         return back();
     }


    public function _saveOperation(){
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
        //$cus = CaisseUser::where('user_id',auth()->user()->id)->get();
        $ccs = CaisseCompte::where('caisse_id',request()->caisse_id)->get();
        $ids = $ccs->pluck('compte_id');
        $comptes = Compte::whereIn('id',$ids)->where('credit',$type)->where('active',1)->get();
        return response()->json($comptes);
    }

}
