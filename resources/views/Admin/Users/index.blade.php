@extends('Layouts.admin')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Satcongo</a></li>
       <li class="breadcrumb-item"><a href="#">Utilisateurs</a></li>
       <li class="breadcrumb-item active" aria-current="page">Liste des comptes utilisateurs</li>
    </ol>
 </nav>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-2">Comptes utilisateurs</h5>
        <p class="lead">Liste des comptes utilisateurs</p>
    </div>
@endsection

@section('actions')
    <a href="#" data-bs-target="#addModal" data-bs-toggle="modal" class="btn btn-primary btn-sm"><i class="demo-pli-add me-2 fs-5"></i> Ajouter</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Role</th>
                        <td>Statut</td>
                        <td>

                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->email }}</td>
                            <th>{{ $item->role->name }}</th>
                            <td><span class="badge bg-{{ $item->status['color'] }}">{{ $item->status['name'] }}</span></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-outline-primary dropdown-toggle hstack gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                                       Actions
                                       <span class="vr"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item btn-user" data-id="{{ $item->id }}" href="#" data-bs-target="#passwordModal" data-bs-toggle="modal">Reinitialiser le mot de passe</a></li>
                                        @if($item->active)
                                            <li><a class="dropdown-item" href="{{ route('admin.user.disable',$item->token) }}">Verrouiller</a></li>
                                        @else
                                            <li><a class="dropdown-item" href="{{ route('admin.user.enable',$item->token) }}">Activer</a></li>
                                        @endif
                                    </ul>
                                 </div>
                            </td>
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
                    <h5 class="modal-title">Nouveau compte utilisateur</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" action="{{ route('admin.users.store') }}" method="post">
                        @csrf
                            <div class="">
                                <div class="">
                                    <label for="">NOM</label>
                                    <input required type="text" name="name" placeholder="Saisir l'intitule de la saison" class="form-control">
                                </div>
                                <div class="mt-2">
                                    <label for="">ROLE</label>
                                    <select name="role_id" required id="" class="form-control">
                                        <option value="">Role ...</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mt-2">
                                    <label for="">Telephone</label>
                                    <input required type="text" name="phone" class="form-control">
                                </div>
                                <div class="mt-2">
                                    <label for="">Email de connexion</label>
                                    <input required type="email" name="email" class="form-control">
                                </div>
                                <div class="mt-2">
                                    <label for="">Mot de passe</label>
                                    <input required type="password" name="password" class="form-control">
                                </div>
                            </div>
                        <div class="mt-5">
                            <button type="submit" class="btn-primary btn">ENREGISTRER</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="passwordModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title">Editer le mot de passe</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form enctype="" action="{{ route('admin.user.password') }}" method="post">
                        @csrf
                            <input type="hidden" name="user_id" id="user_id">
                            <div class="">
                                <div class="mt-2">
                                    <label for="">Nouveau mot de passe</label>
                                    <input required type="password" name="password" class="form-control">
                                </div>
                            </div>
                        <div class="mt-5">
                            <button type="submit" class="btn-primary btn">ENREGISTRER</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function(){

            $('.btn-user').click(function(){
                var _id = $(this).data('id');
                $('#user_id').val(_id);
                //$('#_user_id').val(_id);
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
