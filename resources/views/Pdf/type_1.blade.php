<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Bordereau</title>
    <style>
        /** Define the margins of your page **/
        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: -90px;
            left: 0px;
            right: 0px;
            border-bottom: #000 solid 1px;
            padding-bottom: 90px;
            /** Extra personal styles **/
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/

            text-align: center;
            border-top: #000 solid 1px;
            padding-top: 5px;
            font-weight: 700;
        }
        .w-full {
            width: 100%;
        }
        .w-half {
            width: 50%;
        }
        .d-flex{
            display: flex;
        }
        .justify-content-between{
            justify-content: space-between
        }
        main{
            font-size: 11px;
        }
    </style>
</head>
<body>
    <header>
        <div style="">
            <div style="">
                <div class="d-flex justify-content-between">
                    <div class="" style="float:left">
                        <img style="border:none; height: 75px; width:120px;" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/dhl.jpeg'))) }}" class="image img-thumbnail" height="80px"/>
                    </div>
                    <div  style="padding-left:20px; float: left;text-align:center;">
                        <h6>PIECE DE DECAISSEMENT</h6>
                        <h6>N° {{ time() }}</h6>
                    </div>
                    <div style="float:right;">
                        <img style="border:none; height: 75px; width:120px;" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/satcongo.jpeg'))) }}" class="image img-thumbnail" height="80px"/>
                    </div>
                </div>
            </div>
      </div>
    </header>

    <footer>
        <div style="font-size: 12px">
             <p style="margin:0"><span>&copy; SatCongo</span></p>
        </div>
    </footer>
    <main style="margin-top:10px;">
        <table class="w-full">
            <tbody>
                <tr>
                    <td class="w-half">
                        <div style="float: left">
                            <p><span>DEMANDEUR:</span> <span class="fw-bold">{{ $item->agent?->name }}</span></p>
                        </div>
                    </td>
                    <td class="w-half">
                        <div style="float: right">
                            <p><span>DATE:</span> <span class="fw-bold">{{ \Carbon\Carbon::parse($item->day)->format('d/m/Y') }}</span></p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table style="margin-top: 2rem;">
            <tr style="margin-top: 1rem;" class="w-full">
                <td class="w-half">
                    <div style="float: left">
                        <p><span>DEP 1:</span> <span class="fw-bold">{{ $item->departement_un?->name }}</span></p>
                    </div>
                </td>
                <td class="w-half">
                    <div style="width: 100px; height: 20px; border: 3px #000 solid; float: left;">

                    </div>
                </td>
            </tr>
        </table>
        <table style="margin-top: 2rem;">
            <tr class="w-full">
                <td class="w-half">
                    <div style="float: left">
                        <p><span>DEP 2:</span> <span class="fw-bold">{{ $item->departement_deux?->name }}</span></p>
                    </div>
                </td>
                <td class="w-half">
                    <div style="width: 100px; height: 20px; border: 3px #000 solid; float: left;">

                    </div>
                </td>
            </tr>
        </table>
        <br>
        <div class="d-flex justify-content-between">
            <div>
                <p><span>NATURE DE LA DEPENSE :</span> <span class="fw-bold">{{ $item->libelle }}</span></p>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div>
                <p><span>DOSSIER :</span> <span class="fw-bold">{{ $item->dossier }}</span></p>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div>
                <p><span>P/C :</span> </p>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div>
                <p><span>TOTAL MONTANT CHIFFRE :</span> <span class="fw-bold">{{ number_format($mc,0,',','.') }} FCFA</span></p>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <div>
                <p><span>TOTAL MONTANT EN LETTRES :</span> <span class="fw-bold">{{ $ml }} Francs cfa</span></p>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <table>
                <tbody>
                    <tr style="width: 100%;">
                        <td style="width: 175px;">
                            <p style="margin-bottom: 0; text-align: center;">SIGN. DEMANDEUR</p>
                            <div style="width: 160px; height: 30px; border: 3px #000 solid;">

                            </div>
                        </td>
                        <td style="width: 175px;">
                            <p style="margin-bottom: 0; text-align: center;">SIGN. DG</p>
                            <div style="width: 160px; height: 30px; border: 3px #000 solid;">

                            </div>
                        </td>
                        <td style="width: 175px;">
                            <p style="margin-bottom: 0; text-align: center;">NOM ET SIGN. BENEFICIAIRE</p>
                            <div style="width: 160px; height: 30px; border: 3px #000 solid;">

                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>
</body>
</html>


