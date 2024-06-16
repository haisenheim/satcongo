<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'niveaux';

    public function inscriptions(){
        return $this->hasMany('App\Models\Inscription','niveau_id');
    }

}
