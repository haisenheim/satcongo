<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnseignantResource extends JsonResource
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
            'name'=>$this->last_name." ".$this->first_name,
            'matricule'=>$this->matricule,
            'photo'=>$this->photo,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'address'=>$this->address,
            'age'=>$this->age,
            'classe'=>$this->classe,
            'token'=>$this->token,
            'pays'=>$this->pay?$this->pay->name:'',
            'diplome'=>$this->diplome?$this->diplome->name:'',
        ];
    }
}
