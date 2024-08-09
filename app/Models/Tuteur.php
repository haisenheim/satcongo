<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuteur extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['name'];

    public function liens(){
        return $this->hasMany('App\Models\Lien');
    }

    public function getQuantityAttribute(){
        return $this->liens->count();
    }

    public function getNameAttribute(){
        return $this->last_name ." ".$this->first_name;
    }
}
