<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FicheItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'critere'=>$this->critere,
            'vdiscontented'=>$this->discontented?true:false,
            'discontented'=>$this->discontented?true:false,
            'happy'=>$this->happy?true:false,
            'vhappy'=>$this->vhappy?true:false,
            'active'=>$this->active,
        ];
    }
}
