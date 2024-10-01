@extends('Layouts.rbassin')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Cogelo</a></li>
       <li class="breadcrumb-item"><a href="#">Acheteurs</a></li>
       <li class="breadcrumb-item"><a href="#">Contrats</a></li>
       <li class="breadcrumb-item active" aria-current="page">Liste des contrats acheteurs</li>
    </ol>
 </nav>
@endsection


@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">Contrats des acheteurs</h5>
        <p class="lead">Liste de tous les contrats des acheteurs </p>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Acheteur</th>
                        <th>Saison</th>
                        <th>Tonnage Prévisionnel</th>
                        <th>Tonnage Exécuté</th>
                        <th>Taux d'exécution</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contrats as $item)
                        <tr>
                            <td><a href="{{ route('rbassin.clients.show',$item->client->token) }}">{{ $item->client?$item->client->name:'-' }}</a></td>
                            <td><a href="#">{{ $item->saison?$item->saison->name:'-' }}</a></td>
                            <td>{{ number_format($item->quantity,0,',','.') }} tonne(s)</td>
                            <td>{{ number_format($item->qtyl,0,',','.') }} tonne(s)</td>
                            <td>{{ $item->percentage }}%</td>
                            <td><span class="badge bg-{{ $item->status['color']}}">{{ $item->status['name'] }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title">Nouveau contrat acheteur</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" action="{{ route('rbassin.contrats.store') }}" method="post">
                        @csrf
                            <div class="">
                                <div class="form-group">
                                    <label for="">Acheteur</label>
                                    <select required name="client_id"  class="form-control">
                                        <option value="">Selectionner un acheteur ...</option>
                                        @foreach($clients as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Saison</label>
                                    <select required name="saison_id"  class="form-control">
                                        <option value="">Selectionner une saison ...</option>
                                        @foreach($saisons as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Tonnage attendu</label>
                                    <input required type="number" name="quantity" placeholder="Saisir la quantite de tonnes attendue" class="form-control">
                                </div>
                            </div>
                        <div class="mt-5">
                            <button type="submit" class="btn-primary btn">ENREGISTRER</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
