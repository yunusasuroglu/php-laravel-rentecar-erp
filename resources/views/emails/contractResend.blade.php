<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestätigung Ihrer Buchung - Jetcars</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333333;
            background-color: #f4f4f4;
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
            color: #d92b2b;
        }
        .content p {
            line-height: 1.6;
        }
        .content a {
            color: #2980b9;
            text-decoration: none;
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
            @php
            $customer = json_decode($contract->customer, true);
            @endphp
            <h1>Vielen Dank für Ihre Buchung bei Jetcars!</h1>
            <p>Sehr geehrte/r {{ $customer['name'] }} {{ $customer['surname'] }},</p>
            <p>Wir freuen uns, Ihnen mitteilen zu können, dass Ihre Fahrzeugbuchung erfolgreich war. Nachfolgend finden Sie die Details Ihrer Buchung:</p>
            <ul>
                @php
                $car = json_decode($contract->car, true);
                @endphp
                <li><strong>Contracts ID:</strong> {{ $contract->id }}</li>
                <li><strong>Cars:</strong> {{ $car['car']['brand'] }} {{ $car['car']['model'] }} ({{ $car['number_plate'] }})</li>
                <li><strong>Start Date:</strong> {{ $contract->start_date }}</li>
                <li><strong>End Date:</strong> {{ $contract->end_date }}</li>
                <li><strong>PickUp Date:</strong> {{ $contract->pickup_date }}</li>
                <li><strong>return:</strong> d</li>
                <li><strong>Pick Up Place:</strong> Herrhausenstraße 11, 27721 Ritterhude</li>
                <li><strong>Price:</strong> {{ $contract->total_amount }} €</li>
            </ul>
            <p>Bitte stellen Sie sicher, dass Sie alle notwendigen Dokumente bei der Abholung des Fahrzeugs mitbringen, einschließlich eines gültigen Führerscheins und eines Ausweisdokuments.</p>
            <p>Für weitere Informationen oder Änderungen an Ihrer Buchung, besuchen Sie bitte unser <a href="https://www.jet-cars.de">Online-Portal</a> oder kontaktieren Sie unseren Kundenservice unter <a href="mailto:info@jet-cars.com">info@jet-cars.com</a>.</p>
            <p>Wir freuen uns darauf, Ihnen einen hervorragenden Service bieten zu können!</p>
            <p>Mit freundlichen Grüßen,<br>Das Jetcars-Team</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 Jetcars. Alle Rechte vorbehalten.</p>
            <p>Sie erhalten diese E-Mail, weil Sie eine Buchung bei Jetcars getätigt haben.</p>
        </div>
    </div>
</body>
</html>