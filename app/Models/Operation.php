<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    //
    protected $guarded = [];

    public function mois()
    {
        return $this->belongsTo('App\Models\Mois');
    }

    public function validateur()
    {
        return $this->belongsTo('App\Models\User','validated_by');
    }

    public function transactions(){
        return $this->hasMany('App\Models\Transaction','operation_id');
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

    public function ville()
    {
        return $this->belongsTo('App\Models\Ville');
    }

 

    public function getSommeAttribute(){
        $trs = $this->transactions;
        $somme = 0;
        foreach($trs as $tr){
            if($tr->credit){
                $somme = $somme + $tr->montant;
            }else{
                $somme = $somme - $tr->montant;
            }
        }
        if($somme==0){
            $data = [
                'name'=>'valide',
                'somme'=>0,
                'color'=>'success',
                'status'=>true
            ];
            return $data;
        }else{
            $data = [
                'name'=>'invalide',
                'somme'=>$somme,
                'color'=>'success',
                'status'=>false,
            ];
            return $data;
        }
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


}
