<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Critere extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function items(){
        return $this->hasMany('App\Models\FicheItem','critere_id');
    }
}
