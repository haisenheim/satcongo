@extends('Layouts.operateur')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Cogelo</a></li>
       <li class="breadcrumb-item"><a href="#">Producteurs</a></li>
       <li class="breadcrumb-item"><a href="#">Contrats</a></li>
       <li class="breadcrumb-item active" aria-current="page">Liste des contrats producteurs</li>
    </ol>
 </nav>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">Contrats des producteurs</h5>
        <p class="lead">Liste de tous les contrats de mes producteurs </p>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Producteur</th>
                        <th>Saison</th>
                        <th>Tonnage Prévisionnel</th>
                        <th>Tonnage Exécuté</th>
                        <th>Taux d'exécution</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($protocoles as $item)
                        <tr>
                            <td>
                                <div>
                                    <img class="image-25 image-circle" src="{{ $item->cooperative->photo }}" />
                                    <a style="vertical-align:middle" href="{{ route('operateur.cooperatives.show',$item->cooperative_id) }}">{{ $item->cooperative?$item->cooperative->name:'-' }}</a>
                                </div>
                            </td>
                            <td><a href="{{ route('operateur.saisons.show',$item->saison_id) }}">{{ $item->saison?$item->saison->name:'-' }}</a></td>
                            <td>{{ number_format($item->quantity,0,',','.') }} tonne(s)</td>
                            <td>{{ number_format($item->qtyl,0,',','.') }} tonne(s)</td>
                            <td>{{ $item->percentage }}%</td>
                            <td><span class="badge bg-{{ $item->status['color']}}">{{ $item->status['name'] }}</span></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-outline-primary dropdown-toggle hstack gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                                       Actions
                                       <span class="vr"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                       <li><a class="dropdown-item" href="{{ route('operateur.protocoles.show',$item->token) }}">Afficher</a></li>

                                    </ul>
                                 </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        tbody td{
            vertical-align:middle;
        }
    </style>
@endsection
