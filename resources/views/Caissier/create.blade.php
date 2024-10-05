@extends('Layouts.caissier')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Cogelo</a></li>
       <li class="breadcrumb-item"><a href="#">Operations</a></li>
       <li class="breadcrumb-item active" aria-current="page">Nouvelle operation</li>
    </ol>
 </nav>
@endsection
@section('actions')
    <a href="#" data-bs-target="#addModal" data-bs-toggle="modal" class="btn btn-primary btn-sm"><i class="demo-pli-add me-2 fs-5"></i> Ajouter une saisie</a>
@endsection



@section('content')
    <div style="width: 400px; margin:1px auto;" class="card">

        <div id="form" class="card-body">
            <h4 class="card-title text-blue">Formulaire de creation</h4>
            <form method="POST" action="{{ route('caissier.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="text-blue fs-6 fw-bolder" for="">CAISSE</label>
                    <select class="form-control" name="caisse_id" id="caisse_id">
                        <option value=0>SELECTIONNER UNE CAISSE ...</option>
                        @foreach($caisses as $caisse)
                          <option value="{{ $caisse->id }}">{{ $caisse->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                        <label class="text-blue fs-6 fw-bolder" for="">DATE</label>
                        <input required type="date" name="day" id="day" class="form-control">
                </div>
                <div class="mb-2">
                        <label class="text-blue fs-6 fw-bolder" for="">REFERENCE</label>
                        <input required type="text" id="ref" name="ref" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="text-blue fs-6 fw-bolder" for="">TIERS</label>
                    <select required class="form-control" name="tier_id" id="tier_id">
                        <option value="">SELECTIONNER UN TIERS ...</option>
                        @foreach($tiers as $tier)
                          <option value="{{ $tier->id }}">{{ $tier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label class="text-blue fs-6 fw-bolder" for="">COMPTE</label>
                    <input required type="text" name="compte" class="form-control">
                </div>
                <div class="mb-2">
                    <label class="text-blue fs-6 fw-bolder" for="">&numero; FCATURE</label>
                    <input required type="text" name="facture" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="text-blue fs-6 fw-bolder" for="">LIBELLE DE L'ECRITURE</label>
                    <select required class="form-control" name="libelle_id" id="lib_id">
                        <option value="">SELECTIONNER UNE ECRITURE ...</option>
                        @foreach($libelles as $libelle)
                          <option value="{{ $libelle->id }}">{{ $libelle->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="text-blue fs-6 fw-bolder" for="">SENS DE L'OPERATION</label>
                    <select required class="form-control" name="sens" id="sens">
                            <option value="">SELECTIONNER LE TYPE D'OPERATION ...</option>
                            <option value="1">ENTREE</option>
                            <option value="2">SORTIE</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="text-blue fs-6 fw-bolder" for="">MONTANT</label>
                    <input required type="text" name="montant" id="montant" class="form-control">
                </div>
                <div class="">
                    <button type="submit" id="btn-save" class="btn btn-primary"><i class="fs-5 pli-save"></i> ENREGISTRER</button>
                </div>
            </form>
        </div>
        <div class="card-footer">

        </div>
    </div>
    <div class="modal fade" id="addModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title">Nouvelle Saisie</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" id="btn-close" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div>
                            <label for="">CREDIT/DEBIT</label>
                            <select class="form-control" id="type_id">
                                <option value="">SELECTIONNER LE TYPE D'OPERATION ...</option>
                                <option value=0>DEBIT</option>
                                <option value=1>CREDIT</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="">COMPTE</label>
                            <select name="compte_id" required class="form-control" id="compte_id">
                                <option value="">SELECTIONNER LE COMPTE ...</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="">MONTANT</label>
                            <input name="montant" type="text" id="montant" required placeholder="Saisir le montant de l'operation" class="form-control">
                        </div>
                        <div class="mt-2">
                            <button id="btn-add" class="btn btn-primary btn-sm"><i class="fs-5 pli-add"></i> Ajouter</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <style>
        legend{
            margin-bottom: 0;
        }
    </style>
@endsection
