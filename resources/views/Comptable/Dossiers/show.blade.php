@extends('Layouts.comptable')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Satcongo</a></li>
       <li class="breadcrumb-item"><a href="#">Dossiers</a></li>
       <li class="breadcrumb-item active" aria-current="page">{{ $item->name }}</li>
    </ol>
 </nav>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">{{ $item->name }}</h5>
        <p class="lead">Details du dossier</p>
    </div>
@endsection

@section('actions')
    <div class="btn-group">
        <button type="button" class="btn btn-xs btn-outline-primary dropdown-toggle hstack gap-2" data-bs-toggle="dropdown" aria-expanded="false">
        Actions
        <span class="vr"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('comptable.dossier.close',$item->token) }}">Cloturer le dossier</a></li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="d-flex gap-2">
        <div class="card w-300px">
            <div class="card-body">
                <table class="table table-sm table-striped">
                    <tbody>
                        <tr>
                            <td>INTITULE</td>
                            <th>{{ $item->name }}</th>
                        </tr>
                        <tr>
                            <td>CODE</td>
                            <th>{{ $item->code }}</th>
                        </tr>
                        <tr>
                            <td>CLIENT</td>
                            <th>{{ $item->client?->name }}</th>
                        </tr>
                        <tr>
                            <td>DATE DE CREATION</td>
                            <th>{{ $item->created_at->format('d/m/Y H:i') }}</th>
                        </tr>
                        <tr>
                            <td>STATUT</td>
                            <th> <span class="badge bg-{{ $item->status['color'] }}">{{ $item->status['name'] }}</span></th>
                        </tr>
                        @if($item->closed_at)
                        <tr>
                            <td>DATE DE FERMETURE</td>
                            <th>{{ \Carbon\Carbon::parse($item->closed_at)->format('d/m/Y') }}</th>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex-fill" style="height: 500px; overflow:scroll;">
            <div class="card">
                <div class="card-body">
                    <h4>Liste des operations</h4>
                    <table class="table table-sm table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>DATE</th>
                                <th>CAISSE</th>
                                <th>COMPTE</th>
                                <th>MONTANT</th>
                                <th>NATURE DE LA DEPENSE</th>
                                <th>BENEFICIAIRE</th>
                                <th>STATUT</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($item->operations as $operation)
                                <tr>
                                    <td>{{ $operation->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $operation->caisse?->name }}</td>
                                    <td>{{ $operation->compte }}</td>
                                    <td>{{ number_format($operation->montant,0,',','.') }}</td>
                                    <td>{{ $operation->libelle }}</td>
                                    <td>{{ $operation->beneficiaire }}</td>
                                    <td><span class="badge bg-{{ $operation->status['color'] }}">{{ $operation->status['name'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
