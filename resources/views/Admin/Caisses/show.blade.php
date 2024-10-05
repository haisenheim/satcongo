@extends('Layouts.admin')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Cogelo</a></li>
       <li class="breadcrumb-item"><a href="#">Caisses</a></li>
       <li class="breadcrumb-item active" aria-current="page">{{ $item->name }}</li>
    </ol>
 </nav>
@endsection

@section('actions')
    <a href="#" data-bs-target="#addModal" data-bs-toggle="modal" class="btn btn-primary btn-sm"><i class="demo-pli-add me-2 fs-5"></i> Ajouter un compte</a>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">{{ $item->name }}</h5>
        <p class="lead">Details sur la caisse</p>
    </div>
@endsection

@section('content')
    <div class="d-flex gap-1">
        <div class="card w-25">
            <div class="card-body">
                <h5>CAISSE : {{ $item->name }}</h5>
                <h5>COMPTE : {{ $item->compte }}</h5>
                <h6>AGENCE : {{ $item->agence->name }} / {{ $item->ville->name }}</h6>
                <h6>OPERATEUR : {{ $item->user?$item->user->name:'-' }}</h6>
            </div>
        </div>
        <div class="card w-75">
            <div class="card-body">
                
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title">Associer un compte</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" action="{{ route('admin.caisse.set.compte') }}" method="post">
                        @csrf
                        <input type="hidden" name="caisse_id" value="{{ $item->id }}">
                        <div class="mt-3">
                            <label for="">Compte</label>
                            <input type="texte" name="compte" placeholder="Saisir le numro de compte ici ..." class="form-control">
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
