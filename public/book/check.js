<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>JetCars Reservation</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/css/intlTelInput.css'>
  <link rel='stylesheet' href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css'>
  <link rel="stylesheet" href="./style.css">
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
  <center><img src="logo.png" style="margin-top: 33px;" alt="Logo" /></center>
  <!-- Multi step form -->
  <section class="multi_step_form">

    <!-- Form -->
    <div class="form-container">
      <form id="msform">
        <!-- Title -->
        <div class="title">
          <h2>Fahrzeug reservieren</h2><br>
        </div>
        <!-- Progressbar -->
        <ul id="progressbar">
          <li class="active">Mietzeitraum</li>
          <li>Pakete</li>
          <li>Kontaktdaten</li>
        </ul>
        <!-- Step 1: Select Dates & Time -->
        <fieldset>
          <h3>Mietzeitraum auswählen</h3>
          <h6>Wählen Sie den Start- und Endzeitraum</h6>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="startDate">Mietstart</label>
              <input type="date" id="startDate" class="form-control">
              <input type="time" id="startTime" class="form-control mt-2" value="10:00">
            </div>
            <div class="form-group col-md-6">
              <label for="endDate">Mietende</label>
              <input type="date" id="endDate" class="form-control">
              <input type="time" id="endTime" class="form-control mt-2" value="10:00">
            </div>
          </div>
          <button type="button" class="next action-button">Weiter</button>
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
              <input type="text" id="name" class="form-control" placeholder="Vorname">
            </div>
            <div class="form-group col-md-6">
              <input type="text" id="surname" class="form-control" placeholder="Nachname">
            </div>
          </div>

          <div class="form-group">
            <input type="tel" class="form-control" placeholder="Telefon/Mobil">
          </div>
          <div class="form-group">
            <input type="email" class="form-control" placeholder="Email">
          </div>
          <button type="button" class="action-button previous previous_button">Zurück</button>
          <button type="button" class="action-button" style="padding-left:17px;padding-right:17px;">Verbindlich
            reservieren</button>
        </fieldset>
      </form>
    </div>


    <!-- Summary Section with Vehicle Image -->
    <div class="summary" style="background-color: white; border: none;">
      <div class="vehicle-gallery">
        <div class="vehicle-image" style="width: auto; float: unset;">
        </div>
      </div>


      <h4><span id="carName"></span> <span id="carPS"
          style="font-size: 10pt; background-color: rgb(20, 115, 227); padding: 2px; padding-left: 5px; padding-right: 5px; color: white; border: none; border-radius: 2px; top: -3px; position: relative;"></span>
      </h4>

      <p><strong id="carGroup"></strong></p>
      <div
        style="background-color: rgb(242, 242, 242); padding: 4%; /* width: 80%; */ margin: 0 auto; margin-bottom: 20px; border-left: 4px solid red;">
        <p><strong>Mietzeitraum:</strong></p>
        <p id="rentalPeriod">Bitte auswählen</p>
        <p id="rentaldays"></p>
        <p><strong>Kilometerpaket:</strong></p>
        <p id="kmPackage"></p>
        <p><strong>Versicherungspaket:</strong></p>
        <p id="insurancePackage"></p>
      </div>
      <p
        style="background: rgba(59, 184, 124, 1) !important; margin: 0px !important; color: white; padding: 14px; font-size: 15pt;">
        <strong><span id="totalPrice">0,00</span> EUR (inkl. MwSt.)</strong>
      </p>
    </div>
  </section>
  <!-- End Multi step form -->
  <script src='jquery.js'></script>
  <script src='bootstrap.js'></script>
  <script src='easing.js'></script>
  <script src='intlTelInput.js'></script>
  <script src='popper.js'></script>
  <script src='nice-select.js'></script>
  <script src="./script.js"></script>
  <script>
    $(document).ready(function () {
      // Update the summary section dynamically as the user makes selections

    });

  </script>


  <div id="imageModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImage">
    <div class="modal-navigation" style="margin: 0 auto; width: 100%; max-width: 126px;">
      <button id="prevBtn">&#10094;</button>
      <button id="nextBtn">&#10095;</button>
    </div>
  </div>

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
  </style>

  <script>
    $(document).ready(function () {

      $('#startDate').on('change', function () {
        setDefaultTime('#startTime');
        updateRentalPeriod();
      });

      $('#endDate').on('change', function () {
        setDefaultTime('#endTime');
        updateRentalPeriod();
      });

      $('#startTime').on('change', updateRentalPeriod);
      $('#endTime').on('change', updateRentalPeriod);



      //150 Km/Tag (inklusive)
      //2000 EUR SB (inklusive)

      function setDefaultTime(timeSelector) {
        var $timeInput = $(timeSelector);
        if (!$timeInput.val()) {
          $timeInput.val('10:00');
        }
      }

      function updateRentalPeriod() {
        const startDate = $('#startDate').val();
        const startTime = $('#startTime').val();
        const endDate = $('#endDate').val();
        const endTime = $('#endTime').val();

        $('#rentalPeriod').text(
          `${startDate || '-'} ${startTime || '-'}\n bis ${endDate || '-'} ${endTime || '-'}`
        );
      }

      $('#startDate, #endDate, #startTime, #endTime, #kmPackageSelect, #insurancePackageSelect').on('change', calculatePrices);

      const urlParams = new URLSearchParams(window.location.search);
      const carId = urlParams.get('car_id');

      const carApiUrl = "https://safari-rentsoft.com/api/cars-by-company";
      const carGroupApiUrl = "https://safari-rentsoft.com/api/car/groups";




      let dailyPrice, weeklyPrice, weekdayPrice, weekendPrice, monthlyPrice, deposito;


      $.when(
        $.getJSON(carApiUrl),
        $.getJSON(carGroupApiUrl)
      ).then(function (carResponse, carGroupResponse) {
        const carData = carResponse[0]["1"]["cars"];
        const carGroups = carGroupResponse[0]["1"]["car_groups"];

        const selectedCar = carData.find(car => car.id == carId);
        const carDetails = JSON.parse(selectedCar.car);
        const carGroup = carGroups.find(group => group.id === selectedCar.group_id);

        //console.log(selectedCar);

        const images = JSON.parse(selectedCar.images);

        // Update the car details in the summary section
        $('#carName').text(`${carDetails.brand} ${carDetails.model}`);
        $('#carPS').text(selectedCar.horse_power + " PS" || '');

        $('#carKilometers').text(`Freikilometer: ${JSON.parse(carGroup.kilometers).daily_kilometer} Km/Tag`);
        $('#carGroup').text(carGroup.name);
        // Extract prices from carGroup
        prices = JSON.parse(carGroup.prices);
        kilometers = JSON.parse(carGroup.kilometers);

        console.log(prices);
        dailyPrice = parseInt(prices.daily_price);
        weeklyPrice = parseInt(prices.weekly_price);
        weekdayPrice = parseInt(prices.weekday_price);
        weekendPrice = parseInt(prices.weekend_price);
        monthlyPrice = parseInt(prices.monthly_price);
        deposito = parseInt(prices.deposito);

        updateVehicleGallery(images);
        updateVehicleDetails(carGroup, prices, kilometers);
        calculatePrices(dailyPrice, weeklyPrice, weekdayPrice, weekendPrice, monthlyPrice, deposito);
      });


      function updateVehicleDetails(carGroup, prices, kilometers) {

        kmPackages = typeof carGroup.km_packages === 'string' ? JSON.parse(carGroup.km_packages) : carGroup.km_packages;
        insurancePackages = typeof carGroup.insurance_packages === 'string' ? JSON.parse(carGroup.insurance_packages) : carGroup.insurance_packages;

        // Update Kilometer Packages
        let kmPackageOptions = `<select id="kmPackageSelect" class="product_select">`;
        $('#kmPackage').text(`${kilometers.daily_kilometer} Km/Tag (inklusive)`);
        kmPackageOptions += `<option value="${kilometers.daily_kilometer}" id="defaultKM" pr="0">${kilometers.daily_kilometer} Km/Tag (inklusive)</option>`;

        kmPackages.forEach(package => {
          kmPackageOptions += `<option value="${package.kilometers}" pr="${package.extra_price * package.kilometers}">Zusätzlich ${package.kilometers} Km (+${package.extra_price * package.kilometers} EUR)</option>`;
        });
        kmPackageOptions += `</select>`;

        // Dynamically insert Kilometer Packages select element
        $('#kmPackageContainer').html(kmPackageOptions);
        console.log(kmPackageOptions);

        // Update Insurance Packages
        let insurancePackageOptions = `<select id="insurancePackageSelect" class="product_select">`;
        insurancePackageOptions += `<option value="${prices.standard_exemption}" pr="0">${prices.standard_exemption} EUR SB (inklusive)</option>`;

        $('#insurancePackage').text(`${prices.standard_exemption} EUR SB (inklusive)`);
        insurancePackages.forEach(package => {
          insurancePackageOptions += `<option value="${package.deductible}" pr="${package.price_per_day}">${package.deductible} EUR SB (+${package.price_per_day} EUR/Tag)</option>`;
        });

        insurancePackageOptions += `</select>`;

        // Append the options to the DOM (wherever you want the select element to appear)
        $('#insurancePackageContainer').html(insurancePackageOptions);  // Assuming there's a container with this ID


        // Dynamically insert Insurance Packages select element
        $('#insurancePackageContainer').html(insurancePackageOptions);

        // Reapply any custom select styling (like Nice Select)
        $('.product_select').niceSelect();
      }



      function updateVehicleGallery(images) {
        // Clear the current gallery
        $('.vehicle-gallery').empty();

        images.forEach((image, index) => {
          let displayStyle = index === 0 ? 'unset' : 'none'; // Show only the first image by default
          let imageElement = `<div class="vehicle-image" style="width: auto; float: unset; display: ${displayStyle};">
                          <img src="https://safari-rentsoft.com/${image}" alt="Vehicle Image ${index + 1}" class="gallery-item">
                        </div>`;
          $('.vehicle-gallery').append(imageElement);
        });

        // Add click event to gallery items for modal view
        $('.gallery-item').click(function () {
          var modal = $('#imageModal');
          var modalImg = $('#modalImage');
          modal.show();
          modalImg.attr('src', $(this).attr('src'));
        });

        // Close modal on close button click
        $('.close').click(function () {
          $('#imageModal').hide();
        });
      }


      function calculatePrices() {

        const startDateTime = $('#startDate').val() + "T" + $('#startTime').val();
        const endDateTime = $('#endDate').val() + "T" + $('#endTime').val();

        if ($('#startDate').val() && $('#endDate').val()) {
          var startDate = new Date(startDateTime);
          var endDate = new Date(endDateTime);
          var timeDiff = endDate.getTime() - startDate.getTime();

          var days = Math.ceil(timeDiff / (1000 * 3600 * 24));
          if (days === 0) {
            days = 1;
          }

          //var monthlyPrice = 1200;
          //var deposito = 2500;

          // Netto-Preise (exkl. MwSt.)
          var dailyPriceNet = dailyPrice / (1.19);
          var weeklyPriceNet = weeklyPrice / (1.19);
          var weekdayPriceNet = weekdayPrice / (1.19);
          var weekendPriceNet = weekendPrice / (1.19);
          var monthlyPriceNet = monthlyPrice / (1.19);
          var depositoNet = deposito;

          var subTotalPrice = 0;
          var TotalPrice = 0;

          var startDay = startDate.getDay();
          var endDay = endDate.getDay();

          if (days === 4 && startDay === 1 && endDay === 5) {
            subTotalPrice = weekdayPrice;
            dailyPrice = weekdayPrice / 4;
            defaultFreeKm = kilometers.weekday_kilometer / 4;
            console.log("weekdayPrice");
          } else if (days === 1 && startDay === 5 && endDay === 1) {
            subTotalPrice = weekendPrice;
            dailyPrice = weekendPrice / 3;
            defaultFreeKm = kilometers.weekend_kilometer / 3;
            console.log("weekendPrice");
          } else if (days >= 30) {
            subTotalPrice = monthlyPrice;
            var extraDays = days - 30;
            dailyPrice = monthlyPrice / 30;
            if (extraDays > 0) {
              subTotalPrice = subTotalPrice + (extraDays * dailyPrice);
            }
            defaultFreeKm = kilometers.monthly_kilometer / 30;
            console.log("monthlyPrice");
          } else if (days >= 7) {
            subTotalPrice = weeklyPrice;
            var extraDays = days - 7;
            dailyPrice = weeklyPrice / 7;
            if (extraDays > 0) {
              subTotalPrice = subTotalPrice + (extraDays * dailyPrice);
              console.log("xxx " + weeklyPrice);
            }
            defaultFreeKm = kilometers.weekly_kilometer / 7;
            console.log("weeklyPrice " + weeklyPrice);
            console.log("subTotalPrice " + subTotalPrice);
            console.log("extraDays " + extraDays);
          } else {
            subTotalPrice = days * dailyPrice;
            defaultFreeKm = kilometers.daily_kilometer;
            console.log("dailyPrice");
          }

          subTotalPrice = parseInt(subTotalPrice);




          // Update Kilometer Packages
          let kmPackageOptions = `<select id="kmPackageSelect" class="product_select">`;
          kmPackageOptions += `<option value="${defaultFreeKm}" id="defaultKM" pr="0">${defaultFreeKm} Km/Tag (inklusive)</option>`;

          kmPackages.forEach(package => {
            kmPackageOptions += `<option value="${package.kilometers}" pr="${package.extra_price * package.kilometers}">Zusätzlich ${package.kilometers} Km (+${package.extra_price * package.kilometers} EUR)</option>`;
          });
          kmPackageOptions += `</select>`;

          $('#kmPackageContainer').html(kmPackageOptions);



          let insurancePackageOptions = `<select id="insurancePackageSelect" class="product_select">`;
          $('#insurancePackage').text(`${prices.standard_exemption} EUR SB (inklusive)` || '');
          insurancePackageOptions += `<option value="${prices.standard_exemption}" pr="0">${prices.standard_exemption} EUR SB (inklusive)</option>`;

          //$('#insurancePackage').text(`${prices.standard_exemption} EUR SB (inklusive)`);
          insurancePackages.forEach(package => {
            insurancePackageOptions += `<option value="${package.deductible}" pr="${package.price_per_day}">${package.deductible} EUR SB (+${package.price_per_day} EUR/Tag)</option>`;
          });

          insurancePackageOptions += `</select>`;

          $('#insurancePackageContainer').html(insurancePackageOptions);
          $('.product_select').niceSelect();

          // Preis des Kilometerpakets aus dem Dropdown hinzufügen
          var kmPackagePrice = parseFloat($('#kmPackageSelect option:selected').attr('pr')) || 0;
          var insurancePackagePrice = parseFloat($('#insurancePackageSelect option:selected').attr('pr')) || 0;
          insurancePackagePrice = insurancePackagePrice * days;

          TotalPrice = subTotalPrice + kmPackagePrice + insurancePackagePrice;

          var mwst = subTotalPrice - (subTotalPrice / 1.19);
          var totalPriceNet = subTotalPrice - mwst;


          $('#rentaldays').text(`${days} Tag(e)`);
          $('#totalPrice').text(TotalPrice.toFixed(2).replace('.', ',') + ' €');
          console.log("pro tag: " + dailyPrice);
          console.log("total (brutto): " + TotalPrice);
          console.log("total (net): " + totalPriceNet);
          console.log("MwSt: " + mwst);
          console.log("days: " + days);
          console.log("kmPackagePrice: " + kmPackagePrice);
          console.log("insurancePackagePrice: " + insurancePackagePrice);
        }
      }


      function calculatePrices2() {

        const startDateTime = $('#startDate').val() + "T" + $('#startTime').val();
        const endDateTime = $('#endDate').val() + "T" + $('#endTime').val();

        if ($('#startDate').val() && $('#endDate').val()) {
          var startDate = new Date(startDateTime);
          var endDate = new Date(endDateTime);
          var timeDiff = endDate.getTime() - startDate.getTime();

          var days = Math.ceil(timeDiff / (1000 * 3600 * 24));
          if (days === 0) {
            days = 1;
          }

          //var monthlyPrice = 1200;
          //var deposito = 2500;

          // Netto-Preise (exkl. MwSt.)
          var dailyPriceNet = dailyPrice / (1.19);
          var weeklyPriceNet = weeklyPrice / (1.19);
          var weekdayPriceNet = weekdayPrice / (1.19);
          var weekendPriceNet = weekendPrice / (1.19);
          var monthlyPriceNet = monthlyPrice / (1.19);
          var depositoNet = deposito;

          var subTotalPrice = 0;
          var TotalPrice = 0;

          var startDay = startDate.getDay();
          var endDay = endDate.getDay();

          if (days === 4 && startDay === 1 && endDay === 5) {
            subTotalPrice = weekdayPrice;
            dailyPrice = weekdayPrice / 4;
            defaultFreeKm = kilometers.weekday_kilometer / 4;
            console.log("weekdayPrice");
          } else if (days === 1 && startDay === 5 && endDay === 1) {
            subTotalPrice = weekendPrice;
            dailyPrice = weekendPrice / 3;
            defaultFreeKm = kilometers.weekend_kilometer / 3;
            console.log("weekendPrice");
          } else if (days >= 30) {
            subTotalPrice = monthlyPrice;
            var extraDays = days - 30;
            dailyPrice = monthlyPrice / 30;
            if (extraDays > 0) {
              subTotalPrice = subTotalPrice + (extraDays * dailyPrice);
            }
            defaultFreeKm = kilometers.monthly_kilometer / 30;
            console.log("monthlyPrice");
          } else if (days >= 7) {
            subTotalPrice = weeklyPrice;
            var extraDays = days - 7;
            dailyPrice = weeklyPrice / 7;
            if (extraDays > 0) {
              subTotalPrice = subTotalPrice + (extraDays * dailyPrice);
              console.log("xxx " + weeklyPrice);
            }
            defaultFreeKm = kilometers.weekly_kilometer / 7;
            console.log("weeklyPrice " + weeklyPrice);
            console.log("subTotalPrice " + subTotalPrice);
            console.log("extraDays " + extraDays);
          } else {
            subTotalPrice = days * dailyPrice;
            defaultFreeKm = kilometers.daily_kilometer;
            console.log("dailyPrice");
          }

          subTotalPrice = parseInt(subTotalPrice);





          // Preis des Kilometerpakets aus dem Dropdown hinzufügen
          var kmPackagePrice = parseFloat($('#kmPackageSelect option:selected').attr('pr')) || 0;
          var insurancePackagePrice = parseFloat($('#insurancePackageSelect option:selected').attr('pr')) || 0;
          insurancePackagePrice = insurancePackagePrice * days;

          TotalPrice = subTotalPrice + kmPackagePrice + insurancePackagePrice;

          var mwst = subTotalPrice - (subTotalPrice / 1.19);
          var totalPriceNet = subTotalPrice - mwst;


          $('#rentaldays').text(`${days} Tag(e)`);
          $('#totalPrice').text(TotalPrice.toFixed(2).replace('.', ',') + ' €');
          console.log("pro tag: " + dailyPrice);
          console.log("total (brutto): " + TotalPrice);
          console.log("total (net): " + totalPriceNet);
          console.log("MwSt: " + mwst);
          console.log("days: " + days);
          console.log("kmPackagePrice: " + kmPackagePrice);
          console.log("insurancePackagePrice: " + insurancePackagePrice);
        }
      }








      $(document).on('change', '#kmPackageSelect', function () {
        const selectedText = $(this).find('option:selected').text();
        $('#kmPackage').text(selectedText || '');
        calculatePrices2();
      });

      $(document).on('change', '#insurancePackageSelect', function () {
        const selectedText = $(this).find('option:selected').text();
        $('#insurancePackage').text(selectedText || '');
        calculatePrices2();
      });


      var modal = $('#imageModal');
      var modalImg = $('#modalImage');
      var currentImageIndex;

      // Open modal on image click
      $('.gallery-item').click(function () {
        modal.show();
        modalImg.attr('src', $(this).attr('src'));
        currentImageIndex = $(this).index();
      });

      // Close modal on close button click
      $('.close').click(function () {
        modal.hide();
      });

      // Next image
      $('#nextBtn').click(function () {
        currentImageIndex = (currentImageIndex + 1) % $('.gallery-item').length;
        modalImg.attr('src', $('.gallery-item').eq(currentImageIndex).attr('src'));
      });

      // Previous image
      $('#prevBtn').click(function () {
        currentImageIndex = (currentImageIndex - 1 + $('.gallery-item').length) % $('.gallery-item').length;
        modalImg.attr('src', $('.gallery-item').eq(currentImageIndex).attr('src'));
      });

      // Close modal when clicking outside of the image
      $(window).click(function (event) {
        if ($(event.target).is(modal)) {
          modal.hide();
        }
      });


      //height
      function adjustFormHeight() {
        var formHeight = $('.multi_step_form').height();
        $('#msform').height(formHeight - 20);
      }

      // Adjust the height on document ready
      adjustFormHeight();

      // Optionally, adjust the height on window resize
      $(window).resize(function () {
        adjustFormHeight();
      });

    });
  </script>


</body>

</html>