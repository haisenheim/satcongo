<html>
    <head>

    </head>
    <body>

            <table>
                <tbody>
                    <tr>
                        <td colspan="1">
                            <img src="{{public_path('img/logo.png')}}" height="180" alt="">
                        </td>
                        <td colspan="4">
                            <h4 style="font-size: 24px; text-align: center;">Journal des operations</h4>
                            <h5 style="font-size: 16px; text-align: center;">Journal : {{ $caisse->name }} / {{ $caisse->agence->name }} {{ $caisse->ville->name }}</h5>
                            <h6 style="font-size: 14px; text-align: center;">Periode du {{ $start }} au {{ $end }}</h6>
                        </td>
                    </tr>
                </tbody>
            </table>
                <table>
                    <thead>
                        <tr>
                            <th style="color: white;">DATE</th>
                            <th style="color: white;">REFERENCE</th>
                            <th style="color: white;">Numero de Compte</th>
                            <th style="color: white;">Libellé Ecriture</th>
                            <th style="color: white;">Mt Débit</th>
                            <th style="color: white;">Mt Crédit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->day)->format('d/m/Y')  }}</td>
                            <td>{{ $item->ref }}</td>
                            <td>{{ $item->compte }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->credit?'':$item->montant }}</td>
                            <td>{{ $item->credit?$item->montant:'' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


    </body>
</html>
