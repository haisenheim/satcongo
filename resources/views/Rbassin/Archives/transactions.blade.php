@extends('Layouts.rbassin')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Satcongo</a></li>
       <li class="breadcrumb-item"><a href="#">Archives</a></li>
       <li class="breadcrumb-item active" aria-current="page">Historique des transactions</li>
    </ol>
 </nav>
@endsection


@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">Historique des transactions</h5>
        <p class="lead">Historique de toutes les transactions archivees du bassin </p>
    </div>
@endsection

@section('content')
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
                    @foreach($livraisons as $item)
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
@endsection
