<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EcolageResource extends JsonResource
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
            'montant'=>$this->montant,
            'created'=>date_format($this->created_at,'d/m/Y'),
            //'etudiant'=> new EtudiantResource($this->etudiant),
            'etudiant'=>$this->etudiant,
            'mois'=>$this->mois,
            //'inscription'=>$this->inscription,
            'user'=>$this->user,
        ];
    }
}
