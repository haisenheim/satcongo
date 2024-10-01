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

    public function validateur()
    {
        return $this->belongsTo('App\Models\User','validated_by');
    }

    public function compte()
    {
        return $this->belongsTo('App\Models\Compte');
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

    protected function day(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => \Carbon\Carbon::parse($value),
        );
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
