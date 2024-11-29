<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <title>{{$invoice->id}}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Mongolian&display=swap');
        body {
            font-family: 'DejaVu Sans', sans-serif !important;
            text-align: center;
            color: #777;
        }
        
        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }
        
        body h3 {
            font-weight: 300;
            margin-top: 10px;
            margin-bottom: 20px;
            font-style: italic;
            color: #000000;
        }
        
        body a {
            color: #06f;
        }
        
        .invoice-box {
            padding: 30px;
            font-size: 16px;
            line-height: 24px;
            font-family: 'DejaVu Sans', sans-serif !important;
            color: #000000;
        }
        
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        
        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }
            
            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #fff; /* Arka plan rengi */
            padding: 10px 0;
            font-size: 13px;
            line-height: 20px;
            text-align: left;
            border-top: 1px solid #ccc; /* İsteğe bağlı, üst sınır */
        }
    </style>
</head>
@php
$items = json_decode($invoice->items, true);
$authorCompany = json_decode($invoice->author_company ,true);

@endphp
<body>
    <div class="invoice-box">
        <table>
            <tr>
                <td>
                    <b>
                        <h2 style="margin: 0px; border-bottom: 1px solid #ddd; padding: 4px;">Kunde</h2>
                    </b>
                    <br>
                </td>
            </tr>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td style="font-size: 12px;">
                                <span style="font-size: 8px;">{{$authorCompany['name'] ?? 'N/A'}}, {{$authorCompany['city'] ?? 'N/A'}}, {{$authorCompany['country'] ?? 'N/A'}}, {{$authorCompany['zip_code'] ?? 'N/A'}}<br></span>
                                <b>{{$authorCompany['name'] ?? 'N/A'}}</b><br/>
                                <b>{{$invoice->customer['name'] ?? 'N/A'}}</b><br/>
                                {{$invoice->customer['street'] ?? 'N/A'}}, {{$invoice->customer['zip_code'] ?? 'N/A'}} {{$invoice->customer['city'] ?? 'N/A'}}<br/>
                                {{$invoice->customer['country'] ?? 'N/A'}} <br>
                                {{$invoice->customer['phone'] ?? 'N/A'}} - {{$invoice->customer['email'] ?? 'N/A'}} 
                                <br><br><br>
                            </td>
                            <td style="font-size: 10px; text-align: left;">
                                <div style="border: 2px solid black; height: 150px; width: 250px; padding: 10px; margin-left: auto;">
                                    <table style="margin-top: 10px;">
                                        <tr>
                                            <td style="line-height: 14px; padding: 0px;">
                                                <b>Sachbearbeiter:</b> <br>
                                                <b>Telefon:</b> <br>
                                                <b>Telefax:</b> <br>
                                                <b>E-Mail:</b>
                                            </td>
                                            <td style="line-height: 14px; text-align: left; padding: 0px;">
                                                {{$authorCompany['phone'] ?? 'N/A'}} <br>
                                                {{$authorCompany['fax'] ?? 'N/A'}} <br>
                                                <a href="">{{$authorCompany['email'] ?? 'N/A'}}</a> <br>
                                            </td>
                                        </tr>
                                    </table>
                                    <table style="margin-top: 15px;">
                                        <td style="padding: 0px; padding-bottom: 3px; line-height: 13px;"><b>Bankverbindung:</b></td>
                                        <tr>
                                            <td style="line-height: 13px; font-size: 9px; padding: 0px;">
                                                <b>IBAN</b> <br>
                                                <b>BIC</b>
                                            </td>
                                            <td style="line-height: 13px; font-size: 9px; text-align: left; padding: 0px;">
                                                {{$authorCompany['iban'] ?? 'N/A'}} <br>
                                                {{$authorCompany['bic'] ?? 'N/A'}}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <p style="text-align: left; font-size: 12px;"><b>Verladeadressen</b></p>
            <table>
                <tr class="heading">
                    <td style="font-size: 8px; text-align: left;">Pos.</td>
                    <td style="font-size: 8px; text-align: left;">Bezeichnung</td>
                    <td style="font-size: 8px; text-align: left;">Einzel €</td>
                    <td style="font-size: 8px; text-align: left;">MwSt €</td>
                    <td style="font-size: 8px; text-align: left;">Gesamt €</td>
                </tr>
                
                <tr class="item">
                    <td style="font-size: 8px; text-align: left;">1</td>
                    <td style="font-size: 8px; text-align: left; line-height: 9px;">
                        <b>#{{$invoice->id}}</b> <br>
                        <ins>Adressen Hochladen:</ins> <br>
                        @foreach ($items as $item)
                        {{$item['name'] ?? 'N/A'}}, {{$item['description'] ?? 'N/A'}}<br>
                        @endforeach
                        <br>
                    </td>
                    <td style="font-size: 8px; text-align: left;">{{$invoice->totalprice - $invoice->tax}} €</td>
                    <td style="font-size: 8px; text-align: left;">{{$invoice->tax}} € <small style="color: #06f ">19%</small></td>
                    <td style="font-size: 8px; text-align: left;">{{$invoice->totalprice}} €</td>
                    
                </tr>
                <tr class="item">
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                </tr>
                <tr class="item">
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                    <td style="border: none;"></td>
                </tr>
            </table>
        <br>
        <div style="font-size: 12px; line-height: 14px; text-align: left;">
            *Steuerschuldnerschaft des Leistungsempfängers (Reverse Charge) <br>
            Der Beleg ist innerhalb der nächsten 7 Tage fällig (spätestens am {{ $invoice->created_at->addDays(7)->format('d.m.Y') }} ) <br>
            Vielen Dank für die gute Zusammenarbeit. <br>
            Bewerten Sie uns jetzt gerne auf Google unter {{$authorCompany['name'] ?? 'N/A'}} <br>
        </div>

        <div class="footer">
            <table style="height: auto;">
                <tr style="margin-top: 80%;">
                    <td style="font-size: 11px; line-height: 14px; text-align: left;">
                        <span style="color: #0c2ac0"><b>{{$authorCompany['name'] ?? 'N/A'}}</b></span> <br>
                        {{$authorCompany['street'] ?? 'N/A'}}, {{$authorCompany['zip_code'] ?? 'N/A'}}, {{$authorCompany['city'] ?? 'N/A'}} <br>
                        <b>T</b> {{$authorCompany['phone'] ?? 'N/A'}}  <br>
                       <b>E-Mail</b> <a href="">{{$authorCompany['email'] ?? 'N/A'}}</a>, <br>
    
                    </td>
                    <td style="font-size: 11px; line-height: 14px; text-align: left;">
                        <b>IBAN</b> {{$authorCompany['iban'] ?? 'N/A'}} <br>
                        <b>BIC</b> {{$authorCompany['bic'] ?? 'N/A'}} <b>Bank</b> Sparkasse Essen  <br>
                        <b>StNr</b> {{$authorCompany['stnr'] ?? 'N/A'}} <br>
                        <b>Ust-Id Nr.</b> {{$authorCompany['ust_id_nr'] ?? 'N/A'}}<br>
                    </td>
                    <td style="font-size: 11px; line-height: 14px; text-align: left;">
                        <b>HRB</b> {{$authorCompany['hrb'] ?? 'N/A'}}<br>
                        <b>Registergericht</b> {{$authorCompany['registry_court'] ?? 'N/A'}} <br>
                        <b>Geschäftsführer</b><br>
                        {{$authorCompany['general_manager'] ?? 'N/A'}} <br>
    
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>