<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuteur extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['quantity'];

    public function etudiants(){
        return $this->hasMany('App\Models\Etudiant');
    }

    public function getQuantityAttribute(){
        return $this->etudiants->count();
    }
}
