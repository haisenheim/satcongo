<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $guarded = [];

    public function mois()
    {
        return $this->belongsTo('App\Models\Mois');
    }

    public function operation()
    {
        return $this->belongsTo('App\Models\Operation');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function dossier()
    {
        return $this->belongsTo('App\Models\Dossier');
    }

    public function validateur()
    {
        return $this->belongsTo('App\Models\User','validated_by');
    }



    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function caisse()
    {
        return $this->belongsTo('App\Models\Caisse');
    }

    public function agence()
    {
        return $this->belongsTo('App\Models\Agence');
    }

    public function libelle()
    {
        return $this->belongsTo('App\Models\Libelle');
    }

    public function ville()
    {
        return $this->belongsTo('App\Models\Ville');
    }

    public function getStatusAttribute(){
        $data = [
            'name'=>'non validé',
            'code'=>-1,
            'color'=>'danger'
        ];
        if($this->validated_at){
            $data = [
                'name'=>'validé',
                'code'=>0,
                'color'=>'success'
            ];
        }

        return $data;
    }

    public function getTotalAttribute(){
        return $this->price * $this->quantity*1000;
    }

}
