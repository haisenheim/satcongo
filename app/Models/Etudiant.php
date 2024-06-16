<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dates =['dtn'];

    protected $appends = ['classe','age','name'];

    public function inscriptions(){
        return $this->hasMany('App\Models\Inscription','etudiant_id');
    }

    public function getClasseAttribute(){
        $inscription = $this->inscriptions->last();
        //dd($inscription);
        if($inscription){
            if($inscription->filiere){
                return $inscription->filiere->code. "" .$inscription->niveau_id. " - " .$inscription->created_at->format('d/m/Y');
            }
        }

       return "-";
    }

    public function diplome(){
        return $this->belongsTo('App\Models\Diplome');
    }

    public function getNameAttribute(){
        return $this->last_name." ".$this->first_name;
    }

    public function tuteur(){
        return $this->belongsTo('App\Models\Tuteur');
    }

    public function pay(){
        return $this->belongsTo('App\Models\Pay');
    }

    public function ecolages(){
        return $this->hasMany('App\Models\Ecolage');
    }

    public function getPhotoAttribute(){
		if($this->image_uri){
			return request()->getSchemeAndHttpHost().'/img/'.$this->image_uri;
		}else{
			return null;
		}
	}

    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['dtn'])->age;
    }
}
