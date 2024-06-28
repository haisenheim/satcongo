<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FicheItem extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'fiche_items';


    public function critere(){
        return $this->belongsTo('App\Models\Critere','critere_id');
    }

    public function fiche(){
        return $this->belongsTo('App\Models\Fiche','fiche_id');
    }
}
