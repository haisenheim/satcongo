<html>
    <head>

    </head>
    <body>

            <table>
                <tbody>
                    <tr>
                        <td colspan="1">
                            <img src="{{public_path('img/satcongo.jpeg')}}" height="180" alt="">
                        </td>
                        <td colspan="6">
                            <h4 style="font-size: 24px; text-align: center;">Journal des operations</h4>
                            <h5 style="font-size: 16px; text-align: center;">Journal : {{ $caisse->name }} </h5>
                            <h6 style="font-size: 14px; text-align: center;">Periode du {{ $start }} au {{ $end }}</h6>
                        </td>
                    </tr>
                </tbody>
            </table>
                <table>
                    <thead>
                        <tr>
                            <th style="color: white;">N° compte général</th>
                            <th style="color: white;">N° compte tiers</th>
                            <th style="color: white;">Code journal</th>
                            <th style="color: white;">Numéro facture</th>
                            <th style="color: white;"> N° pièce</th>
                            <th style="color: white;">Libellé écriture</th>
                            <th style="color: white;">Date de pièce</th>
                            <th style="color: white;">Montant débit</th>
                            <th style="color: white;">Montant crédit</th>
                            <th style="color: white;"> N° plan analytique</th>
                            <th style="color: white;">N° section 1</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $item)
                        <tr>
                            <td>{{ $item->compte }}</td>
                            <td></td>
                            <td>{{ $item->operation->caisse?->name }}</td>
                            <td>{{ $item->operation->name }}</td>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item->operation->libelle }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->day)->format('y/m/d')  }}</td>
                            @if(!$item->credit)
                                <td>{{ number_format($item->montant,0,',','.') }}</td>
                            @else
                                <td></td>
                            @endif
                            @if($item->credit)
                                <td></td>
                            @else
                                <td>{{ number_format($item->montant,0,',','.') }}</td>
                            @endif
                            <td></td>
                            <td>{{ $item->operation->dossier }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


    </body>
</html>
