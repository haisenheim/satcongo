<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function inscriptions(){
        return $this->hasMany('App\Models\Inscription','niveau_id');
    }

    public function ecolages(){
        return $this->hasMany('App\Models\Ecolage');
    }

    public function cycle(){
        return $this->belongsTo('App\Models\Cycle');
    }
}
