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
    <a href="#" data-bs-target="#addModal" data-bs-toggle="modal"  class="btn btn-primary btn-sm"><i class="demo-pli-add me-2 fs-5"></i> Nouvelle operation</a>
@endsection

@section('page-header')
    <div class="d-flex justify-content-between mt-1">
        <h5 class="page-title mb-0 mt-1 fs-3">Hello <span class="text-muted">{{ auth()->user()->name }}</span>, vous etes sur <span class="text-danger">Cogelo Reporting</span></h5>
        <div class="d-flex gap-1">
            @foreach($caisses as $caisse)
                <div>
                    <span style="font-size: 0.65rem;" class="badge bg-blue"><span class="text-white">{{ $caisse->name }}</span> : <span class="">{{ number_format($caisse->solde,0,',','.') }}</span></span>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('content')

    <div style="height: 75vh; overflow:scroll;" class="card mt-1">
        <div class="card-body">
            <table class="table table-sm table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>JOURNAL</th>
                        <th>REFERENCE</th>
                        <th>&numero; COMPTE</th>
                        <th>COMPTE TIERS</th>
                        <th>LIBELLE DE L'ECRITURE</th>
                        <th>&numero; FACTURE</th>
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
                            <td>{{ $item->compte }}</td>
                            @if($item->compte != $item->caisse->compte)
                             <td title="{{ $item->tier?$item->tier->name:''  }}">{{ $item->tier?$item->tier->code:'-' }}</td>
                            @else
                             <td></td>
                            @endif
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->facture }}</td>
                            <td>{{ $item->credit?'':$item->montant }}</td>
                            <td style="text-align: right">{{ $item->credit?$item->montant:'' }}</td>
                            <td>
                                @if($item->compte != $item->caisse->compte)
                                 <a data-bs-target="#editModal" data-bs-toggle="modal" data-ref="{{$item->ref}}" data-facture="{{$item->facture}}" data-operation_id="{{$item->operation_id}}" data-caisse_id="{{ $item->caisse_id }}" data-id="{{ $item->id }}" data-compte="{{ $item->compte }}" data-montant="{{ $item->montant }}" class="btn btn-xs btn-light btn-edit" href=""><i class="pli-pencil fs-6"></i> Modifier</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
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
                            <input type="hidden" id="operation_id" name="operation_id">
                            <div class="d-flex gap-1">
                                <div class="mt-3">
                                    <label for="">CAISSE</label>
                                    <select required class="form-control" name="caisse_id" id="caisse_id">
                                        <option value="">Caisse ...</option>
                                        @foreach($caisses as $caisse)
                                            <option value="{{ $caisse->id }}">{{ $caisse->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <label for="">DATE</label>
                                    <input name="day" type="date"  required  class="form-control">
                                </div>
                                <div class="mt-3">
                                    <label for="">SENS DE L'OPERATION</label>
                                    <select required class="form-control" id="type_id">
                                        <option value=1>ENTREE</option>
                                        <option value=2>SORTIE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex gap-1">
                                <div class="mt-3 w-50">
                                    <label for="">LIBELLE</label>
                                    <select required class="form-control" name="libelle_id" id="libelle_id">
                                        <option value="">Libelle ...</option>
                                        @foreach($libelles as $libelle)
                                            <option value="{{ $libelle->id }}">{{ $libelle->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-3">
                                    <label for="">COMPTE</label>
                                    <input name="compte" id="compte" type="text"  required placeholder="Saisir le compte de l'operation" class="form-control">
                                </div>
                                <div class="mt-3">
                                    <label for="">MONTANT</label>
                                    <input name="montant" id="mt" type="number"  required placeholder="Saisir le montant de l'operation" class="form-control">
                                </div>
                            </div>
                            <div class="d-flex gap-1">
                                <div class="mt-3 w-50">
                                    <label for="">REFERENCE</label>
                                    <input name="ref" id="ref" type="text"  required placeholder="Saisir la reference" class="form-control">
                                </div>
                                <div class="mt-3 w-50">
                                    <label for="">&numero; FACTURE</label>
                                    <input name="facture" id="facture" type="text"  required placeholder="Saisir le numero de facture" class="form-control">
                                </div>
                            </div>
                            <div class="mt-2">
                                <button id="btn-add" class="btn btn-primary btn-sm"><i class="fs-5 pli-add"></i> Modifier</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title">Nouvelle operation</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" id="btn-close" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('caissier.store') }}">
                        @csrf
                        <div class="mb-3 d-flex gap-1">
                            <div class="w-25">
                                <label class="text-blue fs-6 fw-bolder" for="">JOURNAL</label>
                                <select class="form-control" name="caisse_id" id="caisse_id">
                                    <option value=0>SELECTIONNER UN JOURNAL ...</option>
                                    @foreach($caisses as $caisse)
                                    <option value="{{ $caisse->id }}">{{ $caisse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-25">
                                <label class="text-blue fs-6 fw-bolder" for="">DATE</label>
                                <input required type="date" name="day" id="day" class="form-control">
                            </div>
                            <div class="w-50">
                                <label class="text-blue fs-6 fw-bolder" for="">REFERENCE</label>
                                <input  type="text" id="ref" name="ref" placeholder="Saisir la reference de l'operation ici ..." class="form-control">
                            </div>
                        </div>

                        <div class="mb-3 d-flex gap-1">
                            <div class="w-50">
                                <label class="text-blue fs-6 fw-bolder" for="">TIERS</label>
                                <select class="form-control" name="tier_id" id="tier_id">
                                    <option value="">SELECTIONNER UN TIERS ...</option>
                                    @foreach($tiers as $tier)
                                    <option data-compte="{{ $tier->compte }}" value="{{ $tier->id }}">{{ $tier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                <label class="text-blue fs-6 fw-bolder" for="">COMPTE</label>
                                <input required id="compte_" type="text" name="compte" class="form-control">
                            </div>
                            <div class="">
                                <label class="text-blue fs-6 fw-bolder" for="">&numero; FACTURE</label>
                                <input placeholder="Saisir le numero de facture ici ..." type="text" name="facture" class="form-control">
                            </div>
                        </div>
                        
                        
                        <div class="mb-3 d-flex gap-1">
                            <div class="w-40">
                                <label class="text-blue fs-6 fw-bolder" for="">LIBELLE DE L'ECRITURE</label>
                                <select required class="form-control" name="libelle_id" id="lib_id">
                                    <option value="">SELECTIONNER UNE ECRITURE ...</option>
                                    @foreach($libelles as $libelle)
                                    <option value="{{ $libelle->id }}">{{ $libelle->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-blue fs-6 fw-bolder" for="">SENS DE L'OPERATION</label>
                                <select required class="form-control" name="sens" id="sens">
                                        <option value="">SELECTIONNER LE TYPE D'OPERATION ...</option>
                                        <option value="1">ENTREE</option>
                                        <option value="2">SORTIE</option>
                                </select>
                            </div>
                            <div class="w-50">
                                <label class="text-blue fs-6 fw-bolder" for="">MONTANT</label>
                                <input required type="number" placeholder="Saisir le montant de l'operation ici ..." name="montant" id="montant" class="form-control">
                            </div>
                        </div>
                        <div class="">
                            <button type="submit" id="btn-save" class="btn btn-primary"><i class="fs-5 pli-save"></i> ENREGISTRER</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#tier_id').change(function(){
            var _compte = $('#tier_id option:selected').data('compte');
            console.log(_compte);
            if(_compte!=undefined){
                $('#compte_').val(_compte);
                $('#compte_').prop('readonly',true);
            }else{
                $('#compte_').val("");
                $('#compte_').prop('readonly',false);
            }
        })

        $('.btn-edit').click(function(){
            $('#mt').val($(this).data('montant'));
            $('#compte').val($(this).data('compte'))
            $('#operation_id').val($(this).data('operation_id'))
            $('#id').val($(this).data('id'))
            $('#cc_id').val($(this).data('caisse_id'))
            $('#ref').val($(this).data('ref'))
            $('#facture').val($(this).data('facture'))
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

