<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $guarded = [];

    public function dossiers()
    {
        return $this->hasMany('App\Models\Dossier','client_id');
    }


}
