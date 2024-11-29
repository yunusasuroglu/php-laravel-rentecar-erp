<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/css/intlTelInput.css'>
    <link rel='stylesheet' href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css'>
    <title>Contract Success</title>
</head>
<body>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>    
    <div class="container">
        <div class="row text-center">
            <div class="col-sm-12">
                <br><br> <h2 class="text-center" style="color:#0fad00">Success</h2>
                <img src="https://img.icons8.com/?size=100&id=AefXIkx4A693&format=png&color=000000">
                <h3 class="text-center">Super ! Contract Created.</h3>
                <p class="text-center" style="font-size:20px;color:#5C5C5C;"> {{ $message }}</p>
                <br><br>
            </div>
        </div>
    </div>
    <script src='{{asset('/')}}book/jquery.js'></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src='{{asset('/')}}book/bootstrap.js'></script>
    <script src='{{asset('/')}}book/easing.js'></script>
    <script src='{{asset('/')}}book/intlTelInput.js'></script>
    <script src='{{asset('/')}}book/popper.js'></script>
    <script src='{{asset('/')}}book/nice-select.js'></script>
</body>
</html>

