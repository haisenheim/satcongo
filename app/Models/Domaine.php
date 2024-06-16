<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domaine extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function livres(){
        return $this->hasMany('App\Models\Livre');
    }
}
