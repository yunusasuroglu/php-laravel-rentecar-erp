document.addEventListener('DOMContentLoaded', () => {
    const apiUrl = 'https://safari-rentsoft.com/book/cars-by-company';
    
    // API'den araç verilerini çekme
    let parsedContractData = {};
    fetch(apiUrl) .then(response => response.json()).then(data => {
        
        const cars = data["1"].cars;
        
        $(document).ready(function () {
            // URL'den ID'yi al
            const url = window.location.href;
            const initialId = url.split('/').pop();  // URL'nin son kısmından ID'yi al
            
            // Eğer ID mevcutsa, seçili araca göre işlemi başlat
            if (initialId) {
                handleCarSelection(initialId);  // Araç seçim fonksiyonuna ID'yi geçir
            }
            // Araç seçimi değiştiğinde, seçilen ID'ye göre işlemleri güncelle
            $(document).on('change', '#numberPlateSelect', function () {
                const selectedCarId = $(this).val();  // Select box'tan seçilen ID
                console.log("Seçili Araç ID'si:", selectedCarId);  // Doğru sırada ID'yi yazdırın
                
                if (selectedCarId) {
                    handleCarSelection(selectedCarId);  // Yeni seçilen aracı işle
                }
            });
        });
        
        function handleCarSelection(carId) {
            console.log("İşleme alınan araç ID:", carId);
            console.log(parsedContractData);
            // ID'ye göre aracı bul ve işle
            const car = cars.find(car => car.id === Number(carId));
            
            if (!car) {
                console.error('Araç bulunamadı.');
                return;
            }
            
            // Aracı bulduysak, araç bilgilerini güncelle ve formu doldur
            parsedContractData = {
                car_details: {
                    id: car.id,
                    car: {
                        brand: JSON.parse(car.car).brand,
                        model: JSON.parse(car.car).model
                    },
                    company_id: car.company_id,
                    odometer: car.odometer,
                    vin: car.vin,
                    car_group: car.car_group,
                    number_of_doors: car.number_of_doors,
                    key_number: car.key_number,
                    tire_size: car.tire_size,
                    rim_size: car.rim_size,
                    date_to_traffic: car.date_to_traffic,
                    tire_type: car.tire_type,
                    damages: JSON.parse(car.damages),
                    internal_damages: JSON.parse(car.internal_damages),
                    number_plate: car.number_plate,
                    standard_exemption: car.standard_exemption,
                    age: car.age,
                    status: car.status,
                    group_id: car.group_id,
                    prices: JSON.parse(car.prices),
                    kilometers: JSON.parse(car.kilometers),
                    km_packages: JSON.parse(car.km_packages),
                    insurance_packages: JSON.parse(car.insurance_packages),
                    images: JSON.parse(car.images),
                    description: car.description,
                    horse_power: car.horse_power,
                    fuel: car.fuel,
                    fuel_status: car.fuel_status,
                    options: JSON.parse(car.options),
                    color: car.color
                }
            };
        }
        
        document.getElementById('submitButton').addEventListener('click', () => {
            // kmPackageSelect ve insurancePackageSelect elemanlarını al
            const kmPackageSelect = document.getElementById('kmPackageSelect');
            const insurancePackageSelect = document.getElementById('insurancePackageSelect');
            
            // Seçili km paketi varsa, JSON verisini al. Yoksa boş dizi '[]' kullan.
            const selectedKmPackageOption = kmPackageSelect.options[kmPackageSelect.selectedIndex];
            const kmPackageData = selectedKmPackageOption ? selectedKmPackageOption.dataset.package : '[]';
            
            // Seçili sigorta paketi varsa, JSON verisini al. Yoksa boş dizi '[]' kullan.
            const selectedInsurancePackageOption = insurancePackageSelect.options[insurancePackageSelect.selectedIndex];
            const insurancePackageData = selectedInsurancePackageOption ? selectedInsurancePackageOption.dataset.package : '[]';
            
            // JSON verisini parse et, eğer veri yoksa boş dizi kullan
            let kmPackageDataParsed;
            try {
                kmPackageDataParsed = JSON.parse(kmPackageData);
            } catch (e) {
                console.warn('kmPackageData JSON parse hatası:', e);
                kmPackageDataParsed = []; // Hata durumunda boş dizi kullan
            }
            
            let insurancePackageDataParsed;
            try {
                insurancePackageDataParsed = JSON.parse(insurancePackageData);
            } catch (e) {
                console.warn('insurancePackageData JSON parse hatası:', e);
                insurancePackageDataParsed = []; // Hata durumunda boş dizi kullan
            }
            
            
            // Dosya girdilerini kontrol et
            const identityFront = document.getElementById('identity_front').files[0];
            const identityBack = document.getElementById('identity_back').files[0];
            const drivingFront = document.getElementById('driving_front').files[0];
            const drivingBack = document.getElementById('driving_back').files[0];
            const formData = new FormData();
            
            formData.append('customer_details', JSON.stringify({
                name: document.getElementById('name').value,
                surname: document.getElementById('surname').value,
                zip_code: document.getElementById('zip_code').value,
                street: document.getElementById('street').value,
                city: document.getElementById('city').value,
                country: document.getElementById('country').value,
                phone: document.getElementById('phone').value,
                email: document.getElementById('email').value,
                age: document.getElementById('age').value,
                identity_expiry_date: document.getElementById('identity_expiry_date').value,
                driving_expiry_date: document.getElementById('driving_expiry_date').value,
            }));
            
            // Dosyaları ekle
            if (identityFront) {
                formData.append('identity_front', identityFront);
            }
            if (identityBack) {
                formData.append('identity_back', identityBack);
            }
            if (drivingFront) {
                formData.append('driving_front', drivingFront);
            }
            if (drivingBack) {
                formData.append('driving_back', drivingBack);
            }
            
            formData.append('car_details', JSON.stringify(parsedContractData.car_details)); // JSON olarak ekleniyor
            formData.append('company_id', 3);
            formData.append('car_group', parsedContractData.car_details.group_id);
            formData.append('car_id', parsedContractData.car_details.id);
            formData.append('deposito', parsedContractData.car_details.prices.deposito);
            formData.append('km_packages', JSON.stringify(kmPackageDataParsed));
            formData.append('insurance_packages', JSON.stringify(insurancePackageDataParsed));
            formData.append('payment_method', document.querySelector('input[name="paymentMethod"]:checked').value);
            formData.append('start_date', `${document.getElementById('startDate').value} ${document.getElementById('startTime').value}`);
            formData.append('end_date', `${document.getElementById('endDate').value} ${document.getElementById('endTime').value}`);
            formData.append('tax', 19);
            formData.append('amount_paid', document.getElementById('totalPriceHidden').value);
            formData.append('remaining_amount', 0);
            formData.append('totalprice', document.getElementById('totalPriceHidden').value);
            formData.append('subtotalprice', document.getElementById('totalPriceHidden').value);
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            formData.append('_token', csrfToken);
            fetch('https://safari-rentsoft.com/book/contract/add', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Authorization': 'Bearer 144qwe4qwe412',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                
                if (data.success) { // Başarı durumunu kontrol et
                    if (data.payment_method === 'online') {
                        // Sunucu tarafında online ödeme için yönlendirme yapılacaksa
                        Swal.fire({
                            icon: 'info',
                            title: 'Redirecting to Payment...',
                            text: 'You are being redirected to the payment page.',
                        }).then(() => {
                            window.location.href = 'https://safari-rentsoft.com/book/checkout';
                        });
                    } else {
                        // Diğer durumlarda sözleşme başarı mesajı
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Contract has been added successfully.',
                        }).then(() => {
                            window.location.href = 'https://safari-rentsoft.com/book/index';
                        });
                    }
                } else {
                    // Hata mesajı göster
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'An error occurred.',
                    });
                }
            })
            .catch(error => {
                console.error('Post request error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred. Please try again.',
                });
            });
        });
        
        
    })
    .catch(error => {
        console.error('Hata:', error);
    });
});
