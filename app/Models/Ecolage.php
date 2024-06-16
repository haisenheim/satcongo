<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecolage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function etudiant(){
        return $this->belongsTo('App\Models\Etudiant');
    }

    public function inscription(){
        return $this->belongsTo('App\Models\Inscription');
    }

    public function filiere(){
        return $this->belongsTo('App\Models\Filiere');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function mois(){
        return $this->belongsTo('App\Models\Mois','mois_id');
    }


}
