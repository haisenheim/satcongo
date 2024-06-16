<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annee extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['day'];
    public function inscriptions(){
        return $this->hasMany('App\Models\Inscription','annee_id');
    }
}
