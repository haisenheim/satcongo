<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function periodicite(){
        return $this->belongsTo('App\Models\EvaluationPeriodicite','periodicite_id');
    }

    public function type(){
        return $this->belongsTo('App\Models\EvaluationType','type_id');
    }

    public function evaluation(){
        return $this->belongsTo('App\Models\Evaluation','evaluation_id');
    }

    public function examen(){
        return $this->belongsTo('App\Models\Examen','examen_id');
    }

    public function mois(){
        return $this->belongsTo('App\Models\Mois','mois_id');
    }

    public function etudiant(){
        return $this->belongsTo('App\Models\Etudiant');
    }
}
