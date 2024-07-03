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

    public function getAnswerCodeAttribute(){
        $res = 0;

        if($this->vdiscontented){
            $res = -2;
        }
        if($this->discontented){
            $res = -1;
        }

        if($this->happy){
            $res = 1;
        }
        if($this->vhappy){
            $res = 2;
        }
        return $res;
    }

    public function getFilledAttribute(){
        if($this->answer_code !=0){
            return true;
        }
        return false;
    }
}
