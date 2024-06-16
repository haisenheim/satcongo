<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LivreResource extends JsonResource
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
            'name'=>$this->name,
            'annee'=>$this->annee,
            'auteur'=>$this->auteur,
            'description'=>$this->description,
            'photo'=>$this->photo,
            'path'=>$this->path,
            'token'=>$this->token,
            'active'=>$this->active,
            'domaine'=>$this->domaine?$this->domaine->code:'',
        ];
    }
}
