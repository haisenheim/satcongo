<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursResource extends JsonResource
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
            'coef'=>$this->coefficient,
            'credits'=>$this->credits,
        ];
    }
}
