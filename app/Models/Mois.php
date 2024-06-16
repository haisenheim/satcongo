<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mois extends Model
{
    use HasFactory;
    protected $table = 'mois';

    public function ecolages(){
        return $this->hasMany('App\Models\Ecolage','mois_id');
    }
}
