<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Ordre de paiement</title>
    <style>
        /** Define the margins of your page **/
        @page {
            margin: 100px 25px;
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
        .header{
            border-bottom: #000 solid 1px;
            padding-bottom: 10px;
            font-weight: bold;
            height: 60px;
        }
        header {
            position: fixed;
            top: -120px;
            left: 0px;
            right: 0px;
            height: 75px;
            border-bottom: #000 solid 1px;
            padding-bottom: 10px;
            /** Extra personal styles **/
        }
        main{
            font-size: 12px;
        }
        body {
            font-family: Arial, sans-serif;

            line-height: 1.6;
            position: relative;
        }
        .fw-bold{
            font-weight: 900;
        }
        .box-inner{
            width: 80px;
            height: 20px;
            border: 1px solid #000000
        }
        .box p{
            margin-bottom: 0;
            font-size: 11px;
            font-weight: bold;
        }

        table{
            width: 100%;
            margin-bottom: 1rem;
            vertical-align: top;
        }

        tr {
            border-color: inherit;
            border-style: solid;
            border-width: 0;
        }

        table > :not(caption) > * > * {
            padding: .75rem .5rem;
        }

    </style>
</head>
<body>
    <header>
        <div  style="width: 200px; margin: 0 auto;">
            <h5 style="margin-bottom: 0;">PIECE DE DECAISSEMENT</h5>
            <h6>N° {{ $item->name }}</h6>
        </div>
    </header>
    <main style="">
        <table>
            <tbody>
                <tr>
                    <th>
                        <span>CLIENT:</span> <span class="fw-bold">{{ $item->client?->name }}</span>
                    </th>
                    <th>
                        <span>DOSSIER:</span> <span class="fw-bold">{{ $item->dossier?->code }}</span>
                    </th>
                </tr>
            </tbody>
        </table>

        <p><span>BENEFICIAIRE :</span> <span class="fw-bold">{{ $item->beneficiaire }}</span></p>
        <p><span>NATURE DE LA DEPENSE :</span> <span class="fw-bold">{{ $item->libelle }}</span></p>

        <p><span>TOTAL MONTANT CHIFFRE :</span> <span class="fw-bold">{{ number_format($item->montant,0,',','.') }} FCFA</span></p>
        <p><span>TOTAL MONTANT EN LETTRES :</span> <span class="fw-bold">{{ $item->mt_lettres }} Francs cfa</span></p>

        <table>
            <tr style="width: 100%;">
                <td class="box">
                    <p>ESPECE</p>
                    <div class="box-inner"></div>
                </td>
                <td class="box">
                    <p>CHEQUE </p>
                    <div class="box-inner"></div>
                </td>
                <td class="box">
                   <p>N° DU CHEQUE </p>
                   <div class="box-inner"></div>
                </td>
                <td class="box" >
                    <p>DEBOURS </p>
                    <div class="box-inner"></div>
                </td>
                <td class="box">
                    <p>PRESTATIONS</p>
                    <div class="box-inner"></div>
                </td>
            </tr>
        </table>

        <div class="d-flex justify-content-between">
            <table style="margin-top: 0p;">
                <tbody>
                    <tr style="width: 100%;">
                        <td style="width: 180px;">
                            <p style="margin-bottom: 0; font-size:10px;">SIGN. CHEF DEPARTEMENT</p>
                            <div style="width: 160px; height: 70px; border: 1px #777 solid;">

                            </div>
                        </td>
                        <td style="width: 180px;">
                            <p style="margin-bottom: 0; font-size:10px;">SIGN. SERV. CONTROLE DEPENSE</p>
                            <div style="width: 160px; height: 70px; border: 1px #777 solid;">

                            </div>
                        </td>
                        <td style="width: 180px;">
                            <p style="margin-bottom: 0; font-size:10px;">SIGN. DG</p>
                            <div style="width: 160px; height: 70px; border: 1px #777 solid;">

                            </div>
                        </td>
                        <td style="width: 180px;">
                            <p style="margin-bottom: 0; font-size:10px;">NOM ET SIGN. RECEPTEUR</p>
                            <div style="width: 160px; height: 70px; border: 1px #777 solid;">

                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="padding-top:0; border:1px #000">
            <img style="height: 60px; width:120px; margin: 1px auto;" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/satcongo.jpeg'))) }}" class="image img-thumbnail" height="80px"/>
        </div>
    </main>


    <main style="border-top:#000 dotted 1px; padding-top:10px;">
        <div class="header">
            <div style="text-align:center; width: 400px; margin: 1px auto;">
                <h5 style="margin-bottom: 0;">PIECE DE DECAISSEMENT</h5>
                <h6>N° {{ $item->name }}</h6>
            </div>
        </div>
        <table style="">
            <tbody>
                <tr>
                    <th>
                        <span>CLIENT:</span> <span class="fw-bold">{{ $item->client?->name }}</span>
                    </th>
                    <th>
                        <span>DOSSIER:</span> <span class="fw-bold">{{ $item->dossier?->code }}</span>
                    </th>
                </tr>
            </tbody>
        </table>

        <p><span>BENEFICIAIRE :</span> <span class="fw-bold">{{ $item->beneficiaire }}</span></p>
        <p><span>NATURE DE LA DEPENSE :</span> <span class="fw-bold">{{ $item->libelle }}</span></p>

        <p><span>TOTAL MONTANT CHIFFRE :</span> <span class="fw-bold">{{ number_format($item->montant,0,',','.') }} FCFA</span></p>
        <p><span>TOTAL MONTANT EN LETTRES :</span> <span class="fw-bold">{{ $item->mt_lettres }} Francs cfa</span></p>

        <table>
            <tr style="width: 100%;">
                <td class="box">
                    <p>ESPECE</p>
                    <div class="box-inner"></div>
                </td>
                <td class="box">
                    <p>CHEQUE </p>
                    <div class="box-inner"></div>
                </td>
                <td class="box">
                   <p>N° DU CHEQUE </p>
                   <div class="box-inner"></div>
                </td>
                <td class="box" >
                    <p>DEBOURS </p>
                    <div class="box-inner"></div>
                </td>
                <td class="box">
                    <p>PRESTATIONS</p>
                    <div class="box-inner"></div>
                </td>
            </tr>
        </table>

        <div class="d-flex justify-content-between">
            <table style="margin-top: 0px;">
                <tbody>
                    <tr style="width: 100%;">
                        <td style="width: 180px;">
                            <p style="margin-bottom: 0; font-size:10px;">SIGN. CHEF DEPARTEMENT</p>
                            <div style="width: 160px; height: 60px; border: 1px #777 solid;">

                            </div>
                        </td>
                        <td style="width: 180px;">
                            <p style="margin-bottom: 0; font-size:10px;">SIGN. SERV. CONTROLE DEPENSE</p>
                            <div style="width: 160px; height: 60px; border: 1px #777 solid;">

                            </div>
                        </td>
                        <td style="width: 180px;">
                            <p style="margin-bottom: 0; font-size:10px;">SIGN. DG</p>
                            <div style="width: 160px; height: 60px; border: 1px #777 solid;">

                            </div>
                        </td>
                        <td style="width: 180px;">
                            <p style="margin-bottom: 0; font-size:10px;">NOM ET SIGN. RECEPTEUR</p>
                            <div style="width: 160px; height: 60px; border: 1px #777 solid;">

                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="padding-top:0px; border:1px #000">
            <img style="height: 60px; width:120px; margin: 1px auto;" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/satcongo.jpeg'))) }}" class="image img-thumbnail" height="80px"/>
        </div>

    </main>
</body>
</html>


