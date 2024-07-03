<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FicheInscriptionResource extends JsonResource
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
            'items'=>FicheItemResource::collection($this->items),
            'inscription'=>new InscriptionResource($this->inscription),
            'token'=>$this->token,
            'active'=>$this->active,
            'status'=>$this->status,

        ];
    }
}
