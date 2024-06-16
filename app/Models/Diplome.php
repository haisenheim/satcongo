<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diplome extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function etudiants(){
        return $this->hasMany('App\Models\Etudiant');
    }
}
