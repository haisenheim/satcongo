@extends('Layouts.caissier')

@section('title', 'Accueil')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
       <li class="breadcrumb-item"><a href="#">Satcongo</a></li>
       <li class="breadcrumb-item"><a href="#">Operations</a></li>
       <li class="breadcrumb-item active" aria-current="page">Nouvelle operation</li>
    </ol>
 </nav>
@endsection
@section('actions')
    <a href="#" data-bs-target="#addModal" data-bs-toggle="modal" class="btn btn-primary btn-sm"><i class="demo-pli-add me-2 fs-5"></i> Ajouter une saisie</a>
@endsection



@section('content')
    <div style="width: 400px; margin:1px auto;" class="card">
        @csrf
        <div id="form" class="card-body">
            <h4 class="card-title text-blue">Formulaire de creation</h4>
            <div>
                <fieldset>
                    <legend>Infos de l'operation</legend>
                    <div class="mb-3">
                        <label class="text-blue fs-6 fw-bolder" for="">CAISSE</label>
                        <select class="form-control" name="caisse_id" id="caisse_id">
                            <option value=0>SELECTIONNER UNE CAISSE ...</option>
                            @foreach($caisses as $caisse)
                              <option value="{{ $caisse->id }}">{{ $caisse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="text-blue fs-6 fw-bolder" for="">DATE</label>
                        <input type="date" id="day" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="text-blue fs-6 fw-bolder" for="">REFERENCE</label>
                        <input type="text" id="ref" class="form-control">
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="card-footer">
            <div class="">
                <button style="display: none;" id="btn-save" class="btn btn-primary"><i class="fs-5 pli-save"></i> ENREGISTRER</button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title">Nouvelle Saisie</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" id="btn-close" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div>
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
                            <input name="montant" type="text" id="montant" required placeholder="Saisir le montant de l'operation" class="form-control">
                        </div>
                        <div class="mt-2">
                            <button id="btn-add" class="btn btn-primary btn-sm"><i class="fs-5 pli-add"></i> Ajouter</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkSomme(){
            var somme = -1;
            $('.field').each(function(){
                var elt = $(this);
                //console.log(elt);
                var tp = parseInt($(this).data('type'));
                if(tp== 0){
                    somme = somme - $(this).data('montant');
                }
                if(tp==1){
                    somme = somme + $(this).data('montant');
                }
            })
            console.log(somme);
            if(somme == -1){
                return true;
            }else{
                false;
            }
        }
        $(document).ready(function(){
            var somme = 0;
            $('#btn-add').click(function(){
                var legend = $('#type_id option:selected').text();
                var type_id = $('#type_id').val();
                var _montant = $('#montant').val();
                var _cpt_id = $('#compte_id').val();
                var _cpt_text = $('#compte_id option:selected').text();

                var content =
                `<fieldset class="mt-2">
                    <legend>${legend}</legend>
                    <div>
                        <label>COMPTE</label>
                        <input readonly value="${_cpt_text}" class="form-control"/>
                    </div>
                    <div>
                        <label>MONTANT</label>
                        <input data-type=${type_id} data-id="${_cpt_id}" data-montant="${_montant}" value="${_montant}" class="form-control field"/>
                    </div>
                </fieldset>`;
                $('#form').append(content);
                if(checkSomme()){
                    $('#btn-save').show();
                }else{
                    $('#btn-save').hide();
                }
                $('#btn-close').click();
            });

            $('#btn-save').click(function(){
                if(checkSomme() && parseInt($('#caisse_id').val())>0){
                    var fields = [];
                    $('.field').each(function(){
                        fields.push({'montant':$(this).data('montant'),'compte_id':$(this).data('id')});
                    })
                    $.ajax({
                        url: "{{ route('caissier.operation.save') }}",
                        type:'post',
                        dataType:'json',
                        data:{items:fields,day:$('#day').val(),ref:$('#ref').val(),_token:$('input[name=_token]').val()},
                        success:function(data){
                            window.location.href="{{ route('caissier.dashboard') }}"
                        },
                        error:function(err){
                            console.log(err)
                        }
                    });
                }
            });

            $('#type_id').change(function(){
                 var _id = $('#type_id').val();
                 var _cc_id = $('#caisse_id').val();
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


        })
    </script>

    <style>
        legend{
            margin-bottom: 0;
        }
    </style>
@endsection
