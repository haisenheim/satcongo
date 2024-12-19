@extends('Layouts.caissier')

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

@section('actions')
<div>
<button type="button" class="btn btn-xs btn-outline-primary dropdown-toggle hstack gap-2" data-bs-toggle="dropdown" aria-expanded="false">
    Actions
    <span class="vr"></span>
 </button>
 <ul class="dropdown-menu">
     <li><a class="dropdown-item" data-bs-target="#add1Modal" data-bs-toggle="modal" href="#">Saisir un decaissement simple</a></li>
     <li><a class="dropdown-item" data-bs-target="#add2Modal" data-bs-toggle="modal" href="#">Saisir un decaissment transport</a></li>
     <li><a class="dropdown-item" data-bs-target="#add3Modal" data-bs-toggle="modal" href="#">Saisir un decaissement transit</a></li>
 </ul>
</div>
@endsection

@section('page-header')
    <div class="d-flex justify-content-between mt-1">
        <h5 class="page-title mb-0 mt-1 fs-3">Hello <span class="text-muted">{{ auth()->user()->name }}</span>, vous etes sur <span class="text-danger">Satcongo Reporting</span></h5>
        <div style="width: 320px;" class="d-flex gap-1 flex-wrap">
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
            <div id="myGrid" style="height: 480px"></div>
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

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add1Modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title">Nouveau decaissement</h5>
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
                                <select class="form-control" name="caisse_id" id="journal_id">
                                    <option value=0>SELECTIONNER UN JOURNAL ...</option>
                                    @foreach($caisses as $caisse)
                                    <option value="{{ $caisse->id }}">{{ $caisse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-300px">
                                <label class="text-blue fs-6 fw-bolder" for="">COMPTE</label>
                                <select name="compte_id" class="form-control">
                                    <option value="">SELECTIONNER UN COMPTE</option>
                                    @foreach($comptes as $compte)
                                        <option value="{{ $compte->id }}">{{ $compte->code }}-{{ $compte->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex-fill">
                                <label class="text-blue fs-6 fw-bolder" for="">MONTANT</label>
                                <input required type="number" placeholder="Saisir le montant de l'operation ici ..." name="montant" id="montant" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex gap-1">
                            <div class="w-25">
                                <label class="text-blue fs-6 fw-bolder" for="">DEPARTEMENT 1</label>
                                <select class="form-control" name="departement_un_id" id="agent_id">
                                    <option value="">SELECTIONNER UN DEPARTEMENT ...</option>
                                    @foreach($departements as $tier)
                                    <option value="{{ $tier->id }}">{{ $tier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-25">
                                <label class="text-blue fs-6 fw-bolder" for="">DEPARTEMENT 2</label>
                                <select class="form-control" name="departement_deux_id" id="agent_id">
                                    <option value="">SELECTIONNER UN DEPARTEMENT ...</option>
                                    @foreach($departements as $tier)
                                    <option value="{{ $tier->id }}">{{ $tier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-50">
                                <label class="text-blue fs-6 fw-bolder" for="">DEMANDEUR</label>
                                <select class="form-control" name="agent_id" id="agent_id">
                                    <option value="">SELECTIONNER UN AGENT ...</option>
                                    @foreach($agents as $tier)
                                    <option value="{{ $tier->id }}">{{ $tier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex gap-1">
                            <div class="w-25">
                                <label class="text-blue fs-6 fw-bolder" for="">&numero; DU DOSSIER</label>
                                <input type="text" name="dossier" class="form-control">
                            </div>
                            <div class="flex-fill">
                                <label class="text-blue fs-6 fw-bolder" for="">NATURE DE LA DEPENSE</label>
                                <input type="text" name="libelle" class="form-control">
                            </div>
                            <div class="w-25">
                                <label class="text-blue fs-6 fw-bolder" for="">DATE</label>
                                <input required type="date" name="day" id="day" class="form-control">
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" id="btn-save" class="btn btn-primary"><i class="fs-5 pli-save"></i> ENREGISTRER</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add2Modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title">Nouveau decaissement transport</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" id="btn-close" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('caissier.store2') }}">
                        @csrf
                        <div class="mb-3 d-flex gap-1">
                            <div class="w-25">
                                <label class="text-blue fs-6 fw-bolder" for="">JOURNAL</label>
                                <select class="form-control" name="caisse_id" id="journal_id">
                                    <option value=0>SELECTIONNER UN JOURNAL ...</option>
                                    @foreach($caisses as $caisse)
                                    <option value="{{ $caisse->id }}">{{ $caisse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-300px">
                                <label class="text-blue fs-6 fw-bolder" for="">COMPTE</label>
                                <select name="compte_id" class="form-control">
                                    <option value="">SELECTIONNER UN COMPTE</option>
                                    @foreach($comptes as $compte)
                                        <option value="{{ $compte->id }}">{{ $compte->code }}-{{ $compte->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-25">
                                <label class="text-blue fs-6 fw-bolder" for="">&numero; DU DOSSIER</label>
                                <input type="text" name="dossier" class="form-control">
                            </div>
                            <div class="w-25">
                                <label class="text-blue fs-6 fw-bolder" for="">DATE</label>
                                <input required type="date" name="day" id="day" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex gap-1">
                            <div class="flex-fill">
                                <label class="text-blue fs-6 fw-bolder" for="">PEAGE</label>
                                <input required type="number" value="0" name="mt_peage" id="mt_peage" class="form-control mt">
                            </div>
                            <div class="flex-fill">
                                <label class="text-blue fs-6 fw-bolder" for="">RATION</label>
                                <input required type="number" value="0" name="mt_ration" id="mt_ration" class="form-control mt">
                            </div>
                            <div class="flex-fill">
                                <label class="text-blue fs-6 fw-bolder" for="">PRIME</label>
                                <input required type="number" value="0" name="mt_prime" id="mt_prime" class="form-control mt">
                            </div>
                            <div class="flex-fill">
                                <label class="text-blue fs-6 fw-bolder" for="">HOTEL</label>
                                <input required type="number" value="0" name="mt_hotel" id="mt_hotel" class="form-control mt">
                            </div>
                        </div>
                        <div class="d-flex gap-1 mt-2">
                            <div class="w-25">
                                <label class="text-blue fs-6 fw-bolder" for="">BAC</label>
                                <input required type="number" value="0" name="mt_bac" id="mt_bac" class="form-control mt">
                            </div>
                            <div class="w-25">
                                <label class="text-blue fs-6 fw-bolder" for="">AUTRE</label>
                                <input required type="number" value="0" name="mt_autres" id="mt_autres" class="form-control mt">
                            </div>
                            <div class="flex-fill">
                                <label class="text-blue fs-6 fw-bolder" for="">MONTANT TOTAL</label>
                                <input required type="number" value="0" name="montant" readonly id="mt_total" class="form-control fw-bold">
                            </div>
                        </div>
                        <div class="d-flex gap-1 mt-2">
                            <div class="w-300px">
                                <label class="text-blue fs-6 fw-bolder" for="">DEMANDEUR</label>
                                <select class="form-control" name="agent_id" id="agent_id">
                                    <option value="">SELECTIONNER UN AGENT ...</option>
                                    @foreach($agents as $tier)
                                    <option value="{{ $tier->id }}">{{ $tier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-fill">
                                <label for="">CHAUFFEUR</label>
                                <input type="text" required name="chauffeur" placeholder="Nom du chauffeur ici ..." class="form-control">
                            </div>
                            <div class="flex-fill">
                                <label for="">CAMION</label>
                                <input type="text" required name="camion" placeholder="References du Camion " class="form-control">
                            </div>
                        </div>


                        <div class="mt-3">
                            <button type="submit" id="btn-save" class="btn btn-primary"><i class="fs-5 pli-save"></i> ENREGISTRER</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add3Modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title">Nouveau decaissement transit</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" id="btn-close" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('caissier.store3') }}">
                        @csrf
                        <div class="mb-3 d-flex gap-1">
                            <div class="w-25">
                                <label class="text-blue fs-6 fw-bolder" for="">JOURNAL</label>
                                <select required class="form-control" name="caisse_id" id="journal_id">
                                    <option value=0>SELECTIONNER UN JOURNAL ...</option>
                                    @foreach($caisses as $caisse)
                                    <option value="{{ $caisse->id }}">{{ $caisse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-300px">
                                <label class="text-blue fs-6 fw-bolder" for="">COMPTE</label>
                                <select name="compte_id" class="form-control">
                                    <option value="">SELECTIONNER UN COMPTE</option>
                                    @foreach($comptes as $compte)
                                        <option value="{{ $compte->id }}">{{ $compte->code }}-{{ $compte->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-25">
                                <label class="text-blue fs-6 fw-bolder" for="">&numero; DU DOSSIER</label>
                                <input type="text" name="dossier" class="form-control">
                            </div>
                            <div class="w-25">
                                <label class="text-blue fs-6 fw-bolder" for="">DATE</label>
                                <input required type="date" name="day" id="day" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="flex-fill">
                                <label class="text-blue fs-6 fw-bolder" for="">DEMANDEUR</label>
                                <select name="agent_id" class="form-control">
                                    <option value="">SELECTIONNER LE DEMANDEUR</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-300px">
                                <label class="text-blue fs-6 fw-bolder" for="">CLIENT</label>
                                <select name="tier_id" class="form-control">
                                    <option value="">SELECTIONNER UN CLIENT</option>
                                    @foreach($tiers as $tier)
                                        <option value="{{ $tier->id }}">{{ $tier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-1">
                            <div class="w-75">
                                <label for="">LIBELLE</label>
                                <input required type="text" name="libelle" placeholder="Saisor le libelle ici ..." class="form-control">
                            </div>
                            <div class="w-25">
                                <label for="">MONTANT</label>
                                <input required type="number" readonly name="montant" id="montant_total" value="0" class="form-control">
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-1">
                            <div class="w-25">
                                <label for="">ESPECES</label>
                                <input required type="number" name="mt_especes" value="0" class="form-control mnt">
                            </div>
                            <div class="w-25">
                                <label for="">CHEQUE</label>
                                <input required type="number" name="mt_cheque" value="0" class="form-control mnt">
                            </div>
                            <div class="w-25">
                                <label for="">&numero; DE CHEQUE</label>
                                <input required type="text" name="libelle" placeholder="num. du cheque ici ..." class="form-control">
                            </div>
                            <div class="w-25">
                                <div class="mt-4">
                                    <div class="form-check form-check-inline">
                                        <input id="" class="form-check-input" type="radio" name="is_debours" value=1>
                                        <label for="" class="form-check-label">DEBOURS</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="" class="form-check-input" type="radio" name="is_debours" value=0>
                                        <label for="" class="form-check-label">PRESTATIONS</label>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="mt-2">
                            <button type="submit" id="btn-save" class="btn btn-primary"><i class="fs-5 pli-save"></i> ENREGISTRER</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>

        $('.mt').keyup(function(){
            var somme = 0;
            $('.mt').each(function(){
                somme = somme + parseInt($(this).val())
            })
            $('#mt_total').val(somme);
        })

        $('.mnt').keyup(function(){
            var somme = 0;
            $('.mnt').each(function(){
                somme = somme + parseInt($(this).val())
            })
            $('#montant_total').val(somme);
        })

        $('#tier_id').change(function(){
            var _compte = $('#tier_id option:selected').data('compte');
            console.log(_compte);
            if(_compte!=undefined){
                $('#compte_').val(_compte);
                $('#_compte').prop('disabled',true);
            }else{
                $('#compte_').val("");
                $('#_compte').prop('disabled',false);
            }
        })

        $('#_compte').change(function(){
            var _compte = $('#_compte option:selected').data('compte');
            console.log(_compte);
            if(_compte!=undefined){
                $('#compte_').val(_compte);
                $('#tier_id').prop('disabled',true);
            }else{
                $('#compte_').val("");
                $('#tier_id').prop('disabled',false);
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

        $('#journal_id').change(function(){
                 var _id = $('#journal_id').val();
                 console.log(_id);
                $.ajax({
                    url: "{{ route('caissier.agence.libelles') }}",
                    type:'get',
                    dataType:'json',
                    data:{id:_id},
                    success:function(data){
                        $('#lib_id').html("<option value=0>Choisir un libelle ...</option>");
                        data.forEach(element => {
                            $('#lib_id').append(`<option value=${element.id}>${element.name}</option>`);
                        });
                    },
                    error:function(err){
                        console.log(err)
                    }
                });
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

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/ag-grid-community.min.js') }}"></script>

<script>
    const myTheme = agGrid.themeQuartz.withParams({
        /* Low spacing = very compact */
        spacing: 2,
        /* Changes the color of the grid text */
        foregroundColor: "rgb(14, 68, 145)",
        /* Changes the color of the grid background */
        backgroundColor: "rgb(241, 247, 255)",
        /* Changes the header color of the top row */
        headerBackgroundColor: "rgb(228, 237, 250)",
        /* Changes the hover color of the row*/
        rowHoverColor: "rgb(216, 226, 255)",
        });
        const columnDefs = [
                    { field: "operation.date",headerName:'Date'},
                    { field: "operation.type",headerName:'Type'},
                    { field: "operation.journal",headerName:'Journal'},
                    { field: "compte"},
                    { field: "sens",headerName:"Sens"},
                    { field: "operation.dossier",headerName:'Dossier'},
                    { field: "operation.demandeur",headerName:'Demandeur'},
                    { field: "operation.client",headerName:'Client'},
                    { field: "operation.libelle",headerName:'Libelle'},


                    {
                        headerName: "Montants",
                        children: [
                        { columnGroupShow: "closed", field: "montant", headerName:'Total' },
                        { columnGroupShow: "open", field: "operation.mt_especes",headerName:'Montant en especes'},
                        { columnGroupShow: "open", field: "operation.mt_cheque",headerName:'Montant en cheque'},
                        { columnGroupShow: "open", field: "operation.peage",headerName:'Peage'},
                        { columnGroupShow: "open", field: "operation.hotel",headerName:'Hotel'},
                        { columnGroupShow: "open", field: "operation.prime",headerName:'Prime'},
                        { columnGroupShow: "open", field: "operation.ration",headerName:'Ration'},
                        { columnGroupShow: "open", field: "operation.bac",headerName:'Bac'},
                        { columnGroupShow: "open", field: "operation.autre",headerName:'Autre'},
                        ],
                    },
                    { field: "operation.departement_un",headerName:'Departement 1'},
                    { field: "operation.departement_deux",headerName:'Departement 2'},

                    { field: "operation.num_cheque",headerName:'Numero de cheque'},
                    { field: "operation.chauffeur",headerName:'Chauffeur'},
                    { field: "operation.camion",headerName:'Camion'},
                    { field: "token",hide:true},
                    { field: "type_id",hide:true},


        ];

        let gridApi;

        const gridOptions = {
        theme: agGrid.themeBalham.withParams({
            headerBackgroundColor: '#0f85f2',
            headerHeight: '30px',
            headerTextColor: 'white',
        }),
        rowData: null,
        columnDefs: columnDefs,
        defaultColDef: {
            filter: true,
            //floatingFilter: true,
        },
        autoSizeStrategy: {
            type: 'fitCellContents',
            defaultMinWidth: 100,
            columnLimits: [
                {
                    colId: 'name',
                    minWidth: 150
                }
            ]
        },
        pagination: true,
        paginationPageSize: 200,
        paginationPageSizeSelector: [100, 200, 1000],
        rowSelection: {
            mode: 'singleRow',
            enableClickSelection: true,
            isRowSelectable: (rowNode) => rowNode.data ? rowNode.data.sens === 'DEBIT' : false,
            checkboxes: false,
        },
        rowClassRules: {
            'type_1': params => (params.data.type_id === 1)&&(params.data.sens==='DEBIT'),
            'type_2': params => params.data.type_id === 2&&(params.data.sens==='DEBIT'),
            'type_3': params => params.data.type_id === 3&&(params.data.sens==='DEBIT'),
        },
    };

    function rowSelected(e){
        console.log(e.data.token)
       // window.location.href = "programmes/"+e.data.token
    }

    function onFilterTextBoxChanged() {
        gridApi.setGridOption(
            "quickFilterText",
            document.getElementById("header-search-input").value,
        );
    }

        // setup the grid after the page has finished loading
        document.addEventListener("DOMContentLoaded", function () {
            const gridDiv = document.querySelector("#myGrid");
            gridApi = agGrid.createGrid(gridDiv, gridOptions);
            gridApi.addEventListener('rowSelected',rowSelected)

            fetch("{{ route('caissier.operations.all') }}")
                .then((response) => response.json())
                .then((data) => gridApi.setGridOption("rowData", data));

        });
</script>

<style>
    .type_1{
        background-color: rgb(201, 242, 229);
    }
    .type_2{
        background-color: rgb(246, 238, 207);
    }
    .type_3{
        background-color: rgb(203, 231, 241);
    }
</style>
@endsection

