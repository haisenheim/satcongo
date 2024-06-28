<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function etudiant(){
        return $this->belongsTo('App\Models\Etudiant');
    }

    public function filiere(){
        return $this->belongsTo('App\Models\Filiere');
    }

    public function Niveau(){
        return $this->belongsTo('App\Models\Niveau');
    }

    public function Annee(){
        return $this->belongsTo('App\Models\Annee');
    }

    public function ecolages(){
        return $this->hasMany('App\Models\Ecolage');
    }

    public function fiches(){
        return $this->hasMany('App\Models\Fiche');
    }

    public function absences(){
        return $this->hasMany('App\Models\Absence');
    }


}
