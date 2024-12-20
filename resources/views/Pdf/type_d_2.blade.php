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
        .fw-bold{
            font-weight: 800
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
        body {
            font-family: Arial, sans-serif;

            line-height: 1.6;
            position: relative;
        }
        .filigrane-image {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg); /* Rotation de l'image */
            opacity: 0.3; /* Opacité de l'image du filigrane */
            z-index: -1; /* Placer le filigrane derrière le texte */
        }
        .fw-bold{
            font-weight: 900;
        }
    </style>
</head>
<body>
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/duplicata.jpg'))) }}" class="filigrane-image" width="300" height="300" />
    <header>
        <div style="">
            <div style="">
                <div class="d-flex justify-content-between">
                    <div class="" style="float:left">
                        <img style="border:none; height: 75px; width:160px;" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/dhl.jpeg'))) }}" class="image img-thumbnail" height="80px"/>
                    </div>
                    <div  style="padding-left:20px; float: left;text-align:center;">
                        <h5>PIECE DE DECAISSEMENT TRANSPORT</h5>
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
        <table style="margin-top: 2rem;">
            <tr style="margin-top: 1rem;" >
                <td style="width: 275px;">
                    <div>
                        <table>
                            <tr>
                                <td>
                                    <span>PEAGE:</span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($item->peage,0,',','.') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>HOTEL:</span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($item->hotel,0,',','.') }}</span>
                                </td>
                            </tr>

                        </table>
                    </div>
                </td>
                <td style="width: 275px;">
                    <div>
                        <table>
                            <tr>
                                <td>
                                    <span>RATION :</span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($item->ration,0,',','.') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>PRIME : </span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($item->prime,0,',','.') }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td style="width: 275px;">
                    <div>
                        <table>
                            <tr>
                                <td>
                                    <span>BAC:</span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($item->bac,0,',','.') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    AUTRE :
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($item->autres,0,',','.') }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="width:270px;">
                    <p><span>DOSSIER :</span> <span class="fw-bold">{{ $item->dossier }}</span></p>
                </td>
                <td style="width:270px;">
                    <p><span>CHAUFFEUR :</span> <span class="fw-bold">{{ $item->chauffeur }}</span></p>
                </td>
                <td style="width:270px;">
                    <p><span>CAMION :</span> <span class="fw-bold">{{ $item->camion }}</span></p>
                </td>
            </tr>
        </table>

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


