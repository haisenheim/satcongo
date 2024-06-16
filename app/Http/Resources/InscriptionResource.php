<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InscriptionResource extends JsonResource
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
            'token'=>$this->token,
            'filiere'=>$this->filiere,
            'niveau_id'=>$this->niveau_id,
            'etudiant'=>new EtudiantResource($this->etudiant),
            'date'=>date_format($this->created_at,'d/m/Y H:i'),
            'filiere_id'=>$this->filiere_id,
        ];
    }
}
