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
        <li><a class="dropdown-item" data-bs-target="#addModal" data-bs-toggle="modal" href="#">Saisir un ordre de paiement</a></li>
    </ul>
</div>
@endsection

@section('page-header')
    <div class="d-flex justify-content-between mt-1">
        <h5 class="page-title mb-0 mt-1 fs-3">Hello <span class="text-muted">{{ auth()->user()->name }}</span>, vous etes sur <span class="text-danger">Zanzi cash</span></h5>
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

    <div class="modal fade" id="addModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title">Nouvel ordre de paiement</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" id="btn-close" class="btn btn-sm btn-danger close" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('caissier.store') }}">
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
                            <div class="flex-fill">
                                <label class="text-blue fs-6 fw-bolder" for="">&numero; DU DOSSIER</label>
                                <input type="text" class="form-control" name="dossier_id" id="dossier_id" data-datalist="dossiers" placeholder="Rechercher un dossier ..." />
                                <datalist id="dossiers">
                                    @foreach ($dossiers as $dossier)
                                        <option value="{{ $dossier->id }}">{{ $dossier->code }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-1">
                            <div class="w-50">
                                <label for="">AGENT PAYEUR</label>
                                <input required type="text" name="agent"  class="form-control">
                            </div>
                            <div class="w-50">
                                <label for="">BENEFICIAIRE</label>
                                <input required type="text" name="beneficiaire"  class="form-control">
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-1">
                            <div class="w-75">
                                <label for="">NATURE DE LA DEPENSE</label>
                                <input required type="text" name="libelle" placeholder="Saisir le libelle ici ..." class="form-control">
                            </div>
                            <div class="w-25">
                                <label for="">MONTANT</label>
                                <input required type="number" name="montant" id="montant" value="0" class="form-control">
                            </div>
                        </div>

                        <div class="mt-2">
                            <button type="submit" id="btn-save" data-bs-dismiss="modal" class="btn btn-primary"><i class="fs-5 pli-save"></i> ENREGISTRER</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="vModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="mt-1 text-center">
                        <a class="btn btn-sm btn-danger btn-block" href="#" id="btn-delete">Supprimer cette operation</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>

        window.addEventListener( "pageshow", function ( event ) {
        var historyTraversal = event.persisted ||
                                ( typeof window.performance != "undefined" &&
                                    window.performance.navigation.type === 2 );
        if ( historyTraversal ) {
            // Handle page restore.
            window.location.reload();
        }
        });


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

        $('.close').click(function(){
            window.location.reload();
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
<script type="module">
    import Autocomplete from "{{ asset('js/autocomplete.js') }}";

    new Autocomplete(document.getElementById("dossier_id"), {
        //valueField: "id",
    });
</script>

<script>;
        const columnDefs = [
                    { field: "operation.date",headerName:'Date'},
                    { field: "operation.journal",headerName:'Journal'},
                    { field: "montant"},
                    { field: "compte"},
                    { field: "sens",headerName:"Sens"},
                    { field: "operation.dossier",headerName:'Dossier'},
                    { field: "operation.beneficiaire",headerName:'Beneficiaire'},
                    { field: "operation.client",headerName:'Client'},
                    { field: "operation.libelle",headerName:'Nature de la depense'},
                    { field: "operation.agent",headerName:'Agent payeur'},
                    { field: "token",hide:true},
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
            isRowSelectable: (rowNode) => (rowNode.data?rowNode.data.sens ==='DEBIT':false)&&(rowNode.data?rowNode.data.validated===false:true),
            checkboxes: false,
        },
    };

    function rowSelected(e){
           // console.log(e.data.token)
           // $('#vModal').modal('show');
          //  $('#btn-delete').prop('href',`/caissier/operation/delete/${e.data.operation.token}`)
            
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

