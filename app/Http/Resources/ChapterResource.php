<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
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
            'plan'=>$this->plan,
            'name'=>$this->name,
            'description'=>$this->description,
            'status'=>$this->status,
            'sequence'=>$this->sequence,
            'exercices'=>$this->exercices,
        ];
    }
}
