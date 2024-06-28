<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fiche extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function enseignant(){
        return $this->belongsTo('App\Models\Enseignant');
    }

    public function etudiant(){
        return $this->belongsTo('App\Models\Etudiant');
    }

    public function inscription(){
        return $this->belongsTo('App\Models\inscription');
    }

    public function items(){
        return $this->hasMany('App\Models\FicheItem','fiche_id');
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
