<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OperationResource extends JsonResource
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


            'montant'=>number_format($this->montant??0,0,',','.'),
            'libelle'=>$this->libelle,
            'dossier'=>$this->dossier?->code,
            'beneficiaire'=>$this->beneficiaire,
            'agent'=>$this->agent,
            'name'=>$this->name,
            'status'=>$this->status,
            'client'=>$this->client?->name,
            'journal'=>$this->caisse?->name,
            'caisse'=>$this->caisse?->name,
            'date'=>$this->created_at->format('d/m/Y')
        ];
    }
}
