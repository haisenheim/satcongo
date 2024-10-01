@extends('Layouts.rbassin')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Cogelo</a></li>
       <li class="breadcrumb-item"><a href="#">Villages</a></li>
       <li class="breadcrumb-item active" aria-current="page">Liste des arrondissements</li>
    </ol>
 </nav>
@endsection

@section('actions')
    <a href="#" data-bs-target="#addModal" data-bs-toggle="modal" class="btn btn-primary btn-sm"><i class="demo-pli-add me-2 fs-5"></i> Ajouter</a>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">Villages</h5>
        <p class="lead">Liste de tous les villages du bassin</p>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Village</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Arrondissement</th>
                        <th>Departement</th>
                        <th>Region</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($villages as $item)
                        <tr>
                            <td><a href="{{ route('rbassin.villages.show',$item->id) }}">{{ $item->name }}</a></td>
                            <td>{{ $item->latitude }}</td>
                            <td>{{ $item->longitude }}</td>
                            <td>{{ $item->arrondissement?$item->arrondissement->name:'-' }}</td>
                            <td>{{ $item->departement?$item->departement->name:'-' }}</td>
                            <td>{{ $item->region?$item->region->name:'-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title">Nouveau Village</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" action="{{ route('rbassin.villages.store') }}" method="post">
                        @csrf
                            <div class="d-flex gap-2 flex-grow mb-3">
                                <div class=" w-50">
                                    <label for="">NOM</label>
                                    <input type="text" name="name" placeholder="Saisir le nom du departement" class="form-control">
                                </div>
                                
                                <div>
                                    <label for="">ARRONDISSEMENT</label>
                                    <select required name="arrondissement_id" id="arrondissement_id" class="form-control">
                                        <option value="">Selectionner un arrondissement</option>
                                        @foreach($arrondissements as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <fieldset>
                                <legend>Coordonnées GPS</legend>
                                <div class="d-flex gap-2">
                                    <div class="w-50">
                                        <label for="">Latitude</label>
                                        <input type="text" name="latitude" placeholder="Saisir la latitude" class="form-control">
                                    </div>
                                    <div class=" w-50">
                                        <label for="">Longitude</label>
                                        <input type="text" name="longitude" placeholder="Saisir la longitude" class="form-control">
                                    </div>
                                </div>
                            </fieldset>
                        <div class="mt-5">
                            <button type="submit" class="btn-primary btn">ENREGISTRER</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('#region_id').change(function(){
                 var _id = $('#region_id').val();
                $.ajax({
                    url: "{{ route('util.region.departements') }}",
                    type:'get',
                    dataType:'json',
                    data:{id:_id},
                    success:function(data){
                        $('#departement_id').html("<option value=0>Choisir un departement ...</option>");
                        data.forEach(element => {
                            $('#departement_id').append(`<option value=${element.id}>${element.name}</option>`);
                        });

                    },
                    error:function(err){
                        console.log(err)
                    }
                });
            })

            $('#departement_id').change(function(){
                var _id = $('#departement_id').val();
                $.ajax({
                    url:"{{ route('util.departement.arrondissements') }}",
                    type:'get',
                    dataType:'json',
                    data:{id:_id},
                    success:function(data){
                        $('#arrondissement_id').html("<option value=0>Choisir un arrondissement ...</option>");
                        data.forEach(element => {
                            $('#arrondissement_id').append(`<option value=${element.id}>${element.name}</option>`);
                        });

                    },
                    error:function(err){
                        console.log(err)
                    }
                });
            })
        })
    </script>

    <style>
        .form-group{
            margin-top: 1rem;
        }
    </style>
@endsection
