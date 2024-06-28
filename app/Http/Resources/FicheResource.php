<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FicheResource extends JsonResource
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
            'items'=>FicheItemResource::collection($this->items),
            'emploi'=>new EmploiResource($this->emploi),
            'inscription'=>new InscriptionResource($this->inscription),
            'token'=>$this->token,
            'active'=>$this->active,

        ];
    }
}
