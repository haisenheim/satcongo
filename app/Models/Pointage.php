<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['dt'];

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

    public function salle(){
        return $this->belongsTo('App\Models\Salle');
    }

    public function absences(){
        return $this->hasMany('App\Models\Absence','pointage_id');
    }

    public function annee(){
        return $this->belongsTo('App\Models\Annee');
    }

    public function mois(){
        return $this->belongsTo('App\Models\Mois','mois_id');
    }

    public function emploi(){
        return $this->belongsTo('App\Models\Emploi');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
