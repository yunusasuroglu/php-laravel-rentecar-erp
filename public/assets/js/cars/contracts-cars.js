$(document).ready(function() {
    function loadCars(groupId, selectedCarId) {
        if (groupId) {
            $.ajax({
                url: '/get-cars-by-group/' + groupId,
                type: 'GET',
                success: function(data) {
                    var carSelect = $('#car');
                    carSelect.empty();
                    carSelect.append('<option value="">Select Car</option>');
                    
                    $.each(data, function(key, car) {
                        var carOption = $('<option></option>')
                        .attr('value', car.id)
                        .attr('data-daily-price', car.prices.daily_price)
                        .attr('data-weekly-price', car.prices.weekly_price)
                        .attr('data-monthly-price', car.prices.monthly_price)
                        .attr('data-weekday-price', car.prices.weekday_price)
                        .attr('data-standard-exemption', car.prices.standard_exemption)
                        .attr('data-weekend-price', car.prices.weekend_price)
                        .attr('data-deposito', car.prices.deposito)
                        .attr('data-availability', car.availability)
                        .attr('data-contracts', JSON.stringify(car.contracts))
                        .text(car.brand + ' ' + car.model + ' ' + car.number_plate);
                        
                        if (car.id == selectedCarId) {
                            carOption.prop('selected', true);
                            var contracts = car.contracts || [];
                            updateCalendar(contracts, selectedCarId);
                        }
                        
                        carSelect.append(carOption);
                    });
                    
                    carSelect.change(function() {
                        var selectedOption = $(this).find('option:selected');
                        var contracts = selectedOption.data('contracts');
                        var selectedCarId = selectedOption.val();
                        
                        if (contracts) {
                            updateCalendar(contracts, selectedCarId);
                        } else {
                            updateCalendar([], selectedCarId);
                        }
                    });
                },
                error: function() {
                    alert('Could not fetch cars for the selected group.');
                }
            });
        } else {
            $('#car').empty().append('<option value="">Select Car</option>');
        }
    }
    
    function updateCalendar(contracts, selectedCarId) {
        var calendarEl = document.getElementById('calendar');
        
        // Mevcut takvimi temizle
        if (calendarEl && calendarEl.innerHTML.trim() !== "") {
            calendarEl.innerHTML = "";
        }
        
        var events = [];
        var unavailableDates = [];
        
        // Sözleşmeleri takvimde event olarak ekleyin
        contracts.forEach(function(contract) {
            events.push({
                title: 'Occupied',
                start: contract.start_date,
                end: contract.end_date,
                color: 'red'
            });
            
            // Müsaitlik durumunu kontrol et
            var contractStart = new Date(contract.start_date);
            var contractEnd = new Date(contract.end_date);
            for (var current = contractStart; current <= contractEnd; current.setDate(current.getDate() + 1)) {
                unavailableDates.push(new Date(current).toISOString().split('T')[0]);
            }
        });
        
        // FullCalendar takvimini oluştur ve render et
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: events,
            height: 'auto',
        });
        
        calendar.render();
        
        // Müsaitlik durumunu kontrol et
        var startDate = $('.start_date_contract').val();
        var endDate = $('.end_date_contract').val();
        
        if (startDate && endDate) {
            var selectedStart = new Date(startDate);
            var selectedEnd = new Date(endDate);
            var isAvailable = true;
            
            for (var current = selectedStart; current <= selectedEnd; current.setDate(current.getDate() + 1)) {
                if (unavailableDates.includes(new Date(current).toISOString().split('T')[0])) {
                    isAvailable = false;
                    break;
                }
            }
            
            var availabilityText = isAvailable ? 'Available' : 'Not Available';
            $('#availability_status').text(availabilityText);
            if (isAvailable) {
                $('#step_1_button').prop('disabled', false);
            } else {
                $('#step_1_button').prop('disabled', true);
            }
        }
        else {
            $('#availability_status').text('');
            $('#step_1_button').prop('disabled', true);
        }
    }
    
    $('.start_date_contract, .end_date_contract, #car').on('change', function() {
        var startDate = $('.start_date_contract').val();
        var endDate = $('.end_date_contract').val();
        var selectedCarId = $('#car').val();
        
        if (startDate && endDate && selectedCarId) {
            var car = $('#car option[value="' + selectedCarId + '"]');
            var contracts = JSON.parse(car.attr('data-contracts'));
            updateCalendar(contracts, selectedCarId);
        }
    });
    $('#car_group').change(function() {
        var groupId = $(this).val();
        loadCars(groupId, null);
    });
    
    var initialGroupId = $('#car_group').val();
    var initialCarId = $('#car').data('selected-car-id');
    
    if (initialGroupId) {
        loadCars(initialGroupId, initialCarId);
    }
    
    function parsePrice(price) {
        if (typeof price === 'string') {
            return parseFloat(price.replace(/\./g, '').replace(',', '.')) || 0;
        }
        return parseFloat(price) || 0;
    }
    
    function calculatePrices() {
        var startDate = $('.start_date_contract').val() ? new Date($('.start_date_contract').val()) : null;
        var endDate = $('.end_date_contract').val() ? new Date($('.end_date_contract').val()) : null;
        var selectedCar = $('#car').find(':selected');
        
        if (startDate && endDate && selectedCar.val()) {
            var timeDiff = endDate.getTime() - startDate.getTime();
            var days = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
            if (days === 0) {
                days = 1;
            }
            
            var dailyPrice = selectedCar.data('daily-price') ? parsePrice(selectedCar.data('daily-price')) : 0;
            var weeklyPrice = selectedCar.data('weekly-price') ? parsePrice(selectedCar.data('weekly-price')) : 0;
            var monthlyPrice = selectedCar.data('monthly-price') ? parsePrice(selectedCar.data('monthly-price')) : 0;
            var weekdayPrice = selectedCar.data('weekday-price') ? parsePrice(selectedCar.data('weekday-price')) : 0;
            var standardExemption = selectedCar.data('standard-exemption'); 
            var weekendPrice = selectedCar.data('weekend-price') ? parsePrice(selectedCar.data('weekend-price')) : 0;
            var deposito = selectedCar.data('deposito') ? parsePrice(selectedCar.data('deposito')) : 0;
            
            
            var subTotalPrice = 0;
            
            //var currentDate = new Date(startDate.getTime());
            //var dayOfWeek = currentDate.getDay();
			
			var startDay = startDate.getDay(); // 0 = Sonntag, 1 = Montag, ..., 5 = Freitag, 6 = Samstag
          	var endDay = endDate.getDay();
    
          if (days === 4 && startDay === 1 && endDay === 5) {
                subTotalPrice = weekdayPrice;
                var extraDays = 0;
                /*if (extraDays > 0) {
					dailyPrice = weekendPrice/3
                    subTotalPrice += extraDays * dailyPrice;
                }*/
          } else if (days === 1 && startDay === 5 && endDay === 1) { // Freitag bis Montag
                subTotalPrice = weekendPrice;
                var extraDays = days - 7;
                if (extraDays > 0) {
					dailyPrice = weekendPrice/3
                    subTotalPrice += extraDays * dailyPrice;
                }
          } else if (days >= 30) {
                subTotalPrice = monthlyPrice;
                var extraDays = days - 30;
                if (extraDays > 0) {
					dailyPrice = monthlyPrice/3
                    subTotalPrice += extraDays * dailyPrice;
                }
            } else if (days >= 7) {
                subTotalPrice = weeklyPrice;
                var extraDays = days - 7;
                if (extraDays > 0) {
					dailyPrice = weeklyPrice/7
                    subTotalPrice += extraDays * dailyPrice;
                }
            } else{
                subTotalPrice = days * dailyPrice;
            }
            
            //var tax = subTotalPrice * 0.19; yanlis
			var tax = subTotalPrice - (subTotalPrice / 1.19);

            var totalPrice = subTotalPrice;
            
            $('#carDetails').text(selectedCar.text());
            $('#standardExemption').text(standardExemption);
            $('#days').text(days);
            $('#tax').text(tax.toFixed(2).replace('.', ',') + ' €');
            $('#subTotalPrice').text(subTotalPrice.toFixed(2).replace('.', ',') + ' €');
            $('#deposito').text(deposito.toFixed(2).replace('.', ',') + ' €');
            $('#totalPrice').text(totalPrice.toFixed(2).replace('.', ',') + ' €');
            
            $('#hiddenSubTotalPrice').val(subTotalPrice.toFixed(2).replace('.', ','));
            $('#hiddenDeposito').val(deposito.toFixed(2).replace('.', ','));
            $('#hiddenTAX').val(tax.toFixed(2).replace('.', ','));
            $('#hiddenStandardExemption').val(standardExemption);
            $('#hiddenTotalPrice').val(totalPrice.toFixed(2).replace('.', ','));
        } 
    }
    
    $('.start_date_contract, .end_date_contract, #car').on('change', function() {
        calculatePrices();
    });
    
    // İlk yüklemede fiyatları ve sözleşmeleri hesapla
    calculatePrices();
});

