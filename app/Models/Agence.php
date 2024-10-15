<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agence extends Model
{
    //
    protected $guarded = [];
    public $timestamps = false;

    public function ville()
    {
        return $this->belongsTo('App\Models\Ville');
    }

    public function libelles()
    {
        return $this->belongsToMany('App\Models\Libelle','libelle_agences');
    }

    public function departement()
    {
        return $this->belongsTo('App\Models\Departement');
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
