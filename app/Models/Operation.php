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

    public function tier()
    {
        return $this->belongsTo('App\Models\Tier');
    }

    public function caisse()
    {
        return $this->belongsTo('App\Models\Caisse');
    }

    public function agent()
    {
        return $this->belongsTo('App\Models\Agent');
    }

    public function departement_un()
    {
        return $this->belongsTo('App\Models\Departement','departement_un_id');
    }

    public function departement_deux()
    {
        return $this->belongsTo('App\Models\Departement','departement_deux_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Toperation','type_id');
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

    public function getMontantAttribute(){

        if($this->type_id==1){
            return $this->mt;
        }
        if($this->type_id==2){
            return $this->ration + $this->peage + $this->hotel + $this->bac + $this->autres + $this->prime;
        }
        if($this->type_id==3){
            return $this->mt_especes + $this->mt_cheque;
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
