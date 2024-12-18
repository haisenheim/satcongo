@extends('Layouts.admin')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Satcongo</a></li>
       <li class="breadcrumb-item"><a href="#">Operateurs</a></li>
       <li class="breadcrumb-item active" aria-current="page">{{ $operateur->name }}</li>
    </ol>
 </nav>
@endsection

@section('actions')
    <a href="#" data-bs-target="#addModal" data-bs-toggle="modal" class="btn btn-primary btn-sm"><i class="demo-pli-add me-2 fs-5"></i> Lier un producteur</a>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">{{ $operateur->name }}</h5>
        <p class="lead">Fiche de l'operateur</p>
    </div>
@endsection

@section('content')
    <div class="d-flex gap-2">
        <div class="card w-25">
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ $operateur->photo }}" class="image-50 image-circle" alt="">
                </div>
                <div class="mt-2 details">
                    <p>NOM : <span>{{ $operateur->name }}</span></p>
                    <p>EMAIL : <span>{{ $operateur->email }}</span></p>
                    <p>PRODUCTEURS : <span>{{ $operateur->producteurs->count() }}</span></p>
                </div>
            </div>
        </div>
        <div class="card w-75">
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
                        @foreach($operateur->producteurs as $item)
                            <tr>
                                <td>
                                    <img src="{{ $item->photo }}" class="image-25 image-circle" />
                                </td>
                                <td><a href="{{ route('admin.cooperatives.show',$item->id) }}">{{ $item->name }}</a></td>
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
    </div>


    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title">Nouvelle liasion</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" action="{{ route('admin.operateur.cooperative') }}" method="post">
                        @csrf
                            <div class="form-group">
                                <input type="hidden" name="operateur_id" value="{{ $operateur->id }}" />
                                <div>
                                    <label for="">REGION</label>
                                    <select required name="region_id" id="region_id" class="form-control">
                                        <option value="">Selectionner une region</option>
                                        @foreach($regions as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">DEPARTEMENT</label>
                                    <select required name="departement_id" id="departement_id" class="form-control">
                                        <option value="">Selectionner un departement</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">ARRONDISSEMENT</label>
                                    <select required name="arrondissement_id" id="arrondissement_id" class="form-control">
                                        <option value="">Selectionner un arrondissement</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">COOPERATIVE</label>
                                    <select required name="producteur_id" id="cooperative_id" class="form-control">
                                        <option value="">Selectionner une cooperative ...</option>
                                    </select>
                                </div>
                            </div>
                        <div class="mt-5">
                            <button type="submit" class="btn-success btn-sm btn"><i class="pli-save fs-5 me-2"></i> ENREGISTRER</button>
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

            $('#arrondissement_id').change(function(){
                var _id = $('#arrondissement_id').val();
                $.ajax({
                    url:"{{ route('util.arrondissement.cooperatives') }}",
                    type:'get',
                    dataType:'json',
                    data:{id:_id},
                    success:function(data){
                        $('#cooperative_id').html("<option value=0>Choisir une cooperative...</option>");
                        data.forEach(element => {
                            $('#cooperative_id').append(`<option value=${element.id}>${element.name}</option>`);
                        });
                    },
                    error:function(err){
                        console.log(err)
                    }
                });
            })
        })
    </script>
@endsection
