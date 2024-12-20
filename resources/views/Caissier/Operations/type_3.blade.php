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
        <h5 class="page-title mb-0 mt-1 fs-3">Bordereau de saisie de DECAISSEMENT TRANSIT</h5>
    </div>
@endsection

@section('content')
    <div style="height: 75vh; width: 600px; margin:1rem auto; overflow:scroll;" class="card mt-1">
        <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div style="float: left">
                        <p><span>DEMANDEUR:</span> <span class="fw-bold">{{ $item->agent?->name }}</span></p>
                    </div>
                    <div style="float: right">
                        <p><span>DATE:</span> <span class="fw-bold">{{ \Carbon\Carbon::parse($item->day)->format('d/m/Y') }}</span></p>
                    </div>
                </div>

                <table class="table" style="margin-top:1rem">
                    <tbody>
                        <tr>
                            <td class="w-half">
                                <div style="float: left">
                                    <p><span>CLIENT:</span> <span class="fw-bold">{{ $item->tier?->name }}</span></p>
                                </div>
                            </td>
                            <td class="w-half">
                                <div style="float: right">
                                    <p><span>DOSSIER:</span> <span class="fw-bold">{{ $item->dossier }}</span></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p><span>LIBELLE :</span> <span class="fw-bold">{{ $item->libelle }}</span></p>
                <p><span>TOTAL MONTANT CHIFFRE :</span> <span class="fw-bold">{{ number_format($mc,0,',','.') }} FCFA</span></p>
                <p><span>TOTAL MONTANT EN LETTRES :</span> <span class="fw-bold">{{ $ml }} Francs cfa</span></p>

                <table>
                    <tr>
                        <td style="width:270px;">
                            <p><span>ESPECE :</span> <span class="fw-bold">{{ number_format($item->mt_especes,0,',','.') }} FCFA</span></p>
                        </td>
                        <td style="width:270px;">
                            <p><span>CHEQUE :</span> <span class="fw-bold">{{ number_format($item->mt_cheque,0,',','.') }} FCFA</span></p>
                        </td>
                        <td style="width:270px;">
                            <p><span>N° CHEQUE :</span> <span class="fw-bold">{{ $item->num_cheque }}</span></p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
@endsection

