<?php

namespace App\Http\Controllers\Api\Tuteur;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExtendedController;
use App\Models\App;
use App\Models\Lien;
use App\Models\Tuteur;
use Illuminate\Support\Facades\Http;

class HomeController extends ExtendedController
{

    private function formatNumber($phone){
        $number = str_replace(' ','',$phone);
        return $number;
    }

    public function index($phone){
        $eleves = [];
        $phone = $this->formatNumber($phone);
        $tuteur = Tuteur::where('phone',$phone)->first();
        $links = Lien::where('tuteur_id',$tuteur->id)->get();
        $links = $links->where('app_id',3);
        $ids_3 = $links->map(function($item,$index){
            return [
                'link_id'=>$item->id,
                'etudiant_id'=>$item->etudiant_id,
                'tenant_id'=>$item->tenant_id,
            ];
        });
        $app_3 = App::find(3);
        if(count($ids_3)){
            $zanzi = 'http://medium.zanzi-apps.com';
            dd($app_3);
            $res = Http::dd()->post($app_3->domain.'/api/skulagent/eleves',$ids_3);
            $eleves = array_merge($eleves,$res->json());
        }
        return response()->json([
            'eleves'=>$eleves,
            'tuteur'=>$tuteur
        ]);
    }


    public function getUser($phone){
        $tuteur = Tuteur::where('phone',$this->formatNumber($phone))->first();
        return $tuteur;
    }

    public function notify(){
    }
}
