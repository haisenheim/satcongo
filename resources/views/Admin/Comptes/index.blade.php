@extends('Layouts.admin')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Satcongo</a></li>
       <li class="breadcrumb-item"><a href="#">Comptes</a></li>
       <li class="breadcrumb-item active" aria-current="page">Liste des comptes</li>
    </ol>
 </nav>
@endsection

@section('actions')
    <a href="#" data-bs-target="#addModal" data-bs-toggle="modal" class="btn btn-primary btn-sm"><i class="demo-pli-add me-2 fs-5"></i> Ajouter</a>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">Comptes</h5>
        <p class="lead">Liste de tous les comptes</p>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Libelle</th>
                        <th>Type</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->credit?'Credit':'Debit' }}</td>
                            <td><a class="btn btn-xs btn-danger" href="{{ route('admin.compte.delete',$item->id) }}">supprimer</a></td>
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
                    <h5 class="modal-title">Nouveau compte</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.comptes.store') }}" method="post">
                        @csrf
                        <div class="mt-2">
                            <label for="">Numero du compte</label>
                            <input type="text" required name="code" placeholder="Numero du compte" class="form-control">
                        </div>
                        <div class="mt-2">
                            <label for="">Intitule du compte</label>
                            <input type="text" name="name" required placeholder="Numero du compte" class="form-control">
                        </div>
                        <div class="mt-2">
                            <label for="">Credit/debit</label>
                           <select class="form-control" name="credit" id="">
                                <option value="1">CREDIT</option>
                                <option value="0">DEBIT</option>
                           </select>
                        </div>
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
