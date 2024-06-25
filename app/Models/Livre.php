<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;
    protected $guarded = [];
    //

    public function domaine(){
        return $this->belongsTo('App\Models\Domaine');
    }

    public function getPhotoAttribute(){
		if($this->image_uri){
			return request()->getSchemeAndHttpHost().'/storage/'.$this->image_uri;
		}else{
			return null;
		}
	}

    public function getPathAttribute(){
		if($this->image_uri){
			return request()->getSchemeAndHttpHost().'/storage/'.$this->doc_uri;
		}else{
			return null;
		}
	}
}
