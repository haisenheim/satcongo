@extends('Layouts.admin')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Cogelo</a></li>
       <li class="breadcrumb-item"><a href="#">Banques</a></li>
       <li class="breadcrumb-item active" aria-current="page">Liste des banques</li>
    </ol>
 </nav>
@endsection

@section('actions')
    <a href="#" data-bs-target="#addModal" data-bs-toggle="modal" class="btn btn-primary btn-sm"><i class="demo-pli-add me-2 fs-5"></i> Ajouter</a>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">Banques</h5>
        <p class="lead">Liste de toutes les banques partenaires</p>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Banque</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banques as $item)
                        <tr>
                            <td>{{ $item->abb }}</td>
                            <td><a href="{{ route('admin.banks.show',$item->id) }}">{{ $item->name }}</a></td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->email }}</td>
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
                    <h5 class="modal-title">Nouvelle banque partenanire</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.banks.store') }}" method="post">
                        @csrf
                        <fieldset>
                            <legend>Infos de la banque</legend>
                            <div class="d-flex gap-2 flex-grow">
                                <div class=" w-75">
                                    <label for="">NOM</label>
                                    <input type="text" name="name" placeholder="Saisir le nom de la banque" class="form-control">
                                </div>
                                <div class="">
                                    <label for="">SIGLE</label>
                                    <input required type="text" name="abb" placeholder="Saisir le sigle de la banque" class="form-control">
                                </div>
                            </div>
                            <div class="d-flex gap-2 flex-grow">
                                <div class="form-group w-50">
                                    <label for="">Adresse</label>
                                    <input required type="text" name="address" placeholder="Adresse physque de la banque" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Telephone</label>
                                    <input required type="text" name="phone" placeholder="Numero de telephone de la banque" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input required type="email" name="m-email" placeholder="Adresse email de contact" class="form-control">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Infos de connexion du compte utilisateur de la banque</legend>
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
    <style>
        div.form-group{
            margin-top: 1rem;
        }
    </style>
@endsection
