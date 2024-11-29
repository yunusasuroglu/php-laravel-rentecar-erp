
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rückgabeprotokoll</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333333;
            /* background-color: #f4f4f4; */
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .header img {
            max-width: 150px;
        }
        .content {
            margin: 20px 0;
        }
        .content h1 {
            color: #000000;
        }
        .content h2 {
            color: #333333;
            margin-bottom: 10px;
        }
        .content p {
            line-height: 1.6;
        }
        .table-container {
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #dddddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .footer {
            text-align: center;
            padding: 20px 0;
            font-size: 12px;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://www.jet-cars.de/images/logo-light.png" alt="Jetcars Logo">
        </div>
        <div class="content">
            <h2>Rückgabeprotokoll</h2>
            <p><strong>Fahrzeug:</strong> {{ $carModel }}</p>
            <p><strong>Kennzeichen:</strong> {{ $licensePlate }}</p>
            <p><strong>Datum der Rückgabe:</strong> {{ \Carbon\Carbon::parse($returnDate)->format('d.m.Y') }}</p>
            <p><strong>Uhrzeit der Rückgabe:</strong> {{ $returnTime }}</p>
            <p><strong>Rückgabeort:</strong> Herrhausenstraße 11, 27721 Ritterhude</p>
            
            <h2>Vergleich zwischen Übergabe und Rückgabe</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Kriterium</th>
                            <th>Übergabe</th>
                            <th>Rückgabe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Warndreieck</td>
                            <td>{{ $warningTriangle == 'yes' ? 'Ja' : 'Nein' }}</td>
                            <td>{{ $handoverWarningTriangle == 'yes' ? 'Ja' : 'Nein' }}</td>
                        </tr>
                        <tr>
                            <td>Reflektorweste</td>
                            <td>{{ $warningVest == 'yes' ? 'Ja' : 'Nein' }}</td>
                            <td>{{ $handoverWarningVest == 'yes' ? 'Ja' : 'Nein' }}</td>
                        </tr>
                        <tr>
                            <td>Erste-Hilfe-Set</td>
                            <td>{{ $firstAidKit == 'yes' ? 'Ja' : 'Nein' }}</td>
                            <td>{{ $handoverFirstAidKit == 'yes' ? 'Ja' : 'Nein' }}</td>
                        </tr>
                        <tr>
                            <td>Reinigungszustand</td>
                            <td>{{ $returnCleanliness == 'yes' ? 'Ja' : 'Nein' }}</td>
                            <td>{{ $handoverCarCleanliness == 'yes' ? 'Ja' : 'Nein' }}</td>
                        </tr>
                        <tr>
                            <td>Reifenprofil</td>
                            <td>{{ $tireProfile}}</td>
                            <td>{{ $handoverTireProfile}}</td>
                        </tr>
                        <tr>
                            <td>Damage Report</td>
                            <td>
                                @if(!empty($pickupDamageImages))
                                    @foreach($pickupDamageImages as $image)
                                        <img src="{{ $image }}" style="width:100px; height:auto;">
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @if(!empty($handoverDamageImage))
                                    @foreach($handoverDamageImage as $image)
                                        <img src="{{ $image }}" style="width:100px; height:auto;">
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Internal Damage Report</td>
                            <td>
                                @if(!empty($internalPickupDamageImages))
                                    @foreach($internalPickupDamageImages as $image)
                                        <img src="{{ $image }}" style="width:100px; height:auto;">
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @if(!empty($internalHandoverDamageImage))
                                    @foreach($internalHandoverDamageImage as $image)
                                        <img src="{{ $image }}" style="width:100px; height:auto;">
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        @if ($contract->extra_km != 0)
                        <tr>
                            <td>Extra KM</td>
                            <td>
                                {{$contract->extra_km}}
                            </td>
                        </tr>
                        @else

                        @endif
                    </tbody>
                </table>
            </div>
            <p><strong>Anmietung:</strong> {{ \Carbon\Carbon::parse($contract->start_date)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($returnDate)->format('d.m.Y') }}</p>
            <p><strong>Mietdauer:</strong> {{ $returnDay + 1}} Tage</p>
            
            <p>Deliver</p>
            <img src="{{asset($deliverReportImage)}}" style="width:100%;" alt="">
            <br><br>
            <p>Pickup</p>
            <img src="{{asset($pickupReportImage)}}" style="width:100%;" alt="">
        </div>
        <div class="footer">
            <p>&copy; 2024 Jetcars. Alle Rechte vorbehalten.</p>
        </div>
    </div>
</body>
</html>
