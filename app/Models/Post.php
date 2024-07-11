<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];
    //

    public function category(){
        return $this->belongsTo('App\Models\PostCategory','category_id');
    }

    public function getPhotoAttribute(){
		if($this->image_uri){
			return request()->getSchemeAndHttpHost().$this->image_uri;
		}else{
			return null;
		}
	}

    public function getDocAttribute(){
		if($this->doc_uri){
			return request()->getSchemeAndHttpHost().'/storage/'.$this->doc_uri;
		}else{
			return null;
		}
	}

    public function getVideoAttribute(){
		if($this->video_uri){
			return request()->getSchemeAndHttpHost().'/storage/'.$this->video_uri;
		}else{
			return null;
		}
	}

    public function getStatusAttribute(){
        $data['color'] = 'bg-success';
        $data['name'] = 'en ligne';
        if(!$this->active){
            $data['color'] = 'bg-danger';
            $data['name'] = 'hors ligne';
        }
        return $data;
    }
}
