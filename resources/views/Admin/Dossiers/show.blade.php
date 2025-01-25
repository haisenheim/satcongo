@extends('Layouts.admin')

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
    </div>
@endsection
