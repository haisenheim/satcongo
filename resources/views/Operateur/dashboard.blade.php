@extends('Layouts.operateur')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Satcongo</a></li>
       <li class="breadcrumb-item"><a href="#">Tableau de bord</a></li>
       <li class="breadcrumb-item active" aria-current="page">Accueil</li>
    </ol>
 </nav>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">Tableau de bord de l'operateur</h5>
        <p class="lead">Hello {{ auth()->user()->name }}, bienvenu chez <span class="text-muted">Satcongo</span></p>
    </div>
@endsection

@section('content')
    <div class="container"></div>
    <script src="{{ asset('assets/vendors/chart.js/chart.umd.min.js') }}">

    </script>
    <style>
        .text-bold{
            font-weight: 800;
        }
    </style>
@endsection
