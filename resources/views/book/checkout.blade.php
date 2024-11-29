<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>JetCars Checkout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/css/intlTelInput.css'>
    <link rel='stylesheet' href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css'>
    <link rel="stylesheet" href="{{asset('/')}}book/style-checkout.css">
    <style>
        .multi_step_form {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            /* Allow wrapping for responsiveness */
            margin-top: 50px;
            margin: 15%;
            margin-top: 50px;
            box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
        }
        .fc-license-message{
            display: none !important;
        }
        .summary {
            flex: 1 1 100%;
            max-width: 100%;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            text-align: center;
            padding: 20px;
        }
        .thumbnail {
            display: inline-block;
            margin: 5px;
            cursor: pointer;
        }
        
        .thumbnail img {
            width: 100px; /* Küçük resimlerin genişliği */
            height: auto; /* Yüksekliği otomatik ayarla */
            border-radius: 5px;
        }
        .summary h4 {
            margin-bottom: 20px;
        }
        
        .summary p {
            margin: 5px 0;
        }
        
        .vehicle-image img {
            width: 100%;
            max-width: 350px;
            max-height: auto;
            margin-bottom: 20px;
            border-radius: 10px;
        }
        
        .form-container {
            flex: 1 1 100%;
            max-width: 100%;
        }
        
        @media (min-width: 768px) {
            .summary {
                flex: 1;
                max-width: 38%;
                margin-right: 20px;
                margin-left: 0;
            }
            
            .form-container {
                flex: 1;
                max-width: 60%;
            }
        }
        .gallery-item {
            cursor: pointer;
            max-width: 100%;
            margin-bottom: 20px;
            border-radius: 10px;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            padding-top: 60px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
        }
        
        .modal-content {
            display: block;
            width: auto;
            max-height: 88%;
            margin: 0 auto;
        }
        
        .modal-navigation {
            text-align: center;
            margin-top: 15px;
        }
        
        .modal-navigation button {
            background-color: transparent;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            margin: 0 15px;
        }
        
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }
        
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }
        .payment-options {
            display: flex;
            flex-direction: column;
        }
        
        .radio-label {
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #d9d9d9;
            border-radius: 4px;
            cursor: pointer;
            width: fit-content;
            width: 100%;
            background-color: rgb(240, 240, 240);
        }
        
        .radio-label input[type="radio"] {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <center>
        <a href="{{route('book')}}"><img src="{{asset('/')}}book/logo.png" style="margin-top: 33px;" alt="Logo" /></a>
    </center>
    <section class="multi_step_form">
        <!-- Form -->
        <div class="form-container">
            <div id="msform">
                <!-- Title -->
                <div class="title">
                    <h2>Checkout</h2><br>
                </div>
                <!-- Progressbar -->
                <ul id="progressbar">
                    <li class="active">Mietzeitraum</li>
                    <li class="active">Pakete</li>
                    <li class="active">Kontaktdaten</li>
                    <li>Checkout</li>
                </ul>
                <!-- Step 1: Select Dates & Time -->
                <fieldset>
                    <form id="payment-form">
                        <div id="payment-element">
                        </div>
                        <div id="payment-errors" role="alert"></div>
                        <button class="mb-3 mt-3 btn btn-success w-100" id="submit">Pay</button>
                    </form>
                </fieldset>
            </div>
        </div>
        
        <!-- Summary Section with Vehicle Image -->
        <div class="summary" style="background-color: white; border: none;">
            <div class="vehicle-gallery">
                @foreach($carData['images'] as $index => $image)
                    <div class="vehicle-image" style="width: auto; float: unset; display: {{ $index === 0 ? 'block' : 'none' }};">
                        <img src="{{ asset($image) }}" alt="Vehicle Image {{ $index + 1 }}" class="gallery-item" style="cursor: pointer;">
                    </div>
                @endforeach
            </div>
            
            <!-- Küçük resimler için alan -->
            <div class="thumbnail-gallery" style="margin-top: 10px;">
                @foreach($carData['images'] as $index => $image)
                    <div class="thumbnail" style="display: inline-block; margin: 5px; cursor: pointer;">
                        <img src="{{ asset($image) }}" alt="Thumbnail {{ $index + 1 }}" class="thumbnail-item" style="width: 100px; height: auto;">
                    </div>
                @endforeach
            </div>
                
                
                
                <h4>
                    <span id="carName">{{$carName}}</span>
                    <span id="carPS" style="font-size: 10pt; background-color: rgb(20, 115, 227); padding: 2px; padding-left: 5px; padding-right: 5px; color: white; border: none; border-radius: 2px; top: -3px; position: relative;">{{$carData['horse_power']}} PS</span>
                </h4>
                <p id="carPlate">{{$carData['number_plate']}}</p>
                <small id="carDescription">{{$carData['description']}}</small>
                <p><strong id="carGroup"></strong></p>
                <div style="background-color: rgb(242, 242, 242); padding: 4%; /* width: 80%; */ margin: 0 auto; margin-bottom: 20px;">
                    <p><strong>Mietzeitraum:</strong></p>
                    <p id="availabilityStatus" style="color: green;">Frei</p>
                    <p id="rentalPeriod">{{$contractData['start_date']}} bis {{$contractData['end_date']}}</p>
                    <p id="rentaldays">{{$days}} Tag(e)</p>
                    <p id="depositoP">{{$carData['prices']['daily_price']}} € Kaution</p>
                    <p><strong>Kilometerpaket:</strong></p>
                    <p id="kmPackage">Zusätzlich {{$kmPackage['kilometers'] ?? '0'}} Km (+{{$kmPackage['extra_price'] ?? '0'}} €)</p>
                    <p><strong>Versicherungspaket:</strong></p>
                    <p id="insurancePackage">{{$insurancePackage['deductible'] ?? '0'}} € SB (+{{$insurancePackage['price_per_day'] ?? '0'}} €/Tag)</p>
                </div>
                <p style="background: rgba(230, 230, 230, 1) !important; margin: 0px !important; color: rgb(59, 59, 59); padding: 14px; font-size: 15pt; border: 1px solid rgba(199, 199, 199, 1); border-radius: 1px;">
                    <strong><span id="totalPrice">{{$contractData['total_amount']}} </span> € (inkl. MwSt.)</strong>
                </p>
            </div>
        </div>
    </section>
    <div class="container">
        
        <div style="padding: 15%;">
            
        </div>
    </div>
    <script src='{{asset('/')}}book/jquery.js'></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src='{{asset('/')}}book/bootstrap.js'></script>
    <script src='{{asset('/')}}book/easing.js'></script>
    <script src='{{asset('/')}}book/intlTelInput.js'></script>
    <script src='{{asset('/')}}book/popper.js'></script>
    <script src='{{asset('/')}}book/nice-select.js'></script>
    <script src="{{asset('/')}}book/script.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const stripe = Stripe('{{env("STRIPE_KEY")}}', {
                apiVersion: '2020-08-27',
            });
            
            const elements = stripe.elements({
                clientSecret: '{{$paymentIntent->client_secret;}}'
            });
            const paymentElement = elements.create('payment');
            paymentElement.mount('#payment-element');
            
            const paymentForm = document.querySelector('#payment-form');
            paymentForm.addEventListener('submit', async (e) => {
                // Avoid a full page POST request.
                e.preventDefault();
                
                // Disable the form from submitting twice.
                paymentForm.querySelector('button').disabled = true;
                
                // Confirm the card payment that was created server side:
                const {error} = await stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        return_url: `${window.location.origin}/book/success`
                    }
                });
                if(error) {
                    addMessage(error.message);
                    // Re-enable the form so the customer can resubmit.
                    paymentForm.querySelector('button').disabled = false;
                    return;
                }
            });
        });
    </script>
</body>

</html>

