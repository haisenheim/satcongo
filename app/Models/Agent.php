<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Tymon\JWTAuth\Contracts\JWTSubject;

class Agent extends Authenticatable
{
    //
    use Notifiable;

    protected $guarded = [];



    public function zone()
    {
        return $this->belongsTo('App\Models\Zone');
    }

    public function getNameAttribute(){
        return $this->last_name . " ".$this->first_name;
    }

}
