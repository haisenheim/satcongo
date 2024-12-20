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
     <li><a class="dropdown-item"  href="{{ route('caissier.operation.print',$item->token) }}">Imprimer</a></li>
 </ul>
</div>
@endsection

@section('page-header')
    <div class="d-flex justify-content-between mt-1">
        <h5 class="page-title mb-0 mt-1 fs-3">Bordereau de saisie de DECAISSEMENT</h5>
    </div>
@endsection

@section('content')

    <div style="height: 75vh; width: 500px; margin:1rem auto; overflow:scroll;" class="card mt-1">
        <div class="card-body">
            <div class="d-flex gap-2 justify-content-between">
                <div style="float: left">
                    <p><span>DEMANDEUR:</span> <span class="fw-bold">{{ $item->agent?->name }}</span></p>
                </div>
                <div style="float: right">
                    <p><span>DATE:</span> <span class="fw-bold">{{ \Carbon\Carbon::parse($item->day)->format('d/m/Y') }}</span></p>
                </div>
            </div>
            <table class="table" style="margin-top: 3rem;">
                <tr class="w-full">
                    <td class="w-half">
                        <div class="d-flex justify-content-between">
                            <p><span>DEP 1:</span> <span class="fw-bold">{{ $item->departement_un?->name }}</span></p>
                            <div style="width: 100px; height: 20px; border: 2px #000 solid; float: left;">

                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <table class="table" style="margin-top: 3rem;">
                <tr class="w-full">
                    <td class="w-half">
                        <div class="d-flex justify-content-between">
                            <p><span>DEP 2:</span> <span class="fw-bold">{{ $item->departement_deux?->name }}</span></p>
                            <div style="width: 100px; height: 20px; border: 2px #000 solid; float: left;">

                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="">
                <p><span>NATURE DE LA DEPENSE :</span> <span class="fw-bold">{{ $item->libelle }}</span></p>
                <p><span>DOSSIER :</span> <span class="fw-bold">{{ $item->dossier }}</span></p>
                <p><span>P/C :</span> </p>
                <p><span>TOTAL MONTANT CHIFFRE :</span> <span class="fw-bold">{{ number_format($mc,0,',','.') }} FCFA</span></p>
                <p><span>TOTAL MONTANT EN LETTRES :</span> <span class="fw-bold">{{ $ml }} Francs cfa</span></p>
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
       window.location.href = "/caissier/operation/"+e.data.token
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

