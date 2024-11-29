<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mietvertrag</title>
    <link rel="stylesheet" href="styles.css">
</head>
@php
$customer = is_array($contract->customer) ? $contract->customer : json_decode($contract->customer, true);
@endphp
<body>
    <div class="container">
        <div class="header">
            <div class="left">
                <h1>Mietvertrag</h1>
                <p><strong>Mietartikel:</strong> {{ $carModel }}</p>
                <p><strong>Kennzeichen:</strong> {{ $licensePlate }}</p>
            </div>
            <div class="right">
                <img src="https://www.jet-cars.de/images/logo-light.png" alt="Jetcars Logo">
            </div>
        </div>

        <div class="section">
            <h3>Station</h3>
            <table class="info-table">
                <tr>
                    <td>Vorgangsnummer:</td>
                    <td>{{ $contract->id }}</td>
                    <td>Mieter 1:</td>
                    <td>{{$customer['name'] . ' ' .$customer['surname'] }}
                    </td>
                </tr>
                <tr>
                    <td>Reservierung von:</td>
                    <td>{{ $contract->start_date }}</td>
                    <td>Kd.Nr.:</td>
                    <td>{{$customer['id'] }}</td>
                </tr>
                <tr>
                    <td>Abholung:</td> <!-- bu -->
                    <td>Herrhausenstraße 11</td>
                    <td>Geburtstag:</td>
                    <td>{{$customer['date_of_birth'] }}</td>
                </tr>
                <tr>
                    <td>Rückgabe:</td> <!-- bu -->
                    <td>Herrhausenstraße 11</td>
                    <td>Tel.:</td>
                    <td>{{$customer['phone'] }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h3>Mietdaten</h3>
            <table class="info-table">
                <tr>
                    <td>Vereinbarte Abholung:</td>
                    <td>
                        {{ \Carbon\Carbon::parse($contract->start_date)->format('d.m.Y') }} / {{ \Carbon\Carbon::parse($contract->start_date)->format('H:i') }} Uhr
                    </td>
                </tr>
                <tr>
                    <td>Tatsächliche Abholung:</td>
                    <td>{{ $contract->pickup_date }}</td>
                </tr>
                <tr>
                    <td>Vereinbarte Rückgabe:</td>
                    <td>
                        {{ \Carbon\Carbon::parse($contract->end_date)->format('d.m.Y') }} / {{ \Carbon\Carbon::parse($contract->end_date)->format('H:i') }} Uhr
                    </td>
                </tr>
                <tr>
                    <td>Km-Stand:</td>
                    <td>{{ json_decode($contract->car, true)['odometer'] }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h3>Berechnung</h3>
            <table class="info-table">
                <tr>
                    <td>Anzahl</td>
                    <td>Bezeichnung</td>
                    <td>Preis/Einheit</td>
                    <td>Gesamtpreis</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>{{ $carModel }}</td>
                    <td>{{ $contract->total_amount }} EUR</td>
                    <td>{{ $contract->total_amount }} EUR</td>
                </tr>
                {{-- <tr>
                    <td>1</td>
                    <td>Haftpflicht Renault Master</td>
                    <td>0,00 EUR</td>
                    <td>0,00 EUR</td>
                </tr> --}}

            </table>
        </div>

        <div class="section">
            <table class = "info-table">
                <tr>
                    <td style="padding: 10px;">
                        <p><strong>Signature:</strong></p>
                        <img src="{{ asset($contract->user_signature) }}" alt="" style="max-width: 100%;">
                    </td>
                    <td style="padding: 10px;">
                        <p><strong>Customer Signature:</strong></p>
                        <img src="{{ asset($contract->signature) }}" alt="" style="max-width: 100%;">
                    </td>
                </tr>
            </table>
        </div>


        <div class="footer" style = "margin-top:20px">
        <img src="{{ asset($contract->deliver_damages_image) }}" style="width: 750px;" alt="">
            <div class="left">
                <p><strong>Kaution:</strong> {{ $contract->deposit }} EUR</p>
                <p><strong>Zahlungsart:</strong> {{ $contract->payment_option }}</p>
            </div>
            <div class="right">
                <p><strong>Datum:</strong> {{$todayDate}}</p>
            </div>
        </div>

    </div>
</body>

</html>
<style>
    .damage-marker {
        position: absolute;
        color: red;
        font-size: 24px;
        font-weight: bold;
        transform: translate(-50%, -50%);
        pointer-events: none;
        /* Prevent the mark from capturing click events */
    }

    .flex {
        display: flex !important;
    }

    img {
        max-width: 100%;
        height: auto;
        display: block;
        margin-left: auto;
        margin-right: auto;
        border: 1px solid #ccc;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 14px;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }

    .container {
        width: 100%;
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header .left {
        flex: 1;
    }

    .header .right {
        flex: 1;
        text-align: right;
    }

    .section {
        margin-bottom: 20px;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
    }

    .info-table td {
        padding: 8px;
        border: 1px solid #ccc;
    }

    .info-table th {
        padding: 8px;
        border: 1px solid #000;
        background-color: #f5f5f5;
        text-align: left;
    }

    .footer {
        display: flex;
        justify-content: space-between;
    }

    .footer .left {
        flex: 1;
    }

    .footer .right {
        flex: 1;
        text-align: right;
    }

    ul {
        padding-left: 20px;
        list-style: disc;
    }

    ul li {
        margin-bottom: 5px;
    }
</style>