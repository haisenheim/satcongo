@extends('Layouts.admin')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Satcongo</a></li>
       <li class="breadcrumb-item"><a href="#">Transactions</a></li>
       <li class="breadcrumb-item active" aria-current="page">Historique des transactions</li>
    </ol>
 </nav>
@endsection


@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">Transactions</h5>
        <p class="lead">Historique des transactions</p>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>REFERENCE</th>
                        <th>&numero; de compte</th>
                        <th>Libellé Ecriture</th>
                        <th>Mt Débit</th>
                        <th>Mt Crédit</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection
