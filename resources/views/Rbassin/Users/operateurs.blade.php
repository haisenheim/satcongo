@extends('Layouts.admin')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Satcongo</a></li>
       <li class="breadcrumb-item"><a href="#">Operateurs</a></li>
       <li class="breadcrumb-item active" aria-current="page">Liste des operateurs</li>
    </ol>
 </nav>
@endsection

@section('actions')
    <a href="#" data-bs-target="#addModal" data-bs-toggle="modal" class="btn btn-primary btn-sm"><i class="demo-pli-add me-2 fs-5"></i> Ajouter</a>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">Operateurs</h5>
        <p class="lead">Liste de tous les operateurs</p>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NOM</th>
                        <th>EMAIL</th>
                        <th>PRODUCTEURS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($operateurs as $item)
                        <tr>
                            <td><img class="image-25 image-circle" src="{{ $item->photo }}" alt="{{ $item->name }}"></td>
                            <td><a href="{{ route('admin.operateurs.show',$item->token) }}">{{ $item->name }}</a></td>

                            <td>{{ $item->email }}</td>
                            <td>{{ $item->producteurs->count() }}</td>
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
                    <h5 class="modal-title">Nouvel Operateur</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" action="{{ route('admin.operateurs.store') }}" method="post">
                        @csrf
                            <div class="">
                                <div class="">
                                    <label for="">NOM</label>
                                    <input required type="text" name="name" placeholder="Saisir le nom de l'operateur" class="form-control">
                                </div>
                                <fieldset>
                                    <legend>Infos de connexion</legend>
                                    <div class="">
                                        <label for="">EMAIL</label>
                                        <input required type="email" name="email" placeholder="Saisir l'email de connexion" class="form-control">
                                    </div>
                                    <div class="">
                                        <label for="">MOT DE PASSE</label>
                                        <input required type="password" name="password" placeholder="Saisir le mot de passe" class="form-control">
                                    </div>
                                </fieldset>

                            </div>
                        <div class="mt-5">
                            <button type="submit" class="btn-success btn-sm btn"><i class="pli-save fs-5 me-2"></i> ENREGISTRER</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
