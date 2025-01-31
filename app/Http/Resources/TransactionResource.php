<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'operation'=>new OperationResource($this->operation),
            'compte'=>$this->compte,
            'sens'=>$this->credit?'CREDIT':'DEBIT',
            'montant'=>$this->montant,
            'validated'=>$this->operation->validated_at?true:false,
            'cancelled'=>$this->operation->cancelled_at?true:false,

        ];
    }
}
