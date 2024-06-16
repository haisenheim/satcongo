<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PointageResource extends JsonResource
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
            'created'=>$this->dt?date_format(Carbon::parse($this->dt),'d/m/Y'):date_format($this->created_at,'d/m/Y'),
            'gap'=>$this->gap,
            'pu'=>$this->pu,
            'pv'=>$this->pv,
            'nb'=>$this->absences->count(),
            'enseignant'=>$this->enseignant,
        ];
    }
}
