    
    $(document).ready(function () {
        $('#startDate').on('change', function () {
            setDefaultTime('#startTime');
            updateRentalPeriod();
            calculatePrices();
        });
        
        $('#endDate').on('change', function () {
            setDefaultTime('#endTime');
            updateRentalPeriod();
            calculatePrices();
        });
        
        $('#startTime').on('change', updateRentalPeriod);
        $('#endTime').on('change', updateRentalPeriod);
        
        const selectedCarId = $('#numberPlateSelect').val(); // Seçili olan aracı al
        if (selectedCarId) {
            updateRentalPeriod();
            calculatePrices();
        }
        
        function setDefaultTime(timeSelector) {
            var $timeInput = $(timeSelector);
            if (!$timeInput.val()) {
                $timeInput.val('10:00');
            }
        }
        
        let contracts = []; // Başlangıçta boş bir dizi tanımlayın
        let calendar; // Takvim nesnesi için global değişken
        let unavailableDates = []; // Kullanıcı tarafından belirlenen tarihler için boş dizi
        
        function initCalendar() {
            var calendarEl = document.getElementById('calendar');
            // Takvimi yalnızca bir kez başlat
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [], // Başlangıçta boş
                height: 'auto'
            });
            calendar.render(); // Takvimi render et
            calendarEl.style.display = 'none'; // Başlangıçta takvimi gizle
        }
        
        function updateRentalPeriod() {
            const startDate = $('#startDate').val();
            const startTime = $('#startTime').val();
            const endDate = $('#endDate').val();
            const endTime = $('#endTime').val();
            
            // UnavailableDates'ı temizle
            unavailableDates = []; // Her güncellemede diziyi sıfırla
            
            if (startDate && startTime && endDate && endTime) {
                const formattedStartDate = `${startDate} ${startTime}`;
                const formattedEndDate = `${endDate} ${endTime}`;
                
                $('#rentalPeriod').text(formatToGerman(`${startDate || '-'} ${startTime || '-'} bis ${endDate || '-'} ${endTime || '-'}`));
                
                // Takvimi göster
                $('#calendar').show(); // Takvimi göster
                
                // Araç müsaitlik kontrolü
                checkCarAvailability(carId, formattedStartDate, formattedEndDate);
            } else {
                $('#calendar').hide(); // Tarih seçilmezse takvimi gizle
            }
        }
        
        function checkCarAvailability(carId, startDate, endDate) {
            const apiUrl = `https://safari-rentsoft.com/book/cars-avability/${carId}`;
            
            fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                // Başlangıçta araç müsaitliğini varsayılan olarak true olarak ayarla
                let isCarAvailable = true; 
                contracts = data.contracts; // Yeni sözleşmeleri güncelle
                
                // Belirtilen tarihlerde herhangi bir sözleşme var mı kontrol et
                contracts.forEach(contract => {
                    const contractStart = new Date(contract.start_date);
                    const contractEnd = new Date(contract.end_date);
                    const requestedStart = new Date(startDate);
                    const requestedEnd = new Date(endDate);
                    
                    // Eğer istenilen tarih aralığı mevcut sözleşme ile çakışıyorsa
                    if (
                        (requestedStart < contractEnd && requestedEnd > contractStart) || // İstenilen tarih aralığı mevcut sözleşme ile çakışıyorsa
                        (requestedStart >= contractStart && requestedStart <= contractEnd) || // İstenilen başlangıç tarihi mevcut sözleşme içinde ise
                        (requestedEnd >= contractStart && requestedEnd <= contractEnd) // İstenilen bitiş tarihi mevcut sözleşme içinde ise
                    ) {
                        isCarAvailable = false; // Araç müsait değil
                    }
                });
                
                // Müsaitlik durumunu güncelle
                updateAvailabilityStatus(isCarAvailable);
                // Takvimi güncelle
                updateCalendarWithContracts();
            })
            .catch(error => {
                console.error("API isteğinde hata oluştu:", error);
            });
        }
        
        function updateAvailabilityStatus(isCarAvailable) {
            if (!isCarAvailable) {
                // Araba müsait değilse, metni 'Nicht verfügbar' yap ve kırmızı renkte göster
                $('#availabilityStatus').text('Nicht verfügbar').css('color', 'red');
                
                // Butonu devre dışı bırak ve gri renkte göster
                $('#stepButton').prop('disabled', true).css('background-color', 'gray').css('background','gray').css('border','1px solid gray');
            } else {
                // Araba müsaitse, metni 'Frei' yap ve yeşil renkte göster
                $('#availabilityStatus').text('Frei').css('color', 'green');
                
                // Butonu aktif yap ve orijinal rengini geri getir (örneğin, yeşil)
                $('#stepButton').prop('disabled', false).css('background-color', '#FF0000').css('background','#FF0000').css('border','1px solid #FF0000');
            }
        }
        
        // Sözleşmeleri güncelleyerek takvimi güncelleme fonksiyonu
        function updateCalendarWithContracts() {
            var events = []; // Yeni bir etkinlik dizisi oluştur
            
            // Eğer sözleşmeler mevcutsa, bunları takvime ekle
            contracts.forEach(function(contract) {
                // Tarihlerin geçerli olup olmadığını kontrol et
                if (new Date(contract.start_date) < new Date(contract.end_date)) {
                    events.push({
                        title: 'Occupied',
                        start: contract.start_date,
                        end: contract.end_date,
                        color: 'red'
                    });
                }
            });
            
            // Takvimi güncelle ve render et
            calendar.removeAllEvents(); // Eski etkinlikleri temizle
            
            // Yeni etkinlikleri takvime ekle
            if (events.length > 0) {
                calendar.addEventSource(events); // Yeni etkinlikleri ekle
            }
            
            calendar.render(); // Takvimi render et
        }
        
        // Takvimi başlat
        initCalendar();
        
        function twoDate(start, end, controlStart, controlEnd) {
            const startDate = new Date(start);
            const endDate = new Date(end);
            const controlStartDate = new Date(controlStart);
            const controlEndDate = new Date(controlEnd);
            
            return (
                (controlStartDate <= endDate && controlStartDate >= startDate) ||
                (controlEndDate <= endDate && controlEndDate >= startDate) ||
                (controlStartDate <= startDate && controlEndDate >= endDate)
            );
        }
        
        $('#startDate, #endDate, #startTime, #endTime, #kmPackageSelect, #insurancePackageSelect').on('change', calculatePrices);
        
        const urlParams = new URLSearchParams(window.location.search);
        const carId = window.location.pathname.split('/').pop();
        
        const carApiUrl = "https://safari-rentsoft.com/book/cars-by-company";
        const carGroupApiUrl = "https://safari-rentsoft.com/book/car/groups";
        
        let dailyPrice, weeklyPrice, weekdayPrice, weekendPrice, monthlyPrice, deposito;
        
        $.when(
            $.getJSON(carApiUrl),
            $.getJSON(carGroupApiUrl)
        ).then(function (carResponse, carGroupResponse) {
            const carData = carResponse[0]["1"]["cars"];
            const carGroups = carGroupResponse[0]["1"]["car_groups"];
            
            const selectedCar = carData.find(car => car.id == carId);
            const carGroup = carGroups.find(group => group.id === selectedCar.group_id);
            
            if (!selectedCar) {
                console.log('Seçilen araç bulunamadı.');
                return;
            }
            
            // Seçilen aracın marka ve modeline göre diğer araçları bul
            const selectedCarDetails = JSON.parse(selectedCar.car);
            const sameModelCars = carData.filter(car => {
                const carDetails = JSON.parse(car.car);
                return carDetails.model === selectedCarDetails.model && carDetails.brand === selectedCarDetails.brand;
            });
            
            // <label> ve <select> menüsünü oluştur ve doldur
            const numberPlateLabel = $('<label style="text-align: left;" for="numberPlateSelesct">Cars:</label>');
            const numberPlateSelect = $('<select id="numberPlateSelect" class="form-control"></select>');
            
            sameModelCars.forEach(function(car) {
                const option = $('<option></option>').val(car.id).text(`${JSON.parse(car.car).brand} ${JSON.parse(car.car).model} - ${car.color}`);
                numberPlateSelect.append(option);
            });
            
            $('.number_plate').html(numberPlateLabel).append(numberPlateSelect);
            
            // İlk plaka seçildiğinde veya plaka değiştirildiğinde işlemleri yap
            function updateCarDetails(selectedCarId) {
                const selectedCar = carData.find(car => car.id == selectedCarId);
                const selectedCarDetails = JSON.parse(selectedCar.car);
                
                const carGroup = carGroupResponse[0]["1"]["car_groups"].find(group => group.id === selectedCar.group_id);
                
                $('#carName').text(`${selectedCarDetails.brand} ${selectedCarDetails.model}`);
                $('#carDescription').text(`${selectedCar.description}`);
                $('#carPS').text(selectedCar.horse_power + " PS" || '');
                $('#carPlate').text(selectedCar.number_plate);
                $('#carKilometers').text(`Freikilometer: ${JSON.parse(carGroup.kilometers).daily_kilometer} Km/Tag`);
                
                const prices = JSON.parse(carGroup.prices);
                const kilometers = JSON.parse(carGroup.kilometers);
                $('#depositoP').text(parseInt(prices.deposito) + " € Kaution" || '');
                
                // Galeriyi ve detayları güncelle
                updateVehicleGallery(JSON.parse(selectedCar.images));
                updateVehicleDetails(carGroup, prices, kilometers);
                
                const startDate = $('#startDate').val();
                const startTime = $('#startTime').val();
                const endDate = $('#endDate').val();
                const endTime = $('#endTime').val();
                
                if (startDate && startTime && endDate && endTime) {
                    const formattedStartDate = `${startDate} ${startTime}`;
                    const formattedEndDate = `${endDate} ${endTime}`;
                    checkCarAvailability(selectedCarId, formattedStartDate, formattedEndDate);
                }
            }
            
            // İlk plaka seçili olarak göster ve detayları güncelle
            const initialCarId = numberPlateSelect.val();
            updateCarDetails(initialCarId);
            
            // Seçim değiştirildiğinde ilgili aracı güncelle
            numberPlateSelect.on('change', function () {
                const selectedCarId = $(this).val();
                updateCarDetails(selectedCarId);
                
                // Tarih aralığı seçildiyse kullanıcının seçimine göre takvim ve müsaitlik durumunu güncelle
                updateRentalPeriod();
                prices = JSON.parse(carGroup.prices);
                kilometers = JSON.parse(carGroup.kilometers);
                dailyPrice = parseInt(prices.daily_price);
                weeklyPrice = parseInt(prices.weekly_price);
                weekdayPrice = parseInt(prices.weekday_price);
                weekendPrice = parseInt(prices.weekend_price);
                monthlyPrice = parseInt(prices.monthly_price);
                
                calculatePrices(dailyPrice, weeklyPrice, weekdayPrice, weekendPrice, monthlyPrice, deposito, kilometers);
            });
            
            prices = JSON.parse(carGroup.prices);
            kilometers = JSON.parse(carGroup.kilometers);
            dailyPrice = parseInt(prices.daily_price);
            weeklyPrice = parseInt(prices.weekly_price);
            weekdayPrice = parseInt(prices.weekday_price);
            weekendPrice = parseInt(prices.weekend_price);
            monthlyPrice = parseInt(prices.monthly_price);
            
            calculatePrices(dailyPrice, weeklyPrice, weekdayPrice, weekendPrice, monthlyPrice, deposito, kilometers);
            
        });
        function updateVehicleDetails(carGroup, prices, kilometers) {
            
            kmPackages = typeof carGroup.km_packages === 'string' ? JSON.parse(carGroup.km_packages) : carGroup.km_packages;
            insurancePackages = typeof carGroup.insurance_packages === 'string' ? JSON.parse(carGroup.insurance_packages) : carGroup.insurance_packages;
            
            // Update Kilometer Packages
            let kmPackageOptions = `<select id="kmPackageSelect" class="product_select form-select">`;
            $('#kmPackage').text(`${kilometers.daily_kilometer} Km/Tag (inklusive)`);
            kmPackageOptions += `<option value="${kilometers.daily_kilometer}" id="defaultKM" pr="0">${kilometers.daily_kilometer} Km/Tag (inklusive)</option>`;
            
            kmPackages.forEach(package => {
                kmPackageOptions += `<option value="${package.kilometers}" pr="${package.extra_price * package.kilometers}">Zusätzlich ${package.kilometers} Km (+${package.extra_price * package.kilometers} €)</option>`;
            });
            kmPackageOptions += `</select>`;
            
            // Dynamically insert Kilometer Packages select element
            $('#kmPackageContainer').html(kmPackageOptions);
            
            // Update Insurance Packages
            let insurancePackageOptions = `<select id="insurancePackageSelect" class="product_select form-select">`;
            insurancePackageOptions += `<option value="${prices.standard_exemption}" pr="0">${prices.standard_exemption} € SB (inklusive)</option>`;
            
            $('#insurancePackage').text(`${prices.standard_exemption} € SB (inklusive)`);
            insurancePackages.forEach(package => {
                insurancePackageOptions += `<option value="${package.deductible}" pr="${package.price_per_day}">${package.deductible} € SB (+${package.price_per_day} €/Tag)</option>`;
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
            $('.thumbnail-gallery').empty(); // Küçük resim alanını temizle
            
            images.forEach((image, index) => {
                let displayStyle = index === 0 ? 'block' : 'none'; // Sadece ilk resmi varsayılan olarak göster
                
                // Ana resim için div oluştur
                let imageElement = `<div class="vehicle-image" style="width: auto; float: unset; display: ${displayStyle};">
                      <img src="https://safari-rentsoft.com/${image}" alt="Vehicle Image ${index + 1}" class="gallery-item" style="cursor: pointer;">
                    </div>`;
                $('.vehicle-gallery').append(imageElement);
                
                // Küçük resim için div oluştur
                let thumbnailElement = `<div class="thumbnail" style="display: inline-block; margin: 5px; cursor: pointer;">
                          <img src="https://safari-rentsoft.com/${image}" alt="Thumbnail ${index + 1}" class="thumbnail-item" style="width: 100px; height: auto;">
                        </div>`;
                $('.thumbnail-gallery').append(thumbnailElement);
            });
            
            // Küçük resimlere tıklama olayı ekleyin
            $('.thumbnail-item').click(function () {
                // Tıklanan küçük resmin indeksini al
                const index = $(this).parent().index(); // Parental div'in indeksini alarak
                
                // Tüm ana resimleri gizle
                $('.vehicle-image').css('display', 'none');
                
                // İlgili ana resmi görünür yap
                $('.vehicle-image').eq(index).css('display', 'block');
            });
            
            // Ana resme tıklama olayı ekleyin
            $('.gallery-item').click(function () {
                // Modal göster ve resim kaynağını ayarla
                var modal = $('#imageModal');
                var modalImg = $('#modalImage');
                modal.show();
                modalImg.attr('src', $(this).attr('src'));
            });
            
            // Kapatma butonuna tıklama olayı
            $('.close').click(function () {
                $('#imageModal').hide();
                $('.vehicle-image').css('display', 'none'); // Tüm resimleri gizle
                $('.vehicle-image').first().css('display', 'block'); // İlk resmi göster
            });
        }
        $(document).on('change', '#kmPackageSelect', function () {
            const selectedText = $(this).find('option:selected').text();
            $('#kmPackage').text(selectedText || '');
            
            const selectedKmPackage = $(this).val();
            $('#hiddenKmPackage').val(selectedKmPackage);
            calculatePrices2();
        });
        
        // Sigorta Paketi Seçimi ve Gizli Input
        $(document).on('change', '#insurancePackageSelect', function () {
            const selectedText = $(this).find('option:selected').text();
            $('#insurancePackage').text(selectedText || '');
            
            const selectedInsurancePackage = $(this).val();
            $('#hiddenInsurancePackage').val(selectedInsurancePackage);
            calculatePrices2();
        });
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
                
                
                dailyPrice = prices.daily_price;
                
                if (days === 4 && startDay === 1 && endDay === 5) {
                    subTotalPrice = weekdayPrice;
                    dailyPrice = weekdayPrice / 4;
                    defaultFreeKm = kilometers.weekday_kilometer / 4;
                    // console.log("weekdayPrice");
                } else if (days === 1 && startDay === 5 && endDay === 1) {
                    subTotalPrice = weekendPrice;
                    dailyPrice = weekendPrice / 3;
                    defaultFreeKm = kilometers.weekend_kilometer / 3;
                    // console.log("weekendPrice");
                } else if (days >= 30) {
                    subTotalPrice = monthlyPrice;
                    var extraDays = days - 30;
                    dailyPrice = monthlyPrice / 30;
                    if (extraDays > 0) {
                        subTotalPrice = subTotalPrice + (extraDays * dailyPrice);
                    }
                    defaultFreeKm = kilometers.monthly_kilometer / 30;
                } else if (days >= 7) {
                    subTotalPrice = weeklyPrice;
                    var extraDays = days - 7;
                    dailyPrice = weeklyPrice / 7;
                    if (extraDays > 0) {
                        subTotalPrice = subTotalPrice + (extraDays * dailyPrice);
                    }
                    defaultFreeKm = kilometers.weekly_kilometer / 7;
                } else {
                    subTotalPrice = days * dailyPrice;
                    defaultFreeKm = kilometers.daily_kilometer;
                    // console.log("dailyPrice" + dailyPrice);
                }
                // console.log("kilometers.daily_kilometer: " + kilometers.daily_kilometer);
                // console.log("monthly_kilometer: " + kilometers.monthly_kilometer);
                subTotalPrice = parseInt(subTotalPrice);
                
                defaultFreeKm = Math.floor(defaultFreeKm);
                
                
                // Update Kilometer Packages
                let kmPackageOptions = `<select id="kmPackageSelect" class="product_select">`;
                
                $('#kmPackage').text(`${defaultFreeKm} Km/Tag (inklusive)`);
                kmPackageOptions += `<option value="${defaultFreeKm}" id="defaultKM" pr="0">${defaultFreeKm} Km/Tag (inklusive)</option>`;
                
                kmPackages.forEach(package => {
                    kmPackageOptions += `<option data-package='{"kilometers": "${package.kilometers}", "extra_price": "${package.extra_price}"}' value="${package.kilometers}" pr="${package.extra_price * package.kilometers}">Zusätzlich ${package.kilometers} Km (+${package.extra_price * package.kilometers} €)</option>`;
                    
                });
                kmPackageOptions += `</select>`;
                
                $('#kmPackageContainer').html(kmPackageOptions);
                
                
                
                let insurancePackageOptions = `<select id="insurancePackageSelect" class="product_select">`;
                $('#insurancePackage').text(`${prices.standard_exemption} € SB (inklusive)` || '');
                insurancePackageOptions += `<option  value="${prices.standard_exemption}" pr="0">${prices.standard_exemption} € SB (inklusive)</option>`;
                
                //$('#insurancePackage').text(`${prices.standard_exemption} € SB (inklusive)`);
                insurancePackages.forEach(package => {
                    insurancePackageOptions += `<option data-package='{"deductible": "${package.deductible}", "price_per_day": "${package.price_per_day}"}' value="${package.deductible}" pr="${package.price_per_day}">${package.deductible} € SB (+${package.price_per_day} €/Tag)</option>`;
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
                $('#totalPriceHidden').val(TotalPrice.toFixed(2).replace('.', ','));
                console.log("pro tag: " + dailyPrice);
                console.log("total (brutto): " + TotalPrice);
                //console.log("total (net): " + totalPriceNet);
                //console.log("MwSt: " + mwst);
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
                var dailyPriceNet = prices.dailyPrice / (1.19);
                var weeklyPriceNet = prices.weeklyPrice / (1.19);
                var weekdayPriceNet = prices.weekdayPrice / (1.19);
                var weekendPriceNet = prices.weekendPrice / (1.19);
                var monthlyPriceNet = prices.monthlyPrice / (1.19);
                var depositoNet = deposito;
                
                var subTotalPrice = 0;
                var TotalPrice = 0;
                
                var startDay = startDate.getDay();
                var endDay = endDate.getDay();
                
                
                dailyPrice = prices.daily_price;
                
                if (days === 4 && startDay === 1 && endDay === 5) {
                    subTotalPrice = weekdayPrice;
                    dailyPrice = weekdayPrice / 4;
                    defaultFreeKm = kilometers.weekday_kilometer / 4;
                    // console.log("weekdayPrice");
                } else if (days === 1 && startDay === 5 && endDay === 1) {
                    subTotalPrice = weekendPrice;
                    dailyPrice = weekendPrice / 3;
                    defaultFreeKm = kilometers.weekend_kilometer / 3;
                    // console.log("weekendPrice");
                } else if (days >= 30) {
                    subTotalPrice = monthlyPrice;
                    var extraDays = days - 30;
                    dailyPrice = monthlyPrice / 30;
                    if (extraDays > 0) {
                        subTotalPrice = subTotalPrice + (extraDays * dailyPrice);
                    }
                    defaultFreeKm = kilometers.monthly_kilometer / 30;
                    // console.log("monthlyPrice");
                } else if (days >= 7) {
                    subTotalPrice = weeklyPrice;
                    var extraDays = days - 7;
                    dailyPrice = weeklyPrice / 7;
                    if (extraDays > 0) {
                        subTotalPrice = subTotalPrice + (extraDays * dailyPrice);
                    }
                    defaultFreeKm = kilometers.weekly_kilometer / 7;
                } else {
                    subTotalPrice = days * dailyPrice;
                    defaultFreeKm = kilometers.daily_kilometer;
                    // console.log("dailyPrice");
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
                // console.log("pro tag: " + dailyPrice);
                // console.log("total (brutto): " + TotalPrice);
                // //console.log("total (net): " + totalPriceNet);
                // //console.log("MwSt: " + mwst);
                // console.log("days: " + days);
                // console.log("kmPackagePrice: " + kmPackagePrice);
                // console.log("insurancePackagePrice: " + insurancePackagePrice);
            }
        }
        $(document).on('change', '#kmPackageSelect', function () {
            const selectedText = $(this).find('option:selected').text();
            $('#kmPackage').text(selectedText || '');
            
            const selectedKmPackage = $(this).val();
            $('#hiddenKmPackage').val(selectedKmPackage);
            calculatePrices2();
        });
        
        // Sigorta Paketi Seçimi ve Gizli Input
        $(document).on('change', '#insurancePackageSelect', function () {
            const selectedText = $(this).find('option:selected').text();
            $('#insurancePackage').text(selectedText || '');
            
            const selectedInsurancePackage = $(this).val();
            $('#hiddenInsurancePackage').val(selectedInsurancePackage);
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
        
        function formatToGerman(dateRange) {
            // Extract the two date times
            const [startDateTime, endDateTime] = dateRange.split(' bis ');
            
            function formatDateTime(dateTime) {
                const date = new Date(dateTime);
                
                const day = ('0' + date.getDate()).slice(-2);
                const month = ('0' + (date.getMonth() + 1)).slice(-2);
                const year = date.getFullYear();
                const hours = ('0' + date.getHours()).slice(-2);
                const minutes = ('0' + date.getMinutes()).slice(-2);
                
                return `${day}.${month}.${year} ${hours}:${minutes}`; //Uhr
            }
            
            // Format both start and end times
            const formattedStart = formatDateTime(startDateTime);
            const formattedEnd = formatDateTime(endDateTime);
            
            return `${formattedStart} bis ${formattedEnd}`;
        }
        
    });
    
    