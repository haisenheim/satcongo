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
    <a href="{{ route('caissier.create') }}"  class="btn btn-primary btn-sm"><i class="demo-pli-add me-2 fs-5"></i> Nouvelle operation</a>
@endsection

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-1 fs-3">Hello <span class="text-muted">{{ auth()->user()->name }}</span>, vous etes sur <span class="text-muted">Cogelo Reporting</span></h5>
        
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <fieldset>
                <legend>Nouvelle operation</legend>
                <form method="POST"  action="{{ route('caissier.operation.store') }}">
                    @csrf
                    <div class="d-flex gap-2">
                        <div>
                            <label for="">CREDIT/DEBIT</label>
                            <select class="form-control" id="type_id">
                                <option value="">SELECTIONNER LE TYPE D'OPERATION ...</option>
                                <option value=0>DEBIT</option>
                                <option value=1>CREDIT</option>
                            </select>
                        </div>
                        <div>
                            <label for="">COMPTE</label>
                            <select name="compte_id" required class="form-control" id="compte_id">
                                <option value="">SELECTIONNER LE COMPTE ...</option>
                            </select>
                        </div>
                        <div>
                            <label for="">REFERENCE</label>
                            <input name="ref" type="text" required placeholder="Saisir la reference de l'operation" class="form-control">
                        </div>
                        <div>
                            <label for="">MONTANT</label>
                            <input name="montant" type="text" required placeholder="Saisir le montant de l'operation" class="form-control">
                        </div>
                        <div>
                            <label for="">DATE</label>
                            <input name="day" type="date" required placeholder="Saisir la date de l'operation" class="form-control">
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-primary"><i class="fs-5 pli-save"></i> ENREGISTRER</button>
                        </div>

                    </div>
                </form>
            </fieldset>
        </div>
    </div>
    <div style="height: 50vh; overflow:scroll;" class="card mt-1">
        <div class="card-body">
            <table class="table table-sm table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>DATE</th>
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
                            <td>{{ $item->ref }}</td>
                            <td>{{ $item->compte->code }}</td>
                            <td>{{ $item->compte->name }}</td>
                            <td>{{ $item->credit?'':$item->montant }}</td>
                            <td style="text-align: right">{{ $item->credit?$item->montant:'' }}</td>
                            <td>
                                <a class="btn btn-xs btn-light" href=""><i class="pli-pencil fs-6"></i> Modifier</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('#type_id').change(function(){
                 var _id = $('#type_id').val();
                $.ajax({
                    url: "{{ route('caissier.caisse.comptes') }}",
                    type:'get',
                    dataType:'json',
                    data:{id:_id},
                    success:function(data){
                        $('#compte_id').html("<option value=0>Choisir un compte ...</option>");
                        data.forEach(element => {
                            $('#compte_id').append(`<option value=${element.id}>${element.name}</option>`);
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