document.addEventListener('DOMContentLoaded', function() {
    const kmPackagesSelect = document.getElementById('km_packages_group');
    const insurancePackagesSelect = document.getElementById('insurance_packages_group');
    const inputKilometers = document.getElementById('inputKilometers');
    const inputExtraPrice = document.getElementById('inputExtraPrice');


    function updatePrices() {
        // Kilometre Paketi
        let kmPackageData = { extra_price: 0, kilometers: 0 };

        // Eğer contractData'da seçili kilometre paketi varsa, bunu al
        if (defaultContractData.km_packages && defaultContractData.km_packages.extra_price) {
            kmPackageData = defaultContractData.km_packages;
            // Eğer seçili kilometre paketi varsa, select box'ı güncelle
            kmPackagesSelect.value = "enter_yourself"; // veya uygun değer
        } else if (kmPackagesSelect.value === "enter_yourself") {
            // Kullanıcı kendi kilometre ve fiyatını giriyor
            kmPackageData = {
                extra_price: parseFloat(inputExtraPrice.value) || 0,
                kilometers: parseFloat(inputKilometers.value) || 0
            };
        } else {
            // JSON verisini al
            const selectedKmPackage = kmPackagesSelect.options[kmPackagesSelect.selectedIndex];
            kmPackageData = selectedKmPackage ? JSON.parse(selectedKmPackage.getAttribute('data-package') || '{}') : { extra_price: 0, kilometers: 0 };
        }

        const kmExtraPrice = parseFloat(kmPackageData.extra_price) || 0;
        const kmKilometers = parseInt(kmPackageData.kilometers, 10) || 0;
        const kmPrice = kmExtraPrice * kmKilometers;


        // Sigorta Paketi
        let insurancePackageData = { price_per_day: 0, deductible: 0 };

        // Eğer contractData'da seçili sigorta paketi varsa, bunu al
        if (defaultContractData.insurance_packages && defaultContractData.insurance_packages.price_per_day) {
            insurancePackageData = defaultContractData.insurance_packages;
        } else {
            // Seçili sigorta paketi yoksa
            const selectedInsurancePackage = insurancePackagesSelect.options[insurancePackagesSelect.selectedIndex];
        
            if (selectedInsurancePackage) {
                // Seçili sigorta paketi varsa, veriyi al
                insurancePackageData = JSON.parse(selectedInsurancePackage.getAttribute('data-package') || '{}');
            } else {
                // Seçili sigorta paketi yoksa, prices sütunundaki standart sigorta bilgilerini al
                const carPrices = defaultContractData.prices || {}; // prices sütunundaki veriler
                insurancePackageData = {
                    price_per_day: 0, // Sabit sigorta fiyatı
                    deductible: parseFloat(carPrices.standard_exemption) || 0 // prices'dan standart SB (standard_exemption) değeri
                };
            }
        }

        const insurancePricePerDay = parseFloat(insurancePackageData.price_per_day) || 0;
        const insuranceSB = parseFloat(insurancePackageData.deductible) || 0;
        const days = parseInt(document.getElementById('days').textContent.trim(), 10) || 0;
        const insurancePrice = insurancePricePerDay * days;

        const insurancePackageElement = document.getElementById('insurance_packagess');

        if (insurancePackageElement) {
            insurancePackageElement.textContent = `Insurance Packet (+ ${insuranceSB} € SB)`;
        }

        // Alt Toplam, Vergi ve Toplam
        const subTotalPrice = parseFloat(document.getElementById('subTotalPrice').textContent.trim().replace('€', '')) || parseFloat(defaultContractData.subTotalPrice) || 0;
        //const taxRate = 0.19; // 19%
        //const tax = (subTotalPrice + insurancePrice + kmPrice) * taxRate;
		const tax = (subTotalPrice + insurancePrice + kmPrice) - ((subTotalPrice + insurancePrice + kmPrice) / 1.19);
        const totalPrice = subTotalPrice + insurancePrice + kmPrice;


        // UI Güncelleme
        const kmPackagePricesElement = document.getElementById('km_package_pricess');
        const kmPackageKilometersElement = document.getElementById('km_package_kilometerss');

        if (kmPackagePricesElement) {
            kmPackagePricesElement.textContent = `${kmPrice.toFixed(2)} €`;
        }

        if (kmPackageKilometersElement) {
            kmPackageKilometersElement.textContent = `Kilometer Packet (+ ${kmKilometers} Km)`;
        }

        document.getElementById('insurance_package_price').textContent = `${insurancePrice.toFixed(2)} €`;
        document.getElementById('tax').textContent = `${tax.toFixed(2)} €`;
        document.getElementById('totalPrice').textContent = `${totalPrice.toFixed(2)} €`;

        // Hidden input güncellemeleri
        document.getElementById('selected_km_package').value = JSON.stringify(kmPackageData);
        document.getElementById('selected_insurance_package').value = JSON.stringify(insurancePackageData);
        document.getElementById('hidden_tax').value = tax.toFixed(2);
        document.getElementById('hidden_totalprice').value = totalPrice.toFixed(2);

        document.getElementById('hiddenSubTotalPrice').value = subTotalPrice.toFixed(2);

    }

    kmPackagesSelect.addEventListener('change', function() {
        if (kmPackagesSelect.value === "enter_yourself") {
            document.getElementById('km-packages-container').style.display = 'block';
        } else {
            document.getElementById('km-packages-container').style.display = 'none';
        }
        updatePrices();
    });

    // Kullanıcı tarafından girilen değerlerde değişiklik yapıldığında güncelle
    inputKilometers.addEventListener('input', updatePrices);
    inputExtraPrice.addEventListener('input', updatePrices);
    insurancePackagesSelect.addEventListener('change', updatePrices);

    // Sayfa yüklendiğinde fiyatları güncelle
    updatePrices();
});