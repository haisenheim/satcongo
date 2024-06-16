<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EvaluationResource extends JsonResource
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
            'periodicite'=>$this->periodicite,
            'type'=>$this->type,
            'semestre'=>$this->semestre,
            'pourcentage'=>$this->pourcentage,
            'mois'=>$this->mois,
        ];
    }
}
