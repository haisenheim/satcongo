@extends('Layouts.caissier')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Satcongo</a></li>
       <li class="breadcrumb-item"><a href="#">Tableau de bord</a></li>
       <li class="breadcrumb-item active" aria-current="page">Accueil</li>
    </ol>
 </nav>
@endsection

@section('actions')
<div>
<button type="button" class="btn btn-xs btn-outline-primary dropdown-toggle hstack gap-2" data-bs-toggle="dropdown" aria-expanded="false">
    Actions
    <span class="vr"></span>
 </button>
 <ul class="dropdown-menu">
    <li><a class="dropdown-item"  href="{{ route('caissier.operation.print',$item->token) }}">Imprimer</a></li>

 </ul>
</div>
@endsection

@section('page-header')
    <div class="d-flex justify-content-between mt-1">
        <h5 class="page-title mb-0 mt-1 fs-3">Bordereau de saisie de DECAISSEMENT TRANSPORT</h5>

    </div>
@endsection

@section('content')

    <div style="height: 75vh; width: 600px; overflow:scroll; margin:1rem auto;" class="card mt-1">
        <div class="card-body">
            <div class="d-flex gap-2 justify-content-between">
                <div style="float: left">
                    <p><span>DEMANDEUR:</span> <span class="fw-bold">{{ $item->agent?->name }}</span></p>
                </div>
                <div style="float: right">
                    <p><span>DATE:</span> <span class="fw-bold">{{ \Carbon\Carbon::parse($item->day)->format('d/m/Y') }}</span></p>
                </div>
            </div>
            <div class="d-flex gap-2 justify-content-between">
                <div>
                    <p>PEAGE: <span class="fw-800">{{ number_format($item->peage,0,',','.') }}</span></p>
                </div>
                <div>
                    <p>HOTEL: <span class="fw-bold">{{ number_format($item->hotel,0,',','.') }}</span> </p>
                </div>
                <div>
                    <p>RATION: <span class="fw-bold">{{ number_format($item->ration,0,',','.') }}</span> </p>
                </div>
                <div>
                    <p>PRIME: <span class="fw-bold">{{ number_format($item->prime,0,',','.') }}</span> </p>
                </div>
                <div>
                    <p>BAC: <span class="fw-bold">{{ number_format($item->bac,0,',','.') }}</span> </p>
                </div>
                <div>
                    <p>AUTRE: <span class="fw-bold">{{ number_format($item->autre,0,',','.') }}</span> </p>
                </div>
            </div>
            <div>

                <table>
                    <tr>
                        <td style="width:270px;">
                            <p><span>DOSSIER :</span> <span class="fw-bold">{{ $item->dossier }}</span></p>
                        </td>
                        <td style="width:270px;">
                            <p><span>CHAUFFEUR :</span> <span class="fw-bold">{{ $item->chauffeur }}</span></p>
                        </td>
                        <td style="width:270px;">
                            <p><span>CAMION :</span> <span class="fw-bold">{{ $item->camion }}</span></p>
                        </td>
                    </tr>
                </table>
                <p><span>TOTAL MONTANT CHIFFRE :</span> <span class="fw-bold">{{ number_format($mc,0,',','.') }} FCFA</span></p>
                <p><span>TOTAL MONTANT EN LETTRES :</span> <span class="fw-bold">{{ $ml }} Francs cfa</span></p>

            </div>
        </div>
    </div>


@endsection

