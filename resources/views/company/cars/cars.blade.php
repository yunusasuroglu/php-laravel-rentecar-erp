@extends('layouts.layout')
@section('title', 'Cars')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
</style>
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">{{trans_dynamic('cars')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-white-50">{{trans_dynamic('home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('cars')}}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body d-flex align-items-center flex-xxl-nowrap flex-wrap">
                        <div class="flex-fill">
                            <span class="mb-0 fs-14 text-muted">{{trans_dynamic("total_car_text")}}: <span class="fw-semibold text-success" id="totalCars">{{ $cars->count() }}</span></span>
                        </div>
                        <div class="dropdown my-sm-0 my-2">
                            <button class="btn btn-light dropdown-toggle mx-sm-1 mx-0 my-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                {{trans_dynamic("sort_by")}}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#" onclick="filterByStatus('Available')">{{trans_dynamic("available")}}</a></li>
                                <li><a class="dropdown-item" href="#" onclick="filterByStatus('Unavailable')">{{trans_dynamic("rented")}}</a></li>
                                <li><a class="dropdown-item" href="#" onclick="filterByStatus('Reserved')">{{trans_dynamic("reserved")}}</a></li>
                                <li><a class="dropdown-item" href="#" onclick="filterByStatus('All')">{{trans_dynamic("show_all")}}</a></li>
                                <li><a class="dropdown-item" href="#" onclick="filterByGroup('group')">{{trans_dynamic("group")}}</a></li>
                                <li><a class="dropdown-item" href="#" onclick="filterByMarken('marken')">{{trans_dynamic("brand")}}</a></li>
                            </ul>
                        </div>
                        <div class="d-flex" role="search">
                            <input class="form-control" id="searchInput" type="search" placeholder="{{trans_dynamic("search")}}" aria-label="{{trans_dynamic("search")}}" onkeyup="searchCars()">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="carsContainer">
                @foreach ($cars as $car)
                @php
                $images = json_decode($car->images);
                $firstImage = isset($images[0]) ? asset($images[0]) : ''; // İlk resmin yolu
                
                // Durum rozet sınıfını belirle
                $statusBadgeClass = $car->status == 'Available' ? 'bg-success' : 'bg-danger';
                $lastUsageDate = $car->last_usage_date ? \Carbon\Carbon::parse($car->last_usage_date)->format('d-M-Y') : '{{trans_dynamic("no")}} {{trans_dynamic("rentals")}}';
                @endphp
                <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-12 car-item" data-status="{{ $car->status }}" data-marken="{{$car->car ? json_decode($car->car, true)['brand'] : ''}} {{$car->car ? json_decode($car->car, true)['model'] : ''}}" data-group="{{$car->carGroup->name}}">
                    <div class="card custom-card">
                        <div class="card-header d-block">
                            <div class="d-sm-flex d-block justify-content-between">
                                <div class="">
                                    <span class="fs-14 fw-semibold card-title">{{$car->car ? json_decode($car->car, true)['brand'] : ''}} {{$car->car ? json_decode($car->car, true)['model'] : ''}} - {{$car->number_plate}} </span>
                                    <span class="d-sm-block text-primary">{{$car->vin}}</span>
                                </div>
                                <div class="text-sm-end">
                                    <p class="fs-14 fw-semibold mb-0">{{trans_dynamic("status")}}</p>
                                    <span class="badge {{ $statusBadgeClass }} fs-11 rounded-1">{{ $car->status }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center flex-xxl-nowrap flex-wrap">
                                <div class="me-3">
                                    <span class="avatar avatar-xxxl bd-gray-200">
                                        <img src="{{$firstImage}}" alt="">
                                    </span>
                                </div>
                                <div>
                                    <div class="">
                                        <p class="fw-semibold mb-0">{{trans_dynamic("available")}} {{trans_dynamic("until")}}: <span class="text-muted fs-13">{{$lastUsageDate}}</span></p>
                                    </div>
                                    <div class="d-flex mb-1">
                                        <h5 class="mb-1">{{$car->prices ? json_decode($car->prices, true)['daily_price'] : ''}}€/{{trans_dynamic("day")}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-sm-flex d-block align-items-center justify-content-between">
                            <div class="mt-sm-0 mt-2">
                                <a href="{{route('cars.detail',$car->id)}}" class="btn btn-sm btn-info-light">{{trans_dynamic("detail")}}</a>
                                <a href="{{route('cars.edit',$car->id)}}" class="btn btn-sm btn-success-light">{{trans_dynamic("edit")}}</a>
                                <a class="btn btn-sm btn-success-light" onclick="document.getElementById('duplicateForm_{{$car->id}}').submit();">{{trans_dynamic("duplicate")}}</a>
                            </div>
                            <div class="mt-sm-0 mt-2">
                                <form action="{{route('cars.delete',$car->id)}}" method="POST" id="deleteForm_{{$car->id}}">
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-danger-light" onclick="confirmDelete()">{{trans_dynamic("delete")}}</button>
                                </form>
                                <form action="{{ route('cars.copy',$car->id) }}" method="POST" id="duplicateForm_{{$car->id}}">
                                    @csrf
                                </form>
                            </div>
                            
                            <script>
                                function confirmDelete() {
                                    if (confirm("Bu arabayı silmek istediğinize emin misiniz?")) {
                                        document.getElementById('deleteForm_{{$car->id}}').submit();
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="dataTables_paginate paging_simple_numbers" id="datatable-basic_paginate">
                <ul class="pagination" style="float: right;" id="paginationLinks"></ul>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', (event) => {
                    function searchCars() {
                        let input = document.getElementById('searchInput').value.toLowerCase();
                        let carItems = document.querySelectorAll('.car-item');
                        
                        carItems.forEach(function(car) {
                            let carTitle = car.querySelector('.card-title').textContent.toLowerCase();
                            let carPlate = car.querySelector('.card-text') ? car.querySelector('.card-text').textContent.toLowerCase() : '';
                            
                            if (carTitle.includes(input) || carPlate.includes(input)) {
                                car.style.display = 'block';
                            } else {
                                car.style.display = 'none';
                            }
                        });
                        
                        updateTotalCount();
                    }
                    
                    function filterByStatus(status) {
                        let carItems = document.querySelectorAll('.car-item');
                        
                        carItems.forEach(function(car) {
                            let carStatus = car.getAttribute('data-status');
                            
                            if (status === 'All' || carStatus === status) {
                                car.style.display = 'block';
                            } else {
                                car.style.display = 'none';
                            }
                        });
                        
                        updateTotalCount();
                    }
                    
                    function filterByGroup() {
                        let carItems = Array.from(document.querySelectorAll('.car-item'));
                        let carContainer = document.getElementById('carsContainer'); // Arabaların bulunduğu ana konteyner
                        
                        // Tüm arabaların gruplarını topla
                        let groups = carItems.map(car => car.getAttribute('data-group').toLowerCase());
                        
                        // Grupları alfabetik sıraya koy ve tekrarlayanları kaldır
                        let uniqueGroups = [...new Set(groups)].sort();
                                                
                        // Konteyneri temizleyin
                        carContainer.innerHTML = '';
                        
                        // Grupları teker teker işleyerek her bir gruptaki arabaları sıralı şekilde göster
                        uniqueGroups.forEach(function(group) {
                            // Filtrelenmiş arabalar
                            let filteredCars = carItems.filter(function(car) {
                                return car.getAttribute('data-group').toLowerCase() === group;
                            });
                            
                            // Eğer gruba ait araba varsa, alfabetik sırayla ekleyin
                            if (filteredCars.length > 0) {
                                filteredCars.forEach(function(car) {
                                    car.style.display = 'block';
                                    carContainer.appendChild(car); // Her arabayı yeniden ekleyin
                                });
                            }
                        });
                        
                        updateTotalCount();  // Toplam sayıyı güncelle
                    }
                    
                    function filterByMarken() {
                        let carItems = Array.from(document.querySelectorAll('.car-item')); // Arabaları listele
                        let carContainer = document.getElementById('carsContainer'); // Arabaların bulunduğu konteyner
                        
                        // Tüm arabaların markalarını topla
                        let markens = carItems.map(car => car.getAttribute('data-marken').toLowerCase());
                        
                        // Markaları alfabetik sıraya koy ve tekrarlayanları kaldır
                        let uniqueMarkens = [...new Set(markens)].sort();
                        
                        
                        // Konteyneri temizleyin
                        carContainer.innerHTML = '';
                        
                        // Her bir markayı işleyerek arabaları ekleyin
                        uniqueMarkens.forEach(function(marken) {
                            // Filtrelenmiş arabalar
                            let filteredCars = carItems.filter(function(car) {
                                return car.getAttribute('data-marken').toLowerCase() === marken;
                            });
                            
                            // Eğer markaya ait araba varsa, alfabetik sırayla ekleyin
                            if (filteredCars.length > 0) {
                                filteredCars.forEach(function(car) {
                                    car.style.display = 'block';
                                    carContainer.appendChild(car); // Her arabayı yeniden ekleyin
                                });
                            }
                        });
                        
                        updateTotalCount();  // Toplam sayıyı güncelle
                    }
                    
                    function updateTotalCount() {
                        let visibleCars = document.querySelectorAll('.car-item[style*="display: block"]');
                        document.getElementById('totalCars').textContent = visibleCars.length;
                    }
                    
                    // Attach event listeners
                    document.getElementById('searchInput').addEventListener('keyup', searchCars);
                    
                    // Expose filterByStatus to global scope
                    window.filterByStatus = filterByStatus;
                    window.filterByGroup = filterByGroup;
                    window.filterByMarken = filterByMarken;
                });
                document.addEventListener('DOMContentLoaded', () => {
                    const itemsPerPage = 6; // Her sayfada gösterilecek araç sayısı
                    const carsContainer = document.getElementById('carsContainer');
                    const paginationLinks = document.getElementById('paginationLinks');
                    const carItems = Array.from(document.querySelectorAll('.car-item'));
                    
                    let currentPage = 1;
                    const totalPages = Math.ceil(carItems.length / itemsPerPage);
                    
                    function showPage(page) {
                        const start = (page - 1) * itemsPerPage;
                        const end = start + itemsPerPage;
                        
                        carItems.forEach((item, index) => {
                            item.style.display = (index >= start && index < end) ? 'block' : 'none';
                        });
                        
                        updatePaginationLinks();
                    }
                    
                    function updatePaginationLinks() {
                        paginationLinks.innerHTML = '';
                        
                        const prevButton = document.createElement('li');
                        prevButton.className = `paginate_button page-item ${currentPage === 1 ? 'disabled' : ''}`;
                        prevButton.innerHTML = '<a href="#" aria-controls="datatable-basic" data-dt-idx="0" tabindex="0" class="page-link">{{trans_dynamic("previous")}}</a>';
                        prevButton.addEventListener('click', (event) => {
                            event.preventDefault();
                            if (currentPage > 1) {
                                currentPage--;
                                showPage(currentPage);
                            }
                        });
                        paginationLinks.appendChild(prevButton);
                        
                        for (let i = 1; i <= totalPages; i++) {
                            const link = document.createElement('li');
                            link.className = `paginate_button page-item ${i === currentPage ? 'active' : ''}`;
                            link.innerHTML = `<a href="#" aria-controls="datatable-basic" data-dt-idx="${i}" tabindex="0" class="page-link">${i}</a>`;
                            link.addEventListener('click', (event) => {
                                event.preventDefault();
                                currentPage = i;
                                showPage(currentPage);
                            });
                            paginationLinks.appendChild(link);
                        }
                        
                        const nextButton = document.createElement('li');
                        nextButton.className = `paginate_button page-item ${currentPage === totalPages ? 'disabled' : ''}`;
                        nextButton.innerHTML = '<a href="#" aria-controls="datatable-basic" data-dt-idx="7" tabindex="0" class="page-link">{{trans_dynamic("next")}}</a>';
                        nextButton.addEventListener('click', (event) => {
                            event.preventDefault();
                            if (currentPage < totalPages) {
                                currentPage++;
                                showPage(currentPage);
                            }
                        });
                        paginationLinks.appendChild(nextButton);
                    }
                    
                    // Initialize pagination
                    showPage(currentPage);
                });
            </script>
        </div>
        <!--End::row-1 -->
        
        <!-- Start: pagination -->
        <div class="float-end mb-4" style="display:none;">
            <nav aria-label="Page navigation" class="pagination-style-4">
                <ul class="pagination mb-0 gap-2">
                    <li class="page-item disabled">
                        <a class="page-link" href="javascript:void(0);">
                            {{trans_dynamic('previous')}}
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                    <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);">
                            <i class="bi bi-three-dots"></i>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="javascript:void(0);">16</a></li>
                    <li class="page-item">
                        <a class="page-link text-primary" href="javascript:void(0);">
                            {{trans_dynamic('next')}}
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- End: pagination -->
    </div>
</div>

@endsection