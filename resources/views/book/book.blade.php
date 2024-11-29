<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>JetCars Reservation</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/css/intlTelInput.css'>
  <link rel='stylesheet' href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css'>
  <link rel="stylesheet" href="{{asset('/')}}assets/libs/fullcalendar/main.min.css">
  <link rel="stylesheet" href="{{asset('/')}}book/style.css">
  <style>
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
  </style>
</head>
<body>
  <center><a href="{{route('book')}}"><img src="{{asset('/')}}book/logo.png" style="margin-top: 33px;" alt="Logo" /></a></center>
  <!-- Multi step form -->
  <section class="multi_step_form">
    <!-- Form -->
    <div class="form-container">
      <form id="msform" enctype="multipart/form-data" method="POST">
        <!-- Title -->
        <div class="title">
          <h2>Fahrzeug reservieren</h2><br>
        </div>
        <!-- Progressbar -->
        <ul id="progressbar">
          <li class="active">Mietzeitraum</li>
          <li>Pakete</li>
          <li>Kontaktdaten</li>
          <li>Checkout</li>
        </ul>
        <!-- Step 1: Select Dates & Time -->
        <fieldset>
          <h3>Mietzeitraum auswählen</h3>
          <h6>Wählen Sie den Start- und Endzeitraum</h6>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="startDate">Mietstart</label>
              <input name="start_date" type="date" id="startDate" class="form-control">
              <input name="start_time" type="time" id="startTime" class="form-control mt-2" value="10:00">
            </div>
            <div class="form-group col-md-6">
              <label for="endDate">Mietende</label>
              <input name="end_date" type="date" id="endDate" class="form-control">
              <input name="end_time" type="time" id="endTime" class="form-control mt-2" value="10:00">
            </div>
          </div>
          <br><br>
          <div class="number_plate">
            <label style="text-align: left;" for="numberPlateSelect">Cars:</label>
            <select id="numberPlateSelect" class="form-control"></select>
          </div>
          <br><br>
          <div id="calendar" class="mb-3"></div>
          {{-- <div id="availabilityButton"> --}}
            <button style="margin-bottom: 8px;" id="stepButton" type="button" class="next action-button">Weiter</button>
            {{-- </div> --}}
          </fieldset>
          <!-- Step 2: Choose Packages -->
          <fieldset>
            <h3>Pakete dazubuchen</h3>
            <h6>Wählen Sie zusätzliche Kilometer- und Versicherungspakete</h6>
            <div class="form-group" style="margin-bottom: 66px;">
              <div id="kmPackageContainer"></div>
              
            </div>
            <div class="form-group" style="margin-bottom: 133px;">
              
              <div id="insurancePackageContainer"></div>
              
            </div>
            <br>
            <button type="button" class="action-button previous previous_button">Zurück</button>
            <button type="button" class="next action-button">Weiter</button>
          </fieldset>
          <!-- Step 3: Enter Contact Details -->
          <fieldset>
            <h3>Kontaktdaten</h3>
            <h6>Bitte geben Sie Ihre Kontaktdaten an um die Reservierung abzuschließen.</h6>
            
            
            <div class="form-row">
              <div class="form-group col-md-6">
                <input name="name" type="text" id="name" class="form-control" placeholder="Vorname">
              </div>
              <div class="form-group col-md-6">
                <input name="surname" type="text" id="surname" class="form-control" placeholder="Nachname">
              </div>
            </div>
            
            <div class="form-group">
              <input name="phone" id="phone" type="tel" class="form-control" placeholder="Telefon/Mobil" autocomplete="off">
            </div>
            <div class="form-group">
              <input name="email" id="email" type="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
              <p style="text-align:left !important;" for="">Age:</p>
              <input name="age" id="age" type="date" class="form-control" placeholder="age">
            </div>
            <div class="form-group">
              <p style="text-align:left !important;" for="">Country:</p>
              <select name="country" id="country" class="form-control" placeholder="Country">
                <option value="Deutschland" selected>Deutschland</option>
              </select>
            </div>
            <div class="form-group">
              <p style="text-align:left !important;" for="">City:</p>
              <input name="city" id="city" type="text" class="form-control" placeholder="City">
            </div>
            <div class="form-group">
              <p style="text-align:left !important;" for="">Street:</p>
              <input name="street" id="street" type="text" class="form-control" placeholder="Street">
            </div>
            <div class="form-group">
              <p style="text-align:left !important;" for="">Zip Code:</p>
              <input name="zip_code" id="zip_code" type="text" class="form-control" placeholder="Zip Code">
            </div>
            <div class="form-group">
              <p style="text-align:left !important;" for="">Id Card:</p>
              <input id="identity_front" type="file" class="form-control mb-2">
              <input id="identity_back" type="file" class="form-control mb-2">
              <input id="identity_expiry_date" type="date" class="form-control">
            </div>
            <div class="form-group">
              <p style="text-align:left !important;" for="">Driving Card:</p>
              <input id="driving_front" type="file" class="form-control mb-2">
              <input id="driving_back" type="file" class="form-control mb-2">
              <input id="driving_expiry_date" type="date" class="form-control">
            </div>
            <hr>
            
            <div class="form-group payment-options">
              <label class="radio-label">
                <input type="radio" name="paymentMethod" value="vorort" checked>
                Vorort bezahlen
              </label>
              <label class="radio-label">
                <input type="radio" name="paymentMethod" value="online">
                Jetzt online zahlen <span style="margin-left: 10px; font-size: 9pt; background-color: rgba(219, 160, 10, 0.88); color: white; padding-left: 5px; padding-right: 5px; border-radius: 3px;">in Kürze verfügbar</span>
              </label>              
            </div>
            <br><br>
            
            <button type="button" class="action-button previous previous_button">Zurück</button>
            <button id="submitButton" type="button" class="action-button" style="padding-left:17px;padding-right:17px;">Verbindlich reservieren</button>
          </fieldset>
        </form>
      </div>
      
      
      <!-- Summary Section with Vehicle Image -->
      <div class="summary" style="background-color: white; border: none;">
        <div class="vehicle-gallery">
          <div class="vehicle-image" style="width: auto; float: unset;">
            <!-- Ana resimler buraya eklenecek -->
          </div>
        </div>
        <!-- Küçük resimler için alan -->
        <div class="thumbnail-gallery" style="margin-top: 10px;">
          <!-- Küçük resimler buraya eklenecek -->
        </div>
        
        
        
        <h4>
          <span id="carName"></span>
          <span id="carPS" style="font-size: 10pt; background-color: rgb(20, 115, 227); padding: 2px; padding-left: 5px; padding-right: 5px; color: white; border: none; border-radius: 2px; top: -3px; position: relative;"></span>
        </h4>
        <p id="carPlate"></p>
        <small id="carDescription"></small>
        <p><strong id="carGroup"></strong></p>
        <div
        style="background-color: rgb(242, 242, 242); padding: 4%; /* width: 80%; */ margin: 0 auto; margin-bottom: 20px;">
        <p><strong>Mietzeitraum:</strong></p>
        <p id="availabilityStatus"></p>
        <p id="rentalPeriod">- - -</p>
        <p id="rentaldays"></p>
        <p id="depositoP"></p>
        <p><strong>Kilometerpaket:</strong></p>
        <p id="kmPackage"></p>
        <p><strong>Versicherungspaket:</strong></p>
        <p id="insurancePackage"></p>
        <input type="hidden" id="totalPriceHidden">
      </div>
      <p style="background: rgba(230, 230, 230, 1) !important; margin: 0px !important; color: rgb(59, 59, 59); padding: 14px; font-size: 15pt; border: 1px solid rgba(199, 199, 199, 1); border-radius: 1px;">
        <strong><span id="totalPrice">0,00</span> € (inkl. MwSt.)</strong>
      </p>
    </div>
  </section>
  <!-- End Multi step form -->
  <script src='{{asset('/')}}book/jquery.js'></script>
  <!-- Fullcalendar JS -->
  <script src="{{asset('/')}}assets/libs/fullcalendar/main.min.js"></script>
  <script src="{{asset('/')}}assets/js/calendar.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src='{{asset('/')}}book/bootstrap.js'></script>
  <script src='{{asset('/')}}book/easing.js'></script>
  <script src='{{asset('/')}}book/intlTelInput.js'></script>
  <script src='{{asset('/')}}book/popper.js'></script>
  <script src='{{asset('/')}}book/nice-select.js'></script>
  <script src="{{asset('/')}}book/script.js"></script>
  <script src="{{asset('/')}}book/contract-add.js"></script>
  <select id="numberPlateSelect" class="form-control"></select>
  
  <div id="imageModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImage">
    <div class="modal-navigation" style="margin: 0 auto; width: 100%; max-width: 126px;">
      <button id="prevBtn">&#10094;</button>
      <button id="nextBtn">&#10095;</button>
    </div>
  </div>
  <script src="{{asset('/')}}book/book.js"></script>
  
  
</body>

</html>