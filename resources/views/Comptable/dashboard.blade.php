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
    <div>
        <h5 class="page-title mb-0 mt-1 fs-3">Hello <span class="text-muted">{{ auth()->user()->name }}</span>, vous etes sur <span class="text-muted">Satcongo Reporting</span></h5>

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
                                    <option value="">SELECTIONNER UNE CAISSE ...</option>
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
            <div id="export-section" style="display:none">
                <fieldset>
                    <legend class="mb-0">Exportation</legend>
                        <div class="d-flex gap-2">
                            <div class="">
                                <a id="btn-export" href="#" class="btn btn-danger"><i class="fs-5 pli-download"></i> Exporter</a>
                            </div>
                            <div class="">
                                <a id="btn-validate" href="#" class="btn btn-success"><i class="fs-5 pli-pencil"></i> Valider</a>
                            </div>
                        </div>
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
           window.location.href = "/comptable/operation/"+e.data.token
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

            $('#btn-show').click(function(e){
                e.preventDefault();
                var start = $('#start').val()
                var end = $('#end').val()
                var caisse_id = $('#caisse_id').val()
                fetch('/comptable/data/operations?caisse_id='+caisse_id+'&start='+start+'&end='+end)
                    .then((response) => response.json())
                    .then((data) => gridApi.setGridOption("rowData", data));
                $('#export-section').show();
            })

            $('#btn-export').click(function(e){
                e.preventDefault();
                var start = $('#start').val()
                var end = $('#end').val()
                var caisse_id = $('#caisse_id').val()
                window.location.href = '/comptable/bluk/export/'+caisse_id+'/'+start+'/'+end;
            })
    </script>

@endsection

