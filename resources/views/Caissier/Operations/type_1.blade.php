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
        <h5 class="page-title mb-0 mt-1 fs-3">Bordereau de saisie de DECAISSEMENT</h5>
    </div>
@endsection

@section('content')

    <div style="height: 75vh; width: 500px; margin:1rem auto; overflow:scroll;" class="card mt-1">
        <div class="card-body">
            <div class="d-flex gap-2 justify-content-between">
                <div style="float: left">
                    <p><span>DEMANDEUR:</span> <span class="fw-bold">{{ $item->agent?->name }}</span></p>
                </div>
                <div style="float: right">
                    <p><span>DATE:</span> <span class="fw-bold">{{ \Carbon\Carbon::parse($item->day)->format('d/m/Y') }}</span></p>
                </div>
            </div>
            <table class="table" style="margin-top: 3rem;">
                <tr class="w-full">
                    <td class="w-half">
                        <div class="d-flex justify-content-between">
                            <p><span>DEP 1:</span> <span class="fw-bold">{{ $item->departement_un?->name }}</span></p>
                            <div style="width: 100px; height: 20px; border: 2px #000 solid; float: left;">

                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="table" style="margin-top: 3rem;">
                <tr class="w-full">
                    <td class="w-half">
                        <div class="d-flex justify-content-between">
                            <p><span>DEP 2:</span> <span class="fw-bold">{{ $item->departement_deux?->name }}</span></p>
                            <div style="width: 100px; height: 20px; border: 2px #000 solid; float: left;">

                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="">
                <p><span>NATURE DE LA DEPENSE :</span> <span class="fw-bold">{{ $item->libelle }}</span></p>
                <p><span>DOSSIER :</span> <span class="fw-bold">{{ $item->dossier?->code }}</span></p>
                <p><span>P/C :</span> <span class="fw-bold">{{ $item->dossier?->client?->name }}</span> </p>
                <p><span>TOTAL MONTANT CHIFFRE :</span> <span class="fw-bold">{{ number_format($mc,0,',','.') }} FCFA</span></p>
                <p><span>TOTAL MONTANT EN LETTRES :</span> <span class="fw-bold">{{ $ml }} Francs cfa</span></p>
            </div>
        </div>
    </div>



<style>
    .type_1{
        background-color: rgb(201, 242, 229);
    }
    .type_2{
        background-color: rgb(246, 238, 207);
    }
    .type_3{
        background-color: rgb(203, 231, 241);
    }
</style>
@endsection

