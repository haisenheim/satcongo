@extends('Layouts.admin')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Satcongo</a></li>
       <li class="breadcrumb-item"><a href="#">Departements</a></li>
       <li class="breadcrumb-item active" aria-current="page">{{ $departement->name }}</li>
    </ol>
 </nav>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">{{ $departement->name }}</h5>
        <p class="lead">Details sur la departement</p>
    </div>
@endsection

@section('content')
    <div class="d-flex gap-1">
        <div class="card w-25">
            <div class="card-body">
                <h5>REGION : {{ $departement->name }}</h5>
                <h6>ABBREVIATION : {{ $departement->abb }}</h6>
            </div>
        </div>
        <div class="card w-75">
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Arrondissement</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departement->arrondissements as $item)
                            <tr>
                                <td>{{ $item->abb }}</td>
                                <td><a href="{{ route('admin.arrondissements.show',$item->id) }}">{{ $item->name }}</a></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
