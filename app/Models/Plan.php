<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function enseignant(){
        return $this->belongsTo('App\Models\Enseignant');
    }

    public function filiere(){
        return $this->belongsTo('App\Models\Filiere');
    }

    public function cours(){
        return $this->belongsTo('App\Models\Cours','cours_id');
    }

    public function matiere(){
        return $this->belongsTo('App\Models\Matiere');
    }

    public function items(){
        return $this->hasMany('App\Models\PlanItem','plan_id');
    }

    public function annee(){
        return $this->belongsTo('App\Models\Annee');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
