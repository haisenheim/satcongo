@extends('Layouts.rbassin')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Cogelo</a></li>
       <li class="breadcrumb-item"><a href="#">Client</a></li>
       <li class="breadcrumb-item active" aria-current="page">{{ $item->name }}</li>
    </ol>
 </nav>
@endsection


@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">{{ $item->name }}</h5>
        <p class="lead">Infos sur le client {{ $item->name }} </p>
    </div>
@endsection

@section('content')
    <div class="d-flex gap-2">
        <div class="card w-25">
            <div class="card-body">
                <div class="d-flex gap-2">
                    <div class="d-flex justify-content-center flex-column">
                        <img style="vertical-align: middle" class="image-circle image-thumnail image-75"  src="{{ $item->photo }}" alt="">
                    </div>
                    <div id="d-text" class="d-flex justify-content-center flex-column">
                        <p>CLIENT : {{ $item->name }}</p>
                        <p>Adresse : <span class="badge bg-dark">{{ $item->address }} </span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Acheteur</th>
                            <th>Producteur</th>
                            <th>Quantité</th>
                            <th>Prix/kg</th>
                            <th>Total</th>
                            <th>Lieu de ramassage</th>
                            <th>Saison</th>
                            <th>Status</th>
                            <th>Validé le</th>
                            <th>Livré le</th>
                            <th>Cloturé le</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($item->livraisons->where('departement_id',auth()->user()->departement_id) as $item)
                            <tr>
                                <td><a href="{{ route('rbassin.clients.show',$item->client_id) }}">{{ $item->client?$item->client->name:'-' }}</a></td>
                                <td><a href="{{ route('rbassin.cooperatives.show',$item->cooperative_id) }}">{{ $item->cooperative?$item->cooperative->name:'-' }}</a></td>
                                <td>{{ number_format($item->quantity,0,',','.') }} tonne(s)</td>
                                <td>{{ number_format($item->price,0,',','.') }} fcfa</td>
                                <td>{{ number_format($item->total,0,',','.') }} fcfa</td>
                                <td>{{ $item->village?$item->village->name:$item->arrondissement->name }}</td>
                                <td><a href="{{ route('rbassin.saisons.show',$item->saison_id) }}">{{ $item->saison?$item->saison->name:'-' }}</a></td>
                                <td><span class="badge bg-{{ $item->status['color']}}">{{ $item->status['name'] }}</span></td>
                                <td>{{ $item->accepted_at?$item->accepted_dt->format('d/m/Y'):'-' }}</td>
                                <td>{{ $item->delivered_at?$item->delivered_dt->format('d/m/Y'):'-' }}</td>
                                <td>{{ $item->closed_at?$item->closed_dt->format('d/m/Y'):'-' }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection
