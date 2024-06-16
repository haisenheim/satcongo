<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnneeResource extends JsonResource
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
            'start'=>$this->start,
            'end'=>$this->end,
            'day'=>Carbon::parse($this->day)->format('d/m/Y'),
            'token'=>$this->token,
            'active'=>$this->active,

        ];
    }
}
