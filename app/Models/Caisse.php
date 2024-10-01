<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caisse extends Model
{
    //
    protected $guarded = [];
    public $timestamps = false;

    public function ville()
    {
        return $this->belongsTo('App\Models\Ville');
    }

    public function comptes()
    {
        return $this->belongsToMany('App\Models\Compte','caisses_comptes');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }

    public function agence()
    {
        return $this->belongsTo('App\Models\Agence');
    }

    public function getFullNameAttribute(){
        
        return $this->name . "_" . $this->agence->name. " ". $this->ville->name;;
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
