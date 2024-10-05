@extends('Layouts.caissier')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Cogelo</a></li>
       <li class="breadcrumb-item"><a href="#">Tableau de bord</a></li>
       <li class="breadcrumb-item active" aria-current="page">Accueil</li>
    </ol>
 </nav>
@endsection

@section('actions')
    <a href="{{ route('caissier.operation.create') }}"  class="btn btn-primary btn-sm"><i class="demo-pli-add me-2 fs-5"></i> Nouvelle operation</a>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-1 fs-3">Hello <span class="text-muted">{{ auth()->user()->name }}</span>, vous etes sur <span class="text-danger">Cogelo Reporting</span></h5>
        
    </div>
@endsection

@section('content')
    
    <div style="height: 50vh; overflow:scroll;" class="card mt-1">
        <div class="card-body">
            <table class="table table-sm table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>CAISSE</th>
                        <th>REFERENCE</th>
                        <th>&numero; COMPTE</th>
                        <th>LIBELLE DE L'ECRITURE</th>
                        <th>MONTANT DEBIT</th>
                        <th>MONTANT CREDIT</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $item)
                        
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->day)->format('d/m/Y')  }}</td>
                            <td>{{ $item->caisse->name }}</td>
                            <td>{{ $item->ref }}</td>
                            <td>{{ $item->compte->code }}</td>
                            <td>{{ $item->compte->name }}</td>
                            <td>{{ $item->credit?'':$item->montant }}</td>
                            <td style="text-align: right">{{ $item->credit?$item->montant:'' }}</td>
                            <td>
                                <a data-bs-target="#editModal" data-bs-toggle="modal" data-caisse_id="{{ $item->caisse_id }}" data-id="{{ $item->id }}" data-text="{{ $item->compte->code }} {{ $item->compte->name }}" data-montant="{{ $item->montant }}" class="btn btn-xs btn-light btn-edit" href=""><i class="pli-pencil fs-6"></i> Modifier</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="editModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title">Edition de l'ecriture</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" id="btn-close" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="{{ route('caissier.operation.update') }}" method="post">
                        @csrf
                        <div class="">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" id="cc_id">
                            <fieldset>
                                <legend>ECRITURE</legend>
                                <div>
                                    <label for="">COMPTE</label>
                                    <input id="ecrit" readonly class="form-control" type="text">
                                </div>
                                <div>
                                    <label for="">MONTANT</label>
                                    <input id="mt" readonly class="form-control" type="text">
                                </div>
                            </fieldset>
                            <div class="mt-3">
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
                                <input name="montant" type="number"  required placeholder="Saisir le montant de l'operation" class="form-control">
                            </div>
                            <div class="mt-2">
                                <button id="btn-add" class="btn btn-primary btn-sm"><i class="fs-5 pli-add"></i> Ajouter</button>
                            </div>
    
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.btn-edit').click(function(){
            $('#mt').val($(this).data('montant'));
            $('#ecrit').val($(this).data('text'))
            $('#id').val($(this).data('id'))
            $('#cc_id').val($(this).data('caisse_id'))
        })

        $('#type_id').change(function(){
                 var _id = $('#type_id').val();
                 var _cc_id = $('#cc_id').val();
                $.ajax({
                    url: "{{ route('caissier.caisse.comptes') }}",
                    type:'get',
                    dataType:'json',
                    data:{id:_id,caisse_id:_cc_id},
                    success:function(data){
                        $('#compte_id').html("<option value=0>Choisir un compte ...</option>");
                        data.forEach(element => {
                            $('#compte_id').append(`<option value=${element.id}>${element.code}-${element.name}</option>`);
                        });
                    },
                    error:function(err){
                        console.log(err)
                    }
                });
            })
    </script>
@endsection

