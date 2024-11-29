<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .qr-code {
            width: 100px;
            height: 100px;
            background-color: #f8f9fa;
        }

        @media print {
            body {
                width: 210mm;
                height: 297mm;
            }
        }

        body {
            font-size: 12px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .qr-code {
            width: 100px;
            height: 100px;
            background-color: #f8f9fa;
        }

        .footer-text {
            font-size: 10px;
        }

        .dotted-line {
            border-bottom: 1px dotted #000;
            margin-bottom: 10px;
        }
    </style>
    <style>
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            color: red;
            font-size: 24px;
            font-weight: bold;
        }

        .subheader {
            font-size: 14px;
            margin-top: 5px;
        }

        .divider {
            border-top: 1px solid #000;
            margin: 10px 0;
        }

        .address {
            margin-bottom: 20px;
        }

        .customer-info {
            float: right;
            text-align: right;
        }

        .clear {
            clear: both;
        }
    </style>
</head>
@php
$customerData = $invoice->customer;
$companyData = json_decode($invoice->author_company, true);
$items = json_decode($invoice->items, true);
@endphp
<body>
    <div class="container">
    <div class="header">
        <div class="logo">
            <img style="width: 300px;;" src="{{asset($companyData['logo'])}}" alt="">
        </div>
        <div class="subheader">IHRE AUTOVERMIETUNG</div>
    </div>

    <div class="divider"></div>

    <div class="address">
    {{$companyData['name'] ?? 'N/A'}} | {{$companyData['street'] ?? 'N/A'}} | {{$companyData['zip_code'] ?? 'N/A'}} {{$companyData['city'] ?? 'N/A'}}
    </div>

    <div>
        <div style="float: left;">
            {{ $customerData['name'] ?? 'Müşteri adı yok' }}<br>
            {{ $customerData['address'] ?? 'Adres yok' }}<br>
            {{ $customerData['zip_code'] ?? 'Posta kodu yok' }} {{ $customerData['city'] ?? '0' }}<br>
            Deutschland
        </div>

        <div class="customer-info">
            <table>
                <tr>
                    <td align="right">Kunden-Nr.:</td>
                    <td align="right">{{ $customerData['id'] ?? '0' }}</td>
                </tr>
                <tr>
                    <td align="right">Vorgang Nr.:</td>
                    <td align="right">2405001103</td>
                </tr>
                <tr>
                    <td align="right">Rechnung Nr.:</td>
                    <td align="right">1-{{$invoice->id}}</td>
                </tr>
                <tr>
                    <td align="right">Rechnungsdatum:</td>
                    <td align="right">{{ date('d.m.Y') }}</td> <!-- Günün tarihini dinamik olarak ekler -->
                </tr>
                <tr>
                    <td align="right">Mieter / Kunde:</td>
                    <td align="right">{{ $customerData['name'] ?? 'Müşteri adı yok' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="clear"></div>
    </div>

    <div class="">
        <div class="row">
            <div class="col-9">
                <h2>Rechnung</h2>
            </div>
            <div class="col-3">
                <div class="qr-code float-end"></div>
            </div>
        </div>
        <div class="row mt-2" style="display: flex; justify-content: space-between;">
            <div class="col-4" style="flex: 1; padding: 5px;">
                <p style="margin: 5px 0;"><strong>Mietstation:</strong> Herrhausenstraße 11</p>
                <p style="margin: 5px 0;"><strong>Abholung:</strong> Herrhausenstraße 11</p>
                <p style="margin: 5px 0;"><strong>Rückgabe:</strong> Herrhausenstraße 11</p>
                <p style="margin: 5px 0;"><strong>Mietartikel:</strong> {{ $items[0]['name'] ?? 'N/A' }}</p>
                <p style="margin: 5px 0;"><strong>Kennzeichen:</strong> {{ $items[0]['number_plate'] ?? 'N/A' }}</p>
            </div>
            <div class="col-4" style="flex: 1; padding: 10px;">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Reservierung geplant Datum / Uhrzeit</th>
                            <th>Tatsächlich gemietet km Datum / Uhrzeit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $invoice->start_date }} / 00:00 Uhr</td>
                            <td>{{ $invoice->end_date }} / 00:00 Uhr</td>
                        </tr>
                        <tr>
                        <td>{{ $invoice->start_date }} / 00:00 Uhr</td>
                        <td>{{ $invoice->end_date }} / 00:00 Uhr</td>
                        </tr>
                    </tbody>
                </table>
                <p><strong>Inkl.Tarif-km:</strong> 800</p>
                <p><strong>Gesamt-km:</strong> 590</p>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12" style="display: flex; justify-content: flex-end;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Anzahl</th>
                            <th>Bezeichnung</th>
                            <th>Preis / Einheit</th>
                            <th>Gesamtpreis</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['total_amount'] ? $item['total_amount'] . ' EUR' : 'N/A' }}</td>
                                <td>{{ $item['total_amount'] ? $item['total_amount'] . ' EUR' : 'N/A' }}</td>
                            </tr>
                        @endforeach
                        
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Gesamt Netto </td>
                            <td>{{ $invoice->subtotalprice }} EUR</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>+ 19% MwSt </td>
                            <td>{{ $invoice->tax }} EUR</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>- Rabatt</td>
                            <td>{{ $invoice->discount }} EUR</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Bruttobetrag</td>
                            <td>{{$invoice->totalprice}} EUR</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Zu bezahlen</td>
                            <td style="text-decoration: underline; text-align: end;"><strong>0,00 EUR</strong></td>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="row mt-4">
        <div class="col-12">
            <p><strong>Zahlart: Barzahlung</strong></p>
            <div class="dotted-line"></div>
            <p>Betrag dankend erhalten<br>
                @if(1==1) <!-- ?? -->
                    (Rechnung ist zu sofort fallig (sofern  keine andere Abmachung getroffen wurde).)
                @else
                    (Rechnung ist auch ohne Unterschrift gültig)
                @endif
            </p>
        </div>
    </div>


    <div class="row mt-4">
        <div class="col-12">
            <p style="font-size: 11px;"><strong>PS: Mit Ihrer E-Mail Adresse: {{$customerData['email'] ?? 'not mail'}} und der
                    Kundennummer {{$customerData['id'] ?? 'not id'}} buchen Sie Ihren Mietartikel ab jetzt noch schneller.</strong></p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <table class="table table-sm footer-text">
                <tr>
                    <td>{{$companyData['name'] ?? 'N/A'}}</td>
                    <td>Telefon: {{$companyData['phone'] ?? 'N/A'}}</td>
                    <td>USt-ID: DE338915426</td>
                    <td>{{$companyData['name'] ?? 'N/A'}}</td>
                </tr>
                <tr>
                    <td>{{$companyData['street'] ?? 'N/A'}}</td>
                    <td>{{$companyData['email'] ?? 'N/A'}}</td>
                    <td>Steuernr.: {{$companyData['stnr'] ?? 'N/A'}}</td>
                    <td>{{$companyData['iban'] ?? 'N/A'}}</td>
                </tr>
                <tr>
                    <td>{{$companyData['zip_code'] ?? 'N/A'}} {{$companyData['street'] ?? 'N/A'}}</td>
                    <td>www.jet-cars.de</td>
                    <td>HRB {{$companyData['hrb'] ?? 'N/A'}}</td>
                    <td>BIC: {{$companyData['bic'] ?? 'N/A'}}</td>
                </tr>
                <tr>
                    <td>Deutschland</td>
                    <td></td>
                    <td>{{$companyData['city'] ?? 'N/A'}}</td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
    </div>
</body>

</html>
