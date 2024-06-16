<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EtudiantResource extends JsonResource
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
            'name'=>$this->last_name. " ".$this->first_name,
            'matricule'=>$this->matricule,
            'photo'=>$this->photo,
            'tuteur'=>$this->tuteur,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'pere'=>$this->pere,
            'mere'=>$this->mere,
            'dtn'=>$this->dtn,
            'lieu'=>$this->lieu,
            'classe'=>$this->classe,
            'token'=>$this->token,
            'age'=>$this->age,
            'pays'=>$this->pay?$this->pay->name:'',
            'diplome'=>$this->diplome?$this->diplome->name:'',
        ];
    }
}
