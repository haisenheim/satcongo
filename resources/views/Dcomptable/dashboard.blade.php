@extends('Layouts.dcomptable')

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

@section('page-header')
    <div>
        <h5 class="page-title mb-0 mt-1 fs-3">Hello <span class="text-muted">{{ auth()->user()->name }}</span>, vous etes sur <span class="text-muted">Cogelo Reporting</span></h5>
        
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body d-flex  justify-content-between">
            <div>
                <fieldset class="">
                    <legend class="mb-0">Consultation</legend>
                    <form method="get"  action="{{ route('dcomptable.dashboard') }}">
                        @csrf
                        <div class="d-flex gap-2">
                            <div>
                                <select name="agence_id" required class="form-control" id="agence_id">
                                    <option value="">SELECTIONNER UNE AGENCE ...</option>
                                    @foreach($agences as $ville)
                                        <option value="{{ $ville->id }}">{{ $ville->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select name="caisse_id" required class="form-control" id="caisse_id">
                                    <option value="">SELECTIONNER UNE CAISSE...</option>
                                </select>
                            </div>
                            <div>
                                <input name="start" type="date" required placeholder="Saisir la date de l'operation" class="form-control">
                            </div>
                            <div>
                                <input name="end" type="date" required placeholder="Saisir la date de l'operation" class="form-control">
                            </div>
                            <div class="">
                                <button class="btn btn-primary"><i class="fs-5 pli-data-search"></i> Consulter</button>
                            </div>
    
                        </div>
                    </form>
                </fieldset>
            </div>
            @if($ready)
            <div>
                <fieldset>
                    <legend class="mb-0">Exportation</legend>
                        <div class="d-flex gap-2">
                            <div class="">
                                <a href="{{ route('dcomptable.bluk.export',[$caisse_id,$start,$end]) }}" class="btn btn-danger"><i class="fs-5 pli-download"></i> Exporter</a>
                            </div>
                            <div class="">
                                <a href="{{ route('dcomptable.bluk.validate',[$caisse_id,$start,$end]) }}" class="btn btn-success"><i class="fs-5 pli-pencil"></i> Valider</a>
                            </div>
                        </div>
                </fieldset>
            </div>
            @endif
        </div>
    </div>
    <div style="height: 50vh; overflow:scroll;" class="card mt-1">
        <div class="card-body">
           
            <table class="table table-sm table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>&numero; OPERATION</th>
                        <th>JOURNAL</th>
                        <th>REFERENCE</th>
                        <th>&numero; COMPTE</th>
                        <th>COMPTE TIERS</th>
                        <th>LIBELLE DE L'ECRITURE</th>
                        <th>MONTANT DEBIT</th>
                        <th>MONTANT CREDIT</th>
                        <th>STATUT</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $item)
                        
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->day)->format('d/m/Y')  }}</td>
                            <td>{{ $item->caisse->name }}-{{ $item->id }}</td>
                            <td>{{ $item->caisse->name }}</td>
                            <td>{{ $item->ref }}</td>
                            <td>{{ $item->compte }}</td>
                            @if($item->compte != $item->caisse->compte)
                             <td title="{{ $item->tier?$item->tier->name:''  }}">{{ $item->tier?$item->tier->code:'-' }}</td>
                            @else
                             <td></td>
                            @endif
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->credit?'':$item->montant }}</td>
                            <td style="text-align: right">{{ $item->credit?$item->montant:'' }}</td>
                            <td><span class="badge bg-{{ $item->status['color'] }}">{{ $item->status['name'] }}</span></td>
                            <td>
                                @if(($item->compte != $item->caisse->compte)&&(!$item->validated_at))
                                 <a class="btn btn-xs btn-light btn-edit" href="{{ route('dcomptable.single.validate',$item->operation->token) }}"><i class="pli-pencil fs-6"></i> Modifier</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

       
    </div>

    <script>
        $(document).ready(function(){
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

