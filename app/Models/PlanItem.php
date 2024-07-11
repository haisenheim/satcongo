<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanItem extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'plans_items';

    public function plan(){
        return $this->belongsTo('App\Models\Plan','plan_id');
    }

}
