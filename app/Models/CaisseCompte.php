<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaisseCompte extends Model
{
    //
    protected $guarded = [];
    protected $table = 'caisses_comptes';
    public $timestamps = false;

    public function users(){
        return $this->belongsToMany('App\Models\User','caisses_users');
    }

}
