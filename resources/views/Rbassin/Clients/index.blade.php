@extends('Layouts.rbassin')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Satcongo</a></li>
       <li class="breadcrumb-item"><a href="#">Acheteurs</a></li>
       <li class="breadcrumb-item active" aria-current="page">Liste des Acheteurs</li>
    </ol>
 </nav>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">Acheteurs</h5>
        <p class="lead">Liste de tous les clients</p>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Acheteurs</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Origine</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $item)
                        <tr>
                            <td><a href="{{ route('rbassin.clients.show',$item->token) }}">{{ $item->name }}</a></td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->pay?$item->pay->name:'-' }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <style>
        .form-group{
            margin-top: 1rem;
        }
    </style>
@endsection
