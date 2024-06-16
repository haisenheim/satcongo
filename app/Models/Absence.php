<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['dt'];

    public function enseignant(){
        return $this->belongsTo('App\Models\Enseignant');
    }

    public function etudiant(){
        return $this->belongsTo('App\Models\Etudiant');
    }

    public function inscription(){
        return $this->belongsTo('App\Models\inscription');
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

    public function mois(){
        return $this->belongsTo('App\Models\Mois','mois_id');
    }

    public function pointage(){
        return $this->belongsTo('App\Models\Pointage','pointage_id');
    }

    public function annee(){
        return $this->belongsTo('App\Models\Annee');
    }

    public function emploi(){
        return $this->belongsTo('App\Models\Emploi');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
