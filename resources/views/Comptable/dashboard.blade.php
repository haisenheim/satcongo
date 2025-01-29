@extends('Layouts.comptable')

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
    <div class="d-flex justify-content-between">
        <h5 class="page-title mb-0 mt-1 fs-3">Hello <span class="text-muted">{{ auth()->user()->name }}</span>, vous etes sur <span class="text-muted">Satcongo Reporting</span></h5>

    </div>
@endsection

@section('actions')
<div class="btn-group">
    <button type="button" class="btn btn-xs btn-outline-primary dropdown-toggle hstack gap-2" data-bs-toggle="dropdown" aria-expanded="false">
       Actions
       <span class="vr"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a id="btn-export" style="display: none;" href="#" class="dropdown-item"><i class="fs-5 pli-download"></i> Exporter</a></li>
    </ul>
 </div>
 @endsection

@section('content')
    <div class="card">
        <div class="card-body d-flex  justify-content-between">
            <div>
                <fieldset class="">
                    <legend class="mb-0">Consultation</legend>
                    <form method="get" id="fom-show">
                        @csrf
                        <div class="d-flex gap-2">
                            <div>
                                <select name="caisse_id" class="form-control" id="caisse_id">
                                    <option value="0">SELECTIONNER UNE CAISSE ...</option>
                                    @foreach ($caisses as $caisse)
                                      <option value="{{ $caisse->id }}">{{ $caisse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <input id="start" name="start" type="date" required placeholder="Saisir la date de l'operation" class="form-control">
                            </div>
                            <div>
                                <input id="end" name="end" type="date" required placeholder="Saisir la date de l'operation" class="form-control">
                            </div>
                            <div class="">
                                <button id="btn-show" class="btn btn-primary"><i class="fs-5 pli-data-search"></i> Consulter</button>
                            </div>

                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
    <div style="height: 50vh; overflow:scroll;" class="card mt-1">
        <div class="card-body">

            <div style="height: 75vh; overflow:scroll;" class="card mt-1">
                <div class="card-body">
                    <div id="myGrid" style="height: 480px"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title">Nouvel appro caisse</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" id="btn-close" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('comptable.store') }}">
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
                                <label class="text-blue fs-6 fw-bolder" for="">DATE</label>
                                <input required type="date" name="day" id="day" class="form-control">
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-1">
                            <div class="w-75">
                                <label for="">LIBELLE</label>
                                <input required type="text" name="libelle" placeholder="Saisir le libelle ici ..." class="form-control">
                            </div>
                            <div class="w-25">
                                <label for="">MONTANT</label>
                                <input required type="number" readonly name="montant" id="montant_total" value="0" class="form-control">
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

    <div class="modal fade" id="vModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title">Actions</h5>
                    <div style="float: right">
                        <button data-bs-dismiss="modal" id="btn-close" class="btn btn-sm" >x</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="mt-3">
                        <a class="btn btn-sm btn-success btn-block" href="#" id="btn-validate">Valider</a>
                    </div>
                    <div class="mt-3">
                        <a class="btn btn-sm btn-danger btn-block" id="btn-cancel" href="#">Annuler</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/ag-grid-community.min.js') }}"></script>

    <script>
            const columnDefs = [
                        { field: "operation.date",headerName:'Date'},
                        { field: "operation.name",headerName:'Numero'},
                        { field: "operation.journal",headerName:'Journal'},
                        { field: "compte"},
                        { field: "sens",headerName:"Sens"},
                        { field: "operation.dossier",headerName:'Dossier'},
                        { field: "operation.agent",headerName:'Agent'},
                        { field: "operation.client",headerName:'Client'},
                        { field: "operation.libelle",headerName:'Nature de la depense'},

                        { field: "operation.montant",headerName:'Montant'},
                        { field: "operation.status.name",headerName:'Statut'},
                        { field: "operation.token",hide:true},
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
                isRowSelectable: (rowNode) => (rowNode.data?rowNode.data.sens === 'DEBIT':false)&&(rowNode.data?rowNode.data.validated===false:true),
                checkboxes: false,
            },
            rowClassRules: {
                'clickable': params => params.data.sens==='DEBIT',
                'validated': params => params.data.validated,
                'clickable': params => params.data.cancelled,
            },
        };

        function rowSelected(e){
            console.log(e.data.token)
            $('#vModal').modal('show');
            $('#btn-validate').prop('href',`/comptable/operation/validate/${e.data.operation.token}`)
            $('#btn-cancel').prop('href',`/comptable/operation/cancel/${e.data.operation.token}`)
           //window.location.href = "/comptable/operation/"+e.data.token
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

                fetch("{{ route('comptable.operations.all') }}")
                    .then((response) => response.json())
                    .then((data) => gridApi.setGridOption("rowData", data));

            });

            $('.clickable').click(function(){
                //$('#vModal').modal('show');
            })

            $('#btn-show').click(function(e){
                e.preventDefault();
                var start = $('#start').val()
                var end = $('#end').val()
                var caisse_id = $('#caisse_id').val()
                fetch('/comptable/data/operations?caisse_id='+caisse_id+'&start='+start+'&end='+end)
                    .then((response) => response.json())
                    .then((data) => gridApi.setGridOption("rowData", data));
                //$('#export-section').show();
                $('#btn-export').show();
            })

            $('#btn-export').click(function(e){
                e.preventDefault();
                var start = $('#start').val()
                var end = $('#end').val()
                var caisse_id = $('#caisse_id').val()
                window.location.href = '/comptable/bluk/export/'+caisse_id+'/'+start+'/'+end;
            })
    </script>

    <style>
        .clickable{
            background-color: rgb(239, 246, 251);
        }
        .validated{
            background-color: rgb(242, 251, 239);
        }
        .cancelled{
            background-color: rgb(251, 239, 239);
        }
    </style>

@endsection

