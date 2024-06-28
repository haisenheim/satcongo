<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emploi extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function filiere(){
        return $this->belongsTo('App\Models\Filiere');
    }

    public function matiere(){
        return $this->belongsTo('App\Models\Matiere');
    }

    public function enseignant(){
        return $this->belongsTo('App\Models\Enseignant');
    }

    public function fiches(){
        return $this->hasMany('App\Models\Fiche');
    }

    public function cours(){
        return $this->belongsTo('App\Models\Cours','cours_id');
    }

    public function salle(){
        return $this->belongsTo('App\Models\Salle');
    }

    public function pointages(){
        return $this->hasMany('App\Models\Pointage');
    }

    public function getThrAttribute(){
        $nb = $this->pointages->count();
        return $nb*$this->gap;
    }

    public function getTsAttribute(){
        $nb = $this->pointages->count();
        return $nb;
    }

    public function getThnAttribute(){
        $gap = $this->gap;
        $taux = $this->pu;
        $nb = $this->pointages->count();
        $total = $gap*$taux*$nb;
        return $total;
    }


}
