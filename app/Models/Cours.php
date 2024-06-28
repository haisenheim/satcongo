<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'cours';
    public function matiere(){
        return $this->belongsTo('App\Models\Matiere', 'matiere_id');
    }
    public function niveau(){
        return $this->belongsTo('App\Models\Niveau', 'niveau_id');
    }
    public function filiere(){
        return $this->belongsTo('App\Models\Filiere', 'filiere_id');
    }

    public function fiches(){
        return $this->hasMany('App\Models\Fiche','cours_id');
    }
}
