@extends('Layouts.comptable')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Satcongo</a></li>
       <li class="breadcrumb-item"><a href="#">Dossiers</a></li>
       <li class="breadcrumb-item active" aria-current="page">Liste des dossiers</li>
    </ol>
 </nav>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">Dossiers</h5>
        <p class="lead">Liste des Dossiers</p>
    </div>
@endsection



@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>DATE DE CREATION</th>
                        <th>CLIENT</th>
                        <th>DESIGNATION</th>
                        <th>CODE</th>
                        <td>

                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d/m/Y h:i') }}</td>
                            <th>{{ $item->client?->name }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->code }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-outline-primary dropdown-toggle hstack gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                                       Actions
                                       <span class="vr"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('comptable.dossiers.show',$item->token) }}">Afficher</a></li>
                                    </ul>
                                 </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function(){

            $('.btn-dossier').click(function(){
                var _id = $(this).data('id');
                $('#dossier_id').val(_id);
                $('#_dossier_id').val(_id);
            });

            $('#ville_id').change(function(){
                 var _id = $('#ville_id').val();
                $.ajax({
                    url: "{{ route('util.ville.agences') }}",
                    type:'get',
                    dataType:'json',
                    data:{id:_id},
                    success:function(data){
                        $('#agence_id').html("<option value=0>Choisir une agence ...</option>");
                        data.forEach(element => {
                            $('#agence_id').append(`<option value=${element.id}>${element.name}</option>`);
                        });

                    },
                    error:function(err){
                        console.log(err)
                    }
                });
            })

            $('#agence_id').change(function(){
                 var _id = $('#agence_id').val();
                $.ajax({
                    url: "{{ route('util.agence.caisses') }}",
                    type:'get',
                    dataType:'json',
                    data:{id:_id},
                    success:function(data){
                        $('#caisse_id').html("<option value=0>Choisir une caisse ...</option>");
                        data.forEach(element => {
                            $('#caisse_id').append(`<option value=${element.id}>${element.name}</option>`);
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
