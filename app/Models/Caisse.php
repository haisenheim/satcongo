<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    //
    protected $guarded = [];
    public $timestamps = false;

    

   

    public function comptes()
    {
        return $this->belongsToMany('App\Models\Compte','caisses_comptes');
    }

    public function compte()
    {
        return $this->belongsTo('App\Models\Compte');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User','caisses_users');
    }

    

    public function getFullNameAttribute(){
        
        return $this->name;
    }

    public function getStatusAttribute(){
        $data = [
            'name'=>'verrouillé',
            'color'=>'danger'
        ];
        if($this->active){
            $data = [
                'name'=>'actif',
                'color'=>'success'
            ];
        }
        return $data;
    }
}
