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
            font-size: 12px;
        }
        .fw-bold{
            font-weight: 900;
        }
    </style>
</head>
<body>
    <header>
        <div style="">
            <div style="">
                <div class="d-flex justify-content-between">
                    <div class="" style="float:left">
                        <img style="border:none; height: 75px; width:160px;" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/dhl.jpeg'))) }}" class="image img-thumbnail" height="80px"/>
                    </div>
                    <div  style="padding-left:20px; float: left;text-align:center;">
                        <h5>PIECE DE DECAISSEMENT</h5>
                        <h6>N° {{ $item->name }}</h6>
                    </div>
                    <div style="float:right;">
                        <img style="border:none; height: 75px; width:160px;" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/satcongo.jpeg'))) }}" class="image img-thumbnail" height="80px"/>
                    </div>
                </div>
            </div>
      </div>
    </header>
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
        <table style="margin-top: 3rem;">
            <tr class="w-full">
                <td class="w-half">
                    <div style="float: left">
                        <p><span>DEP 1:</span> <span class="fw-bold">{{ $item->departement_un?->name }}</span> - <span class="fw-bold">{{ number_format($item->mt_departement_un,0,',','.') }} FCFA</span></p>
                    </div>
                </td>
            </tr>
        </table>
        <table style="margin-top: 2rem;">
            <tr class="w-full">
                <td class="w-half">
                    <div style="float: left">
                        <p><span>DEP 2:</span> <span class="fw-bold">{{ $item->departement_deux?->name }}</span> - <span class="fw-bold">{{ number_format($item->mt_departement_deux,0,',','.') }} FCFA</span></p>
                    </div>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <p><span>NATURE DE LA DEPENSE :</span> <span class="fw-bold">{{ $item->libelle }}</span></p>
        <p><span>DOSSIER :</span> <span class="fw-bold">{{ $item->dossier?->code }}</span></p>
        <p><span>P/C :</span> <span class="fw-bold">{{ $item->dossier?->client?->name }}</span> </p>
        <p><span>TOTAL MONTANT CHIFFRE :</span> <span class="fw-bold">{{ number_format($mc,0,',','.') }} FCFA</span></p>
        <p><span>TOTAL MONTANT EN LETTRES :</span> <span class="fw-bold">{{ $ml }} Francs cfa</span></p>

        <table>
            <tbody>
                <tr style="width: 100%;">
                    <td style="width: 260px;">
                        <p style="margin-bottom: 0;">SIGN. DEMANDEUR</p>
                        <div style="width: 220px; height: 45px; border: 1px #777 solid;">

                        </div>
                    </td>
                    <td style="width: 260px;">
                        <p style="margin-bottom: 0;">SIGN. DG</p>
                        <div style="width: 220px; height: 45px; border: 1px #777 solid;">

                        </div>
                    </td>
                    <td style="width: 260px;">
                        <p style="margin-bottom: 0;">NOM ET SIGN. BENEFICIAIRE</p>
                        <div style="width: 220px; height: 45px; border: 1px #777 solid;">

                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

    </main>
</body>
</html>


