<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Vehicle Reservation Form</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/css/intlTelInput.css'>
  <link rel='stylesheet' href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css'>
  <link rel="stylesheet" href="{{asset('/')}}book/style.css">
  <style>
    /* Gallery view styling */
    
    
    .vehicle-price a.book-button {
      display: inline-block;
      text-decoration: none;
      padding: 4px;
      margin-top: 10px;
    }
    .book-button:hover{
      color: white;
    }
    /* List view styling */
    .list-view .vehicle {
      display: block;
      width: 100%;
    }
    
    
    .vehicle-price {
      text-align: center;
    }
    .list-view .vehicles{
      box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
      border-radius: 5px;
    }
    .gallery-view .vehicle-box{
      box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
      border-radius: 5px;
      margin: 5px;
      padding: 5px;
    }
    
    .btn-filter {
      margin-right: 10px;
      padding: 5px 10px;
      border: 1px solid #007bff;
      background-color: white;
      color: #007bff;
      cursor: pointer;
      border: none;
    }
    
    .btn-filter.active {
      background-color: #007bff;
      color: white;
    }
    .mb-4{
      margin-bottom: 25px;
    }
  </style>
</head>

<body>
  <center><img src="logo.png" style="margin-top: 33px;" alt="Logo" /></center>
  
  <!-- Multi step form -->
  <section class="multi_step_form">
    
    <!-- Summary Section with Vehicle Image -->
    <div class="summary container">
      <h2 class="ctitle mb-2">Unsere Fahrzeuge</h2>
      <div id="filter-options" class="row mb-4">
        <div class="col-md-3">
          <select id="sort-by" class="form-control">
            <option value="price-asc">Fiyata göre en az</option>
            <option value="price-desc">Fiyata göre en fazla</option>
            <option value="brand">Markaya göre sırala</option>
            <option value="group">Gruba göre sırala</option>
            <option value="ps-asc">PS'ye göre en az</option>
            <option value="ps-desc">PS'ye göre en fazla</option>
          </select>
        </div>
        <div class="col-md-3">
          <select id="filter-group" class="form-select">
            <option value="all">Tüm Gruplar</option>
            <!-- Gruplar dinamik olarak JavaScript ile doldurulacak -->
          </select>
        </div>
        <div class="col-md-3">
          <select id="filter-class" class="form-select">
            <option value="all">Tüm Sınıflar</option>
            <option value="SUV">SUV</option>
            <option value="Kleinwagen">Kleinwagen</option>
            <option value="Limousine">Limousine</option>
            <option value="Kombi">Kombi</option>
            <option value="Minivan">Minivan</option>
            <option value="Coupé">Coupé</option>
            <option value="Cabriolet">Cabriolet</option>
          </select>
        </div>
        <div class="col-md-3">
          <div id="view-filters">
            <button id="list-view" class="btn-filter active mb-4">List</button>
            <button id="gallery-view" class="btn-filter mb-4">Gallery</button>
          </div>
        </div>
      </div>
      <div id="vehicle-list" class="row list-view"></div>
    </div>
  </section>
  <!-- End Multi step form -->
  
  <script src="{{asset('/')}}book/jquery.js"></script>
  <script src="{{asset('/')}}book/bootstrap.js"></script>
  <script src="{{asset('/')}}book/intlTelInput.js"></script>
  <script src="{{asset('/')}}book/popper.js"></script>
  <script src="{{asset('/')}}book/nice-select.js"></script>
  
  <script>
    $(document).ready(function () {
      const carApiUrl = "https://safari-rentsoft.com/book/cars-by-company";
      const carGroupApiUrl = "https://safari-rentsoft.com/book/car/groups";
      
      $.when(
      $.getJSON(carApiUrl),
      $.getJSON(carGroupApiUrl)
      ).then(function (carResponse, carGroupResponse) {
        const carData = carResponse[0]["1"]["cars"];
        const carGroups = carGroupResponse[0]["1"]["car_groups"];
        const displayedCars = new Set();
        let filteredCars = [];
        const filterGroupSelect = $('#filter-group');
        
        // Grupları filtreleme select'ine ekle
        carGroups.forEach(group => {
          filterGroupSelect.append(`<option value="${group.id}">${group.name}</option>`);
        });
        
        // Fonksiyon: Araçları HTML'e eklemek
        function renderCars(cars) {
          let vehicleList = '';
          const isGalleryView = $('#vehicle-list').hasClass('gallery-view');
          cars.forEach(car => {
            const carDetails = JSON.parse(car.car);
            const images = JSON.parse(car.images);
            const carGroup = carGroups.find(group => group.id === car.group_id);
            const prices = JSON.parse(car.prices);
            const carPrices = JSON.parse(car.prices);
            const monthlyPrice = carPrices.monthly_price ? carPrices.monthly_price / 30 : carPrices.daily_price;
            const kilometers = JSON.parse(car.kilometers);
            const freeKilometers = kilometers.daily_kilometer || 0;
            const columnClass = isGalleryView ? 'col-lg-4' : 'col-lg-12';
            vehicleList += `
            <div class="vehicles mb-3 ${columnClass} col-12">
              <div class="vehicle-box">
                <div class="vehicle-image">
                  <img src="https://safari-rentsoft.com/${images[0] ? images[0] : 'default.jpg'}" alt="${carDetails.brand} ${carDetails.model}">
                </div>
                <div class="vehicle-details vehicle-details2">
                  <h4 class="gallery-title">${carDetails.brand} ${carDetails.model} <span style="font-size: 10pt;">${car.horse_power || 'PS'} PS</span></h4>
                  <p><strong>Klasse: </strong> ${carGroup.name}</p>
                  <p>${freeKilometers} Freikilometer/Tag</p>
                </div>
                <div class="vehicle-price">
                  <p class="v-price">ab ${carPrices.daily_price} €<span class="v-day">/Tag</span></p>
                  <a href="https://safari-rentsoft.com/book/detail/${car.id}" class="book-button">Verfügbarkeit prüfen</a>
                </div>  
              </div>
            </div>
            `;
          });
          $('#vehicle-list').html(vehicleList);
        }
        
        // Filtreleme ve Sıralama Fonksiyonu
        function filterAndSortCars() {
          const selectedGroup = $('#filter-group').val();
          const sortBy = $('#sort-by').val();
          const selectedClass = $('#filter-class').val();  // Yeni sınıf filtresini alıyoruz
          
          // Filtreleme: Gruba ve sınıfa göre
          filteredCars = carData.filter(car => {
            const carGroup = car.group_id;
            const carClass = car.class;  // Araç sınıfı verisini aldık
            return (selectedGroup === 'all' || carGroup == selectedGroup) &&
            (selectedClass === 'all' || carClass === selectedClass);
          });
          
          // Sıralama: Fiyat, Marka, Grup veya PS'ye göre
          filteredCars.sort((a, b) => {
            const carDetailsA = JSON.parse(a.car);
            const carDetailsB = JSON.parse(b.car);
            const carGroupA = carGroups.find(group => group.id === a.group_id);
            const carGroupB = carGroups.find(group => group.id === b.group_id);
            const groupPricesA = JSON.parse(carGroupA.prices);
            const groupPricesB = JSON.parse(carGroupB.prices);
            
            // Fiyatları kontrol ediyoruz, boşsa sıfıra eşitliyoruz
            const priceA = groupPricesA.daily_price ? parseFloat(groupPricesA.daily_price) : 0;
            const priceB = groupPricesB.daily_price ? parseFloat(groupPricesB.daily_price) : 0;
            
            const psA = parseInt(a.horse_power) || 0;  // PS değerini tam sayıya çeviriyoruz
            const psB = parseInt(b.horse_power) || 0;  // PS değerini tam sayıya çeviriyoruz
            
            if (sortBy === 'price-asc') {
              return priceA - priceB;  // En düşük fiyat önce
            } else if (sortBy === 'price-desc') {
              return priceB - priceA;  // En yüksek fiyat önce
            } else if (sortBy === 'brand') {
              return carDetailsA.brand.localeCompare(carDetailsB.brand);
            } else if (sortBy === 'group') {
              return carGroupA.name.localeCompare(carGroupB.name);
            } else if (sortBy === 'ps-asc') {
              return psA - psB;  // PS'ye göre en az sıralama
            } else if (sortBy === 'ps-desc') {
              return psB - psA;  // PS'ye göre en fazla sıralama
            }
          });
          
          // Filtrelenmiş ve sıralanmış araçları yeniden ekrana ekle
          renderCars(filteredCars);
        }
        
        // Sayfa yüklendiğinde varsayılan olarak tüm araçları göster
        renderCars(carData);
        
        // Filtre ve sıralama değiştikçe araçları güncelle
        $('#filter-group, #filter-class, #sort-by').on('change', filterAndSortCars);
      }).fail(function () {
        console.error('Failed to fetch data from APIs.');
      });
    });
    $(document).ready(function() {
      // List view butonuna tıklama
      $('#list-view').on('click', function() {
        $('#vehicle-list').removeClass('gallery-view').addClass('list-view');  // Gallery görünümü kaldır, List görünümü ekle
        $('#vehicle-list .vehicles').removeClass('col-lg-4').addClass('col-lg-12');  // Gallery görünümündeki genişlik değişikliğini geri al
        $('#list-view').addClass('active');
        $('#gallery-view').removeClass('active');
      });
      
      // Gallery view butonuna tıklama
      $('#gallery-view').on('click', function() {
        $('#vehicle-list').removeClass('list-view').addClass('gallery-view');  // List görünümü kaldır, Gallery görünümü ekle
        $('#vehicle-list .vehicles').removeClass('col-lg-12').addClass('col-lg-4');  // Gallery görünümünde genişlik değiştir
        $('#gallery-view').addClass('active');
        $('#list-view').removeClass('active');
      });
    });
  </script>
  
</body>

</html>
