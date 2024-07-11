<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'date'=>date_format($this->created_at,'d/m/Y H:i'),
            'photo'=>$this->photo,
            'doc'=>$this->doc,
            'video'=>$this->video,
            'description'=>$this->description,
            'category'=>$this->category,
            'status'=>$this->status,
            'token'=>$this->token,
        ];
    }
}
