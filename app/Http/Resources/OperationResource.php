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
            'type'=>$this->type?->name,
            'departement_un'=>$this->departement_un?->name,
            'departement_deux'=>$this->departement_deux?->name,
            'demandeur'=>$this->agent?->name,
            'montant'=>number_format($this->montant??0,0,',','.'),
            'libelle'=>$this->libelle,
            'dossier'=>$this->dossier,
            'camion'=>$this->camion,
            'chauffeur'=>$this->chauffeur,
            'peage'=>number_format($this->peage,0,',','.'),
            'hotel'=>number_format($this->hotel,0,',','.'),
            'prime'=>number_format($this->prime,0,',','.'),
            'autre'=>number_format($this->autres,0,',','.'),
            'bac'=>number_format($this->bac,0,',','.'),
            'ration'=>number_format($this->ration,0,',','.'),
            'mt_especes'=>number_format($this->mt_especes,0,',','.'),
            'mt_cheque'=>number_format($this->mt_cheque,0,',','.'),
            'num_cheque'=>$this->num_cheque,0,',','.',
            'client'=>$this->tier?->name,
            'journal'=>$this->caisse?->name,
            'type_id'=>$this->type_id,
            'date'=>Carbon::parse($this->day)->format('d/m/Y')
        ];
    }
}
