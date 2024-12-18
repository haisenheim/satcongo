@extends('Layouts.rbassin')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Satcongo</a></li>
       <li class="breadcrumb-item"><a href="#">Coopératives</a></li>
       <li class="breadcrumb-item active" aria-current="page">Liste des coopératives</li>
    </ol>
 </nav>
@endsection
@section('actions')
    <a href="#" data-bs-target="#addModal" data-bs-toggle="modal" class="btn btn-primary btn-sm"><i class="demo-pli-add me-2 fs-5"></i> Ajouter</a>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">Coopératives</h5>
        <p class="lead">Liste de toutes les coopératives du bassin</p>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cooperative</th>
                        <th>Telephone</th>
                        <th>Arrondissement</th>
                        <th>Departement</th>
                        <th>Region</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cooperatives as $item)
                        <tr>
                            <td>
                                <img src="{{ $item->photo }}" class="image-25 image-circle" alt="">
                            </td>
                            <td><a href="{{ route('rbassin.cooperatives.show',$item->token) }}">{{ $item->name }}</a></td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->arrondissement?$item->arrondissement->name:'-' }}</td>
                            <td>{{ $item->departement?$item->departement->name:'-' }}</td>
                            <td>{{ $item->region?$item->region->name:'-' }}</td>
                            <td></td>
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
                    <h5 class="modal-title">Nouvelle coopérative</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" action="{{ route('rbassin.cooperatives.store') }}" method="post">
                        @csrf
                        <fieldset>
                            <legend>Infos de la cooperative</legend>
                            <div class="d-flex gap-2 flex-grow">
                                <div class=" w-75">
                                    <label for="">NOM</label>
                                    <input type="text" name="name" placeholder="Saisir le nom de la cooperative" class="form-control">
                                </div>
                                <div class="">
                                    <label for="">Logo/Photo</label>
                                    <input required type="file" name="photo" class="form-control">
                                </div>
                            </div>
                            <div class="d-flex gap-2 form-group">
                                <div class="w-25">
                                    <label for="">DATE DE CREATION</label>
                                    <input type="date" name="dtn" placeholder="Saisir le nom de la cooperative" class="form-control">
                                </div>
                                <div class="">
                                    <label for="">Immatriculation</label>
                                    <input required type="text" name="immatriculation" class="form-control">
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
                            <div class="d-flex gap-2 flex-grow">
                                <div class="form-group w-50">
                                    <label for="">Adresse</label>
                                    <input required type="text" name="address" placeholder="Adresse physque de la cooperative" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Telephone</label>
                                    <input required type="text" name="phone" placeholder="Numero de telephone de la cooperative" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input required type="email" name="m-email" placeholder="Adresse email de contact" class="form-control">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Infos de connexion du compte utilisateur de la coopérative</legend>
                            <div class="d-flex gap-2 flex-grow">
                                <div class=" w-75">
                                    <label for="">NOM DE L'UTILISATEUR</label>
                                    <input required type="text" name="username" placeholder="Saisir le nom de l'utilisateur" class="form-control">
                                </div>
                            </div>
                            <div class="d-flex gap-2 flex-grow">
                                <div class="form-group w-50">
                                    <label for="">EMAIL DE CONNEXION</label>
                                    <input required type="email" name="email" placeholder="Saisir l'adresse email de connexion de l'utilisateur" class="form-control">
                                </div>
                                <div class="form-group w-50">
                                    <label for="">MOT DE PASSE</label>
                                    <input required type="password" name="password" placeholder="Saisir le mot de passe de connexion de l'utilisateur" class="form-control">
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
