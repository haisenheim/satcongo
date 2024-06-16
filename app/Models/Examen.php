<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function periodicite(){
        return $this->belongsTo('App\Models\EvaluationPeriodicite','periodicite_id');
    }

    public function type(){
        return $this->belongsTo('App\Models\EvaluationType','type_id');
    }

    public function filiere(){
        return $this->belongsTo('App\Models\Filiere','filiere_id');
    }

    public function cours(){
        return $this->belongsTo('App\Models\Cours','cours_id');
    }

    public function evaluation(){
        return $this->belongsTo('App\Models\Evaluation','evaluation_id');
    }

    public function mois(){
        return $this->belongsTo('App\Models\Mois','mois_id');
    }

    public function notes(){
        return $this->hasMany('App\Models\Note','examen_id');
    }
}
