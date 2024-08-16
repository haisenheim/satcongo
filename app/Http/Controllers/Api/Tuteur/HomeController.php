<?php

namespace App\Http\Controllers\Api\Tuteur;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExtendedController;
use App\Models\App;
use App\Models\Lien;
use App\Models\Tuteur;
use Illuminate\Support\Facades\Http;
use App\Services\OneSignalNotification;

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
            //$zanzi = 'http://medium.zanzi-apps.com';
            //dd($app_3);
            $res = Http::post($app_3->host.'/api/skulagent/eleves',$ids_3);
            $eleves = array_merge($eleves,$res->json());
        }
        $tuteur->eleves = $eleves;
        return response()->json($tuteur);
    }


    public function getUser($phone){
        $tuteur = Tuteur::where('phone',$this->formatNumber($phone))->first();
        return $tuteur;
    }

    public function notify(){
        $fields['contents'] = ['en'=>"Ceci est le contenu du message"];
        $fields['include_external_user_ids'] = ['90239328327837'];
        $fields['channel_for_external_user_ids'] = "push";
       // $fields['data'] = $data;
        $message = 'message de l\'API';
        $response = OneSignalNotification::send($fields,$message);
        return response()->json($response);
    }

    public function getEleveByLinkId($id){
        $lien = Lien::find($id);
        $app = App::find($lien->app_id);
        if($lien->app_id == 3){
            $tenant_id = $lien->tenant_id;
            $eleve_id = $lien->etudiant_id;
            $res = Http::get($app->host.'/api/skulagent/eleve?id='.$eleve_id.'&tenant_id='.$tenant_id);
            return response()->json($res->json());
        }
    }
}
