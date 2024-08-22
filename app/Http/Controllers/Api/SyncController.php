<?php

namespace App\Http\Controllers\Api\Tuteur;

use App\Http\Controllers\Controller;
use App\Models\Lien;
use App\Models\Tuteur;
use App\Services\OneSignalNotification;
use Illuminate\Http\Request;

class SyncController extends Controller
{
    //
    public function setLink(){
        $lien = new Lien();
        $lien->etudiant_id = request()->etudiant_id;
        $lien->app_id = request()->app_id;
        $lien->tenant_id = request()->tenant_id;
        $lien->tuteur_id = request()->tuteur_id;
        $lien->token = sha1(time().rand(0,9999));
        $lien->save();
        return response()->json($lien);
    }


    public function notify(){
        $data = request()->all();
        //$fields = $data['fields'];
        //$eleve_id = $data['id'];
        $tuteur = Tuteur::find($data['tuteur_id']);
        $fields['headings'] = $data['headings'];
        $fields['content'] = $data['content'];
        if($tuteur){
            $fields['include_external_user_ids'] = [$tuteur->token];
            $fields['channel_for_external_user_ids'] = "push";
            $message = 'Alerte SKUL AGENT !!!';
            $response = OneSignalNotification::send($fields,$message);
            return response()->json($response);
        }
        return response()->json("-1");
    }



    public function _notify(){
        $fields['contents'] = ['en'=>"Ceci est le contenu du message"];
        $fields['headings'] = ['en'=>"Titre du message"];
        $fields['include_external_user_ids'] = ['90239328327837'];
        $fields['channel_for_external_user_ids'] = "push";
        $message = 'message de l\'API';
        $response = OneSignalNotification::send($fields,$message);
        return response()->json($response);
    }
}
