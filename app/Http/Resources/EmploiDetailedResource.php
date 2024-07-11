<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmploiDetailedResource extends JsonResource
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
            'semestre'=>$this->semestre,
            'matiere'=>$this->matiere,
            'start'=>$this->start,
            'end'=>$this->end,
            'day'=>$this->day,
            'salle'=>$this->salle,
            'gap'=>$this->gap,
            'pu'=>$this->pu,
            'enseignant'=>$this->enseignant,
            'ts'=>$this->ts,
            'thr'=>$this->thr,
            'thn'=>$this->thn,
            
        ];
    }
}
