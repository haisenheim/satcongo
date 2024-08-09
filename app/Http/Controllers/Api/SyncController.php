<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lien;
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

        return response()->json('ok');
    }
}
