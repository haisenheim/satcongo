<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function continent()
    {
        return $this->belongsTo('App\Models\Continent');
    }

}
