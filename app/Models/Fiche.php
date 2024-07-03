<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fiche extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function enseignant(){
        return $this->belongsTo('App\Models\Enseignant');
    }

    public function etudiant(){
        return $this->belongsTo('App\Models\Etudiant');
    }

    public function inscription(){
        return $this->belongsTo('App\Models\Inscription');
    }

    public function items(){
        return $this->hasMany('App\Models\FicheItem','fiche_id');
    }

    public function filiere(){
        return $this->belongsTo('App\Models\Filiere');
    }

    public function cours(){
        return $this->belongsTo('App\Models\Cours','cours_id');
    }

    public function matiere(){
        return $this->belongsTo('App\Models\Matiere');
    }

    public function annee(){
        return $this->belongsTo('App\Models\Annee');
    }

    public function emploi(){
        return $this->belongsTo('App\Models\Emploi');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function getAnswerCodeAttribute(){
        $items = $this->items;
        $codes =[
            '-2'=>['count'=>0,'avg'=>0,'label'=>'vdiscontented'],
            '-1'=>['count'=>0,'avg'=>0,'label'=>'discontented'],
            '0'=>['count'=>0,'avg'=>0,'label'=>'undefined'],
            '1'=>['count'=>0,'avg'=>0,'label'=>'happy'],
            '2'=>['count'=>0,'avg'=>0,'label'=>'vhappy']
        ];
        $count = $items->count();
        foreach($items as $item){
            $codes[$item->answer_code]['count'] +=1;
            $codes[$item->answer_code]['avg'] =$count?$codes[$item->answer_code]['count']/$count:0;
        }
        return $codes;
    }

}
