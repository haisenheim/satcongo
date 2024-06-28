<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dates =['dtn'];
    protected $appends = ['name'];

    public function cours(){
        return $this->hasMany('App\Models\Cours','enseignant_id');
    }


    public function diplome(){
        return $this->belongsTo('App\Models\Diplome');
    }


    public function pay(){
        return $this->belongsTo('App\Models\Pay');
    }

    public function getNameAttribute(){
		return $this->last_name." ".$this->first_name;
	}

    public function fiches(){
        return $this->hasMany('App\Models\Fiche');
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
