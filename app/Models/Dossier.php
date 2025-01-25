<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    //
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo('App\Models\Client','client_id');
    }

    public function getStatusAttribute(){
        $data = [
            'name'=>'ouvert',
            'color'=>'warning'
        ];
        if($this->closed_at){
            $data = [
                'name'=>'fermé',
                'color'=>'success'
            ];
        }

        return $data;
    }


}
