@extends('layouts.layout')
@section('title', 'Update Car')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
    #fuellevel {
        font-size: 14pt;
        text-align: right;
        font-weight: bold;
        float: left;
        width: 20%;
    }
    #car-container {
        position: relative;
        display: inline-block;
    }
    #car {
        display: block;
    }
    .damage-marker {
        position: absolute;
        color: red;
        font-size: 24px;
        font-weight: bold;
        transform: translate(-50%, -50%);
        pointer-events: none; /* Prevent the mark from capturing click events */
    }
    .marker-number {
        font-size: 14px;
        vertical-align: super;
    }
    .delete-button {
        margin-top: 10px;
        display: none; /* Initially hidden */
    }
    .example-damage img {
        width: 50px;
        height: 50px;
    }
    .example-damage .fw-semibold {
        margin-left: 20px !important;
    }
</style>
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">{{trans_dynamic('cars')}} - {{$car->car ? json_decode($car->car, true)['brand'] : ''}} {{$car->car ? json_decode($car->car, true)['model'] : ''}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('cars')}}" class="text-white-50">{{trans_dynamic('cars')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('cars')}} - {{$car->car ? json_decode($car->car, true)['brand'] : ''}} {{$car->car ? json_decode($car->car, true)['model'] : ''}}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->



<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- Start::row-1 -->
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-lg-3">
                        <nav class="nav nav-tabs flex-column nav-style-5" role="tablist">
                            <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page" href="#car-info" aria-selected="true">
                                <i class="bx bx-car me-2 fs-18 align-middle"></i>{{trans_dynamic('general_information')}}
                            </a>
                            <a class="nav-link mt-3" data-bs-toggle="tab" role="tab" aria-current="page" href="#car_details" aria-selected="false" tabindex="-1">
                                <i class="bx bx-car me-2 fs-18 align-middle"></i>{{trans_dynamic('car')}} {{trans_dynamic('detail')}}
                            </a>
                            <a class="nav-link mt-3" data-bs-toggle="tab" role="tab" aria-current="page" href="#car_damages" aria-selected="false" tabindex="-1">
                                <i class="bx bx-car me-2 fs-18 align-middle"></i>{{trans_dynamic('car')}} {{trans_dynamic('reports')}}
                            </a>
                            <a class="nav-link mt-3" data-bs-toggle="tab" role="tab" aria-current="page" href="#car-images" aria-selected="false" tabindex="-1">
                                <i class="bx bx-image-add me-2 fs-18 align-middle"></i>{{trans_dynamic('car')}} {{trans_dynamic('images')}}
                            </a>
                        </nav>
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <form action="{{ route('cars.update',$car->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="tab-content mt-4 mt-lg-0">
                                <div class="tab-pane text-muted active show" id="car-info" role="tabpanel">
                                    <div class="p-3">
                                        <div class="row gy-4 mb-4">
                                            <div class="col-xl-12">
                                                <label for="km" class="form-label">{{trans_dynamic('odometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required value="{{$car->odometer}}" name="odometer" type="number" class="form-control" id="km" placeholder="{{trans_dynamic('odometer')}}">
                                                    <span class="input-group-text" id="inputGroupPrepend">Km</span>
                                                </div>
                                                @error('odometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-12 mt-3">
                                                <label for="group" class="form-label">{{trans_dynamic('group')}}</label>
                                                <select name="car_group" class="form-control" id="group">
                                                    @foreach($carGroups as $carGroup)
                                                    <option value="{{ $carGroup->id }}" data-json='{{ $carGroup->prices }}' data-km='{{ $carGroup->kilometers }}'
                                                        {{ $car->car_group == $carGroup->name ? 'selected' : '' }}>
                                                        {{ $carGroup->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('car_group')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                <script>
                                                    document.getElementById('group').addEventListener('change', function() {
                                                        var selectedOption = this.options[this.selectedIndex];
                                                        var prices = selectedOption.getAttribute('data-json');
                                                        var kilometers = selectedOption.getAttribute('data-km');
                                                        
                                                        if (prices) {
                                                            var priceData = JSON.parse(prices);
                                                            
                                                            document.getElementById('daily-price').value = priceData.daily_price;
                                                            document.getElementById('extra-km-price').value = priceData.price_per_extra_kilometer;
                                                            document.getElementById('deposito').value = priceData.deposito;
                                                            document.getElementById('standard_exemption').value = priceData.standard_exemption;
                                                            document.getElementById('weekly_price').value = priceData.weekly_price;
                                                            document.getElementById('weekday_price').value = priceData.weekday_price;
                                                            document.getElementById('monthly_price').value = priceData.monthly_price;
                                                            document.getElementById('weekend_price').value = priceData.weekend_price;
                                                        } else {
                                                            document.getElementById('daily-price').value = '';
                                                            document.getElementById('extra-km-price').value = '';
                                                            document.getElementById('deposito').value = '';
                                                            document.getElementById('standard_exemption').value = '';
                                                            document.getElementById('weekly_price').value = '';
                                                            document.getElementById('weekday_price').value = '';
                                                            document.getElementById('monthly_price').value = '';
                                                            document.getElementById('weekend_price').value = '';
                                                        }
                                                        if (kilometers) {
                                                            var kmData = JSON.parse(kilometers);
                                                            document.getElementById('daily_kilometer').value = kmData.daily_kilometer;
                                                            document.getElementById('weekly_kilometer').value = kmData.weekly_kilometer;
                                                            document.getElementById('weekday_kilometer').value = kmData.weekday_kilometer;
                                                            document.getElementById('monthly_kilometer').value = kmData.monthly_kilometer;
                                                            document.getElementById('weekend_kilometer').value = kmData.weekend_kilometer;
                                                        } else {
                                                            document.getElementById('daily_kilometer').value = '';
                                                            document.getElementById('weekly_kilometer').value = '';
                                                            document.getElementById('weekday_kilometer').value = '';
                                                            document.getElementById('monthly_kilometer').value = '';
                                                            document.getElementById('weekend_kilometer').value = '';
                                                        }
                                                    });
                                                </script>
                                            </div>
                                            <div class="col-xl-12 mt-3">
                                                <label for="extra-km-price" class="form-label">{{trans_dynamic('price_per_extra_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required value="{{$car->prices ? json_decode($car->prices, true)['price_per_extra_kilometer'] : ''}}" name="price_per_extra_kilometer" type="number" class="form-control" id="extra-km-price" placeholder="{{trans_dynamic('price_per_extra_kilometer')}}">
                                                    <span class="input-group-text" id="price_per_extra_kilometer">€</span>
                                                </div>
                                                @error('price_per_extra_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6 mt-3">
                                                <label for="deposito" class="form-label">{{trans_dynamic('deposito')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required value="{{$car->prices ? json_decode($car->prices, true)['deposito'] : ''}}" name="deposito" type="number" class="form-control" id="deposito" placeholder="{{trans_dynamic('deposito')}}">
                                                    <span class="input-group-text" id="deposito">€</span>
                                                </div>
                                                @error('deposito')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="standard_exemption" class="form-label">{{trans_dynamic('standart_insurance')}}</label>
                                                <input required value="{{$car->standard_exemption}}" name="standard_exemption" type="number" class="form-control" id="standard_exemption" placeholder="{{trans_dynamic('standart_insurance')}}">
                                                @error('standard_exemption')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6 ">
                                                <label for="daily-price" class="form-label">{{trans_dynamic('daily_price')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required value="{{json_decode($car->prices, true)['daily_price'] ?? ''}}" name="daily_price" type="number" class="form-control" id="daily-price" placeholder="{{trans_dynamic('daily_price')}}">
                                                    <span class="input-group-text">€</span>
                                                </div>
                                                @error('daily_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="daily_kilometer" class="form-label">{{trans_dynamic('daily_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required value="{{json_decode($car->kilometers, true)['daily_kilometer'] ?? ''}}" name="daily_kilometer" type="number" class="form-control" id="daily_kilometer" placeholder="{{trans_dynamic('daily_kilometer')}}">
                                                    <span class="input-group-text">Km</span>
                                                </div>
                                                @error('daily_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <div class="col-xl-6">
                                                <label for="weekly_price" class="form-label">{{trans_dynamic('weekly_price')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required value="{{json_decode($car->prices, true)['weekly_price'] ?? ''}}" name="weekly_price" type="number" class="form-control" id="weekly_price" placeholder="{{trans_dynamic('weekly_price')}}">
                                                    <span class="input-group-text">€</span>
                                                </div>
                                                @error('weekly_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="weekly_kilometer" class="form-label">{{trans_dynamic('weekly_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required value="{{json_decode($car->kilometers, true)['weekly_kilometer'] ?? ''}}" name="weekly_kilometer" type="number" class="form-control" id="weekly_kilometer" placeholder="{{trans_dynamic('weekly_kilometer')}}">
                                                    <span class="input-group-text">Km</span>
                                                </div>
                                                @error('weekly_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <div class="col-xl-6">
                                                <label for="weekday-price" class="form-label">{{trans_dynamic('weekday_price')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required value="{{json_decode($car->prices, true)['weekday_price'] ?? ''}}" name="weekday_price" type="number" class="form-control" id="weekday_price" placeholder="{{trans_dynamic('weekday_price')}}">
                                                    <span class="input-group-text">€</span>
                                                </div>
                                                @error('weekday_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="weekday_kilometer" class="form-label">{{trans_dynamic('weekday_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required value="{{json_decode($car->kilometers, true)['weekday_kilometer'] ?? ''}}" name="weekday_kilometer" type="number" class="form-control" id="weekday_kilometer" placeholder="{{trans_dynamic('weekday_kilometer')}}">
                                                    <span class="input-group-text">Km</span>
                                                </div>
                                                @error('weekday_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <div class="col-xl-6">
                                                <label for="monthly_price" class="form-label">{{trans_dynamic('monthly_price')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required value="{{json_decode($car->prices, true)['monthly_price'] ?? ''}}" name="monthly_price" type="number" class="form-control" id="monthly_price" placeholder="{{trans_dynamic('monthly_price')}}">
                                                    <span class="input-group-text">€</span>
                                                </div>
                                                @error('monthly_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="monthly_kilometer" class="form-label">{{trans_dynamic('monthly_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required value="{{json_decode($car->kilometers, true)['monthly_kilometer'] ?? ''}}" name="monthly_kilometer" type="number" class="form-control" id="monthly_kilometer" placeholder="{{trans_dynamic('monthly_kilometer')}}">
                                                    <span class="input-group-text">Km</span>
                                                </div>
                                                @error('monthly_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <div class="col-xl-6">
                                                <label for="weekend_price" class="form-label">{{trans_dynamic('weekend_price')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required value="{{json_decode($car->prices, true)['weekend_price'] ?? ''}}" name="weekend_price" type="number" class="form-control" id="weekend_price" placeholder="{{trans_dynamic('weekend_price')}}">
                                                    <span class="input-group-text">€</span>
                                                </div>
                                                @error('weekend_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="weekend_kilometer" class="form-label">{{trans_dynamic('weekend_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required value="{{json_decode($car->kilometers, true)['weekend_kilometer'] ?? ''}}" name="weekend_kilometer" type="number" class="form-control" id="weekend_kilometer" placeholder="{{trans_dynamic('weekend_kilometer')}}">
                                                    <span class="input-group-text">Km</span>
                                                </div>
                                                @error('weekend_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-12 ">
                                                <label for="status" class="form-label">{{trans_dynamic('status')}}</label>
                                                <select name="status" class="form-control" id="status">
                                                    <option value="1" {{ old('status', $car->status ?? '') == 1 ? 'selected' : '' }}>{{trans_dynamic('active')}}</option>
                                                    <option value="2" {{ old('status', $car->status ?? '') == 2 ? 'selected' : '' }}>{{trans_dynamic('inactive')}}</option>
                                                </select>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <a id="next-tab" data-bs-toggle="tab" role="tab" aria-current="page" href="#car_details" aria-selected="false" tabindex="-1" class="btn btn-primary d-block align-items-center justify-content-between">{{trans_dynamic('next')}}</a>
                                            </div>
                                        </div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                var nextTab = document.getElementById('next-tab');
                                                nextTab.addEventListener('click', function (event) {
                                                    event.preventDefault(); // Varsayılan davranışı engelle
                                                    
                                                    // Sadece $car-info div'inin içerisindeki required inputları seç
                                                    var carInfoSection = document.getElementById('car-info');
                                                    var requiredInputs = carInfoSection.querySelectorAll('input[required]');
                                                    var allFilled = true; // Tüm alanların dolu olup olmadığını kontrol etmek için flag
                                                    
                                                    requiredInputs.forEach(function (input) {
                                                        if (!input.value) { // Eğer input boşsa
                                                            allFilled = false; // Tüm alanlar dolu değil
                                                            input.classList.add('is-invalid'); // Boş inputlara hata stili ekleyin
                                                        } else {
                                                            input.classList.remove('is-invalid'); // Dolu olanlardan hata stilini kaldırın
                                                        }
                                                    });
                                                    
                                                    if (!allFilled) {
                                                        alert("{{trans_dynamic('car_add_error')}}"); // Uyarı ver
                                                        return; // Eğer herhangi bir alan boşsa, devam etme
                                                    }
                                                    
                                                    // Eğer tüm inputlar doluysa bir sonraki sekmeye geç
                                                    var nextTabId = 'car_details'; // Hedef sekmenin ID'sini belirtin
                                                    var nextTabElement = document.querySelector(`a[href="#${nextTabId}"]`);
                                                    
                                                    if (nextTabElement) {
                                                        var tab = new bootstrap.Tab(nextTabElement);
                                                        tab.show(); // Bir sonraki sekmeyi göster
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="tab-pane text-muted" id="car_details" role="tabpanel">
                                    <div class="p-3">
                                        <div class="row gy-4 mb-4">
                                            <div class="col-xl-6">
                                                <label for="brand" class="form-label">{{trans_dynamic('brand')}}</label>
                                                <select name="brand" class="form-control" id="edit_brand">
                                                    @if ($car->car)
                                                    @php
                                                    $carData = json_decode($car->car, true);
                                                    $selectedBrand = isset($carData['brand']) ? $carData['brand'] : '';
                                                    @endphp
                                                    <option value="{{$selectedBrand}}" selected>{{$selectedBrand}}</option>
                                                    @endif
                                                </select>
                                                @error('brand')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="model" class="form-label">{{trans_dynamic('model')}}</label>
                                                <select name="model" class="form-control" id="edit_model">
                                                    @if ($car->car)
                                                    @php
                                                    $carData = json_decode($car->car, true);
                                                    $selectedModel = isset($carData['model']) ? $carData['model'] : '';
                                                    @endphp
                                                    <option value="{{$selectedModel}}" selected>{{$selectedModel}}</option>
                                                    @endif
                                                </select>
                                                @error('model')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="class" class="form-label">{{trans_dynamic('class')}}</label>
                                                <select name="class" class="form-control">
                                                    <option value="" selected>{{trans_dynamic('not_selected')}}</option>
                                                    <option value="SUV" {{ $car->class == 'SUV' ? 'selected' : '' }}>SUV</option>
                                                    <option value="Kleinwagen" {{ $car->class == 'Kleinwagen' ? 'selected' : '' }}>Kleinwagen</option>
                                                    <option value="Limousine" {{ $car->class == 'Limousine' ? 'selected' : '' }}>Limousine</option>
                                                    <option value="Kombi" {{ $car->class == 'Kombi' ? 'selected' : '' }}>Kombi</option>
                                                    <option value="Minivan" {{ $car->class == 'Minivan' ? 'selected' : '' }}>Minivan</option>
                                                    <option value="Coupé" {{ $car->class == 'Coupé' ? 'selected' : '' }}>Coupé</option>
                                                    <option value="Cabriolet" {{ $car->class == 'Cabriolet' ? 'selected' : '' }}>Cabriolet</option>
                                                </select>
                                                @error('class')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror 
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="class2" class="form-label">{{trans_dynamic('class')}} <small>(⁠Kleinwagen, Mittelklasse, Oberklasse )</small></label>
                                                <select name="class2" class="form-control">
                                                    <option value="" selected>Not Selected</option>
                                                    <option value="⁠Kleinwagen (A-Klasse)" {{ $car->class2 == '⁠Kleinwagen (A-Klasse)' ? 'selected' : '' }}>⁠Kleinwagen (A-Klasse)</option>
                                                    <option value="Mittelklasse (B-Klasse)" {{ $car->class2 == 'Mittelklasse (B-Klasse)' ? 'selected' : '' }}>Mittelklasse (B-Klasse)</option>
                                                    <option value="Oberklasse (C-Klasse)" {{ $car->class2 == 'Oberklasse (C-Klasse)' ? 'selected' : '' }}>Oberklasse (C-Klasse)</option>
                                                    <option value="SUV (Sport Utility Vehicle)" {{ $car->class2 == 'SUV' ? 'selected' : '' }}>SUV (Sport Utility Vehicle)</option>
                                                    <option value="Coupé" {{ $car->class2 == 'Coupé' ? 'selected' : '' }}>Coupé</option>
                                                    <option value="Kombi" {{ $car->class2 == 'Kombi' ? 'selected' : '' }}>Kombi</option>
                                                    <option value="Van / MPV" {{ $car->class2 == 'Van / MPV' ? 'selected' : '' }}>Van / MPV</option>
                                                </select>
                                                @error('class2')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror 
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="number_of_doors" class="form-label">{{trans_dynamic('number_of_doors')}}</label>
                                                <input required value="{{$car->number_of_doors}}" name="number_of_doors" type="text" class="form-control" id="number_of_doors" placeholder="{{trans_dynamic('number_of_doors')}}">
                                                @error('number_of_doors')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="horse_power" class="form-label">{{trans_dynamic('horse_power')}}</label>
                                                <input required value="{{$car->horse_power}}" name="horse_power" type="text" class="form-control" id="horse_power" placeholder="{{trans_dynamic('horse_power')}}">
                                                @error('horse_power')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6 mt-3">
                                                <label for="fuel" class="form-label">{{trans_dynamic('fuel')}}</label>
                                                <select name="fuel" class="form-control" id="fuel">
                                                    <option value="Gasolina" {{ $car->fuel == 'Gasolina' ? 'selected' : '' }}>Gasolina</option>
                                                    <option value="Diesel" {{ $car->fuel == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                                    <option value="Electric" {{ $car->fuel == 'Electric' ? 'selected' : '' }}>Electric</option>
                                                </select>
                                                @error('fuel')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="color" class="form-label">{{trans_dynamic('color')}}</label>
                                                <input required value="{{$car->color}}" name="color" type="text" class="form-control" id="color" placeholder="Color">
                                                @error('color')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="vin" class="form-label">{{trans_dynamic('vin')}}</label>
                                                <input required value="{{$car->vin}}" name="vin" type="text" class="form-control" id="vin" placeholder="{{trans_dynamic('vin')}}">
                                                @error('vin')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            {{-- <div class="col-xl-6">
                                                <label for="gps" class="form-label">GPS Tracker</label>
                                                <select class="form-control" id="gps">
                                                    <option value="35571000000000">G 1000 - 35571000000000</option>
                                                    <option value="35571000000001">G 1001 - 35571000000001</option>
                                                    <option value="35571000000002">G 1002 - 35571000000002</option>
                                                </select>
                                            </div> --}}
                                            <div class="col-xl-6">
                                                <label for="min-age" class="form-label">{{trans_dynamic('min_age')}}</label>
                                                <select name="min_age" class="form-control" id="min-age">
                                                    @for ($i = 18; $i <= 30; $i++)
                                                    <option value="{{ $i }}" {{ $car->age == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                @error('min_age')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="plate" class="form-label">{{trans_dynamic('number_plate')}}</label>
                                                <input required value="{{$car->number_plate}}" name="number_plate" type="text" class="form-control" id="plate" placeholder="{{trans_dynamic('number_plate')}}">
                                                @error('number_plate')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="date_to_traffic" class="form-label">{{trans_dynamic('opening_date_to_traffic')}}</label>
                                                <input required value="{{$car->date_to_traffic}}" name="traffic_date" type="date" class="form-control" id="date_to_traffic" placeholder="{{trans_dynamic('opening_date_to_traffic')}}">
                                                @error('traffic_date')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="tire_type" class="form-label">{{trans_dynamic('tire_type')}}:</label>
                                                <select name="tire_type" class="form-control" id="tire_type">
                                                    <option value="Summery" {{ $car->tire_type == 'Summery' ? 'selected' : '' }}>Summery</option>
                                                    <option value="Winter" {{ $car->tire_type == 'Winter' ? 'selected' : '' }}>Winter</option>
                                                    <option value="Long way" {{ $car->tire_type == 'Long way' ? 'selected' : '' }}>Long way</option>
                                                </select>
                                                @error('tire_type')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="tire_size" class="form-label">{{trans_dynamic('tire_size')}}:</label>
                                                <input required name="tire_size" value="{{$car->tire_size}}" type="text" class="form-control" id="tire_size" placeholder="{{trans_dynamic('tire_size')}}">
                                                @error('tire_size')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="rim_size" class="form-label">{{trans_dynamic('rim_size')}}:</label>
                                                <input required name="rim_size" type="text" value="{{$car->rim_size}}" class="form-control" id="rim_size" placeholder="{{trans_dynamic('rim_size')}}">
                                                @error('rim_size')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="key_number" class="form-label">{{trans_dynamic('key_number')}}:</label>
                                                <input required name="key_number" type="text" value="{{$car->key_number}}" class="form-control" id="key_number" placeholder="{{trans_dynamic('key_number')}}">
                                                @error('key_number')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="desc" class="form-label">{{trans_dynamic('description')}}</label>
                                                <textarea name="desc" id="desc" class="form-control" placeholder="{{trans_dynamic('description')}}">{{$car->description}}</textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 mt-3">
                                                    <a id="previus-tab1" data-bs-toggle="tab" role="tab" aria-current="page" href="#car-info" aria-selected="false" tabindex="-1" class="btn btn-secondary d-block align-items-center justify-content-between">{{trans_dynamic('previous')}}</a>
                                                </div>
                                                <div class="col-6 mt-3">
                                                    <a id="next-tab1" data-bs-toggle="tab" role="tab" aria-current="page" href="#car_damages" aria-selected="false" tabindex="-1" class="btn btn-primary d-block align-items-center justify-content-between">{{trans_dynamic('next')}}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                var nextTab = document.getElementById('next-tab1');
                                                var prevTab = document.getElementById('previus-tab1');
                                                nextTab.addEventListener('click', function (event) {
                                                    event.preventDefault(); // Varsayılan davranışı engelle
                                                    
                                                    // Sadece $car-info div'inin içerisindeki required inputları seç
                                                    var carInfoSection = document.getElementById('car_details');
                                                    var requiredInputs = carInfoSection.querySelectorAll('input[required]');
                                                    var allFilled = true; // Tüm alanların dolu olup olmadığını kontrol etmek için flag
                                                    
                                                    requiredInputs.forEach(function (input) {
                                                        if (!input.value) { // Eğer input boşsa
                                                            allFilled = false; // Tüm alanlar dolu değil
                                                            input.classList.add('is-invalid'); // Boş inputlara hata stili ekleyin
                                                        } else {
                                                            input.classList.remove('is-invalid'); // Dolu olanlardan hata stilini kaldırın
                                                        }
                                                    });
                                                    
                                                    if (!allFilled) {
                                                        alert("Lütfen tüm gerekli alanları doldurun."); // Uyarı ver
                                                        return; // Eğer herhangi bir alan boşsa, devam etme
                                                    }
                                                    
                                                    // Eğer tüm inputlar doluysa bir sonraki sekmeye geç
                                                    var nextTabId = 'car_damages'; // Hedef sekmenin ID'sini belirtin
                                                    var nextTabElement = document.querySelector(`a[href="#${nextTabId}"]`);
                                                    
                                                    if (nextTabElement) {
                                                        var tab = new bootstrap.Tab(nextTabElement);
                                                        tab.show(); // Bir sonraki sekmeyi göster
                                                    }
                                                });
                                                prevTab.addEventListener('click', function (event) {
                                                    event.preventDefault(); // Varsayılan davranışı engelle
                                                    
                                                    var nextTabId = 'car-info'; // Hedef sekmenin ID'sini belirtin
                                                    var nextTabElement = document.querySelector(`a[href="#${nextTabId}"]`);
                                                    
                                                    if (nextTabElement) {
                                                        var tab = new bootstrap.Tab(nextTabElement);
                                                        tab.show();
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="tab-pane text-muted" id="car_damages" role="tabpanel">
                                    <div class="p-3">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="card custom-card">
                                                    <div class="card-header">
                                                        <div class="card-title">
                                                            {{trans_dynamic('fuel_level')}}
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <input required type="range" name="fuel_status" class="form-range" min="0" max="100" step="10" value="{{$car->fuel_status}}"
                                                        id="customRange3" style="float: left; width: 80%;">
                                                        <p id="fuellevel">{{$car->fuel_status}}%</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-xl-12">
                                                <div class="col-xl-7">
                                                    <div class="card custom-card">
                                                        <div class="card-header">
                                                            <div class="card-title">
                                                                {{trans_dynamic('damage')}} {{trans_dynamic('edit')}}
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="container mt-5">
                                                                <div id="car-container" class="mb-3">
                                                                    <img id="car" src="{{ asset('/assets/images/cars/damages/damages.jpg') }}" class="img-fluid" alt="Car Silhouette">
                                                                    
                                                                    @php
                                                                    $damagesArray = json_decode(json_encode($damagesArray), true);
                                                                    $markerIndex = 1; // Başlangıç indeksi
                                                                    @endphp
                                                                    
                                                                    @foreach ($damagesArray as $damage)
                                                                    <div class="damage-marker" id="marker-{{ $markerIndex }}" style="left: {{ $damage['coordinates']['x'] }}%; top: {{ $damage['coordinates']['y'] }}%;">
                                                                        X<span class="marker-number">{{ $markerIndex }}</span>
                                                                    </div>
                                                                    
                                                                    @php
                                                                    $markerIndex++; // Her hasar için indeksi artır
                                                                    @endphp
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="card custom-card">
                                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                                <div class="card-title">
                                                                    {{trans_dynamic('internal_damages')}}
                                                                </div>
                                                                <button type="button" class="btn btn-primary" id="addDamageBtn">{{trans_dynamic('damage_add')}}</button>
                                                            </div>
                                                            <div class="card-body" id="damagesContainer">
                                                                @php
                                                                $damageCount = 0;
                                                                @endphp
                                                                
                                                                @foreach($internalDamagesArray as $damagesGroup)
                                                                @foreach($damagesGroup as $damage)
                                                                @php
                                                                $damageCount++;
                                                                @endphp
                                                                <div class="damage-item mb-3">
                                                                    <div class="row">
                                                                        <div class="col-xl-6">
                                                                            <strong>{{trans_dynamic('description')}}:</strong> {{ $damage['description'] }}
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            @if(isset($damage['image']))
                                                                            <img src="{{ asset('assets/images/' . $damage['image']) }}" alt="Damage Image" style="width: 60px; height:60px;">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <script>
                                                        // Mevcut hasar sayısını PHP'den alıyoruz
                                                        let damageNumber = {{ $damageCount }};
                                                        
                                                        document.getElementById('addDamageBtn').addEventListener('click', function() {
                                                            damageNumber++;
                                                            
                                                            // Yeni hasar girişini eklemek için bir div oluşturuyoruz
                                                            const damageDiv = document.createElement('div');
                                                            damageDiv.classList.add('damage-input-group', 'mb-3');
                                                            damageDiv.setAttribute('id', `damage-group-${damageNumber}`);
                                                            
                                                            // Hasar açıklaması için bir text input oluşturuyoruz
                                                            const textInput = document.createElement('input');
                                                            textInput.setAttribute('type', 'text');
                                                            textInput.setAttribute('name', `internal_damage_description_${damageNumber}`);
                                                            textInput.classList.add('form-control', 'mb-2');
                                                            textInput.setAttribute('placeholder', 'Describe the damage');
                                                            
                                                            // Hasar resmini yüklemek için bir file input oluşturuyoruz
                                                            const fileInput = document.createElement('input');
                                                            fileInput.setAttribute('type', 'file');
                                                            fileInput.setAttribute('name', `internal_damage_image_${damageNumber}`);
                                                            fileInput.classList.add('form-control');
                                                            
                                                            // Inputları hasar div'ine ekliyoruz
                                                            damageDiv.appendChild(textInput);
                                                            damageDiv.appendChild(fileInput);
                                                            
                                                            // Hasar div'ini container'a ekliyoruz
                                                            document.getElementById('damagesContainer').appendChild(damageDiv);
                                                        });
                                                    </script>
                                                </div>
                                                <div class="col-xl-5">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="card custom-card">
                                                                <div class="card-header">
                                                                    <div class="card-title">
                                                                        {{trans_dynamic('damages')}}
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <ul class="list-group mb-3" id="default-damages-list"></ul>
                                                                    
                                                                    <div id="damage-forms-container"></div>
                                                                    <button id="delete-last" class="btn btn-danger mt-3 delete-button">{{trans_dynamic('remove_last')}}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <div class="card custom-card">
                                                                <div class="card-header">
                                                                    <div class="card-title">
                                                                        {{trans_dynamic('options')}}
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="form-check d-flex align-items-center justify-content-between mb-2">
                                                                        <label class="form-check-label me-2" for="triangle_reflector">
                                                                            {{trans_dynamic('triangle_reflector')}}
                                                                        </label>
                                                                        <div class="d-flex">
                                                                            <div class="form-check form-check-inline">
                                                                                <input required class="form-check-input option-radio" type="radio" 
                                                                                name="options[triangle_reflector]" id="triangle_reflector_yes" value="yes" 
                                                                                {{ isset($options['triangle_reflector']) && $options['triangle_reflector'] == 'yes' ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="triangle_reflector_yes">
                                                                                    {{trans_dynamic('yes')}}
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline ms-3">
                                                                                <input required class="form-check-input option-radio" type="radio" 
                                                                                name="options[triangle_reflector]" id="triangle_reflector_no" value="no" 
                                                                                {{ isset($options['triangle_reflector']) && $options['triangle_reflector'] == 'no' ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="triangle_reflector_no">
                                                                                    {{trans_dynamic('no')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="form-check d-flex align-items-center justify-content-between mb-2">
                                                                        <label class="form-check-label me-2" for="reflective_vest">
                                                                            {{trans_dynamic('reflective_vest')}}
                                                                        </label>
                                                                        <div class="d-flex">
                                                                            <div class="form-check form-check-inline">
                                                                                <input required class="form-check-input option-radio" type="radio" 
                                                                                name="options[reflective_vest]" id="reflective_vest_yes" value="yes" 
                                                                                {{ isset($options['reflective_vest']) && $options['reflective_vest'] == 'yes' ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="reflective_vest_yes">
                                                                                    {{trans_dynamic('yes')}}
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline ms-3">
                                                                                <input required class="form-check-input option-radio" type="radio" 
                                                                                name="options[reflective_vest]" id="reflective_vest_no" value="no" 
                                                                                {{ isset($options['reflective_vest']) && $options['reflective_vest'] == 'no' ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="reflective_vest_no">
                                                                                    {{trans_dynamic('no')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="form-check d-flex align-items-center justify-content-between mb-2">
                                                                        <label class="form-check-label me-2" for="first_aid_kit">
                                                                            {{trans_dynamic('first_aid_kit')}}
                                                                        </label>
                                                                        <div class="d-flex">
                                                                            <div class="form-check form-check-inline">
                                                                                <input required class="form-check-input option-radio" type="radio" 
                                                                                name="options[first_aid_kit]" id="first_aid_kit_yes" value="yes" 
                                                                                {{ isset($options['first_aid_kit']) && $options['first_aid_kit'] == 'yes' ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="first_aid_kit_yes">
                                                                                    {{trans_dynamic('yes')}}
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline ms-3">
                                                                                <input required class="form-check-input option-radio" type="radio" 
                                                                                name="options[first_aid_kit]" id="first_aid_kit_no" value="no" 
                                                                                {{ isset($options['first_aid_kit']) && $options['first_aid_kit'] == 'no' ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="first_aid_kit_no">
                                                                                    {{trans_dynamic('no')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="form-check d-flex align-items-center justify-content-between mb-2">
                                                                        <label class="form-check-label me-2" for="clean">
                                                                            {{trans_dynamic('it_clean')}}
                                                                        </label>
                                                                        <div class="d-flex">
                                                                            <div class="form-check form-check-inline">
                                                                                <input required class="form-check-input option-radio" type="radio" 
                                                                                name="options[clean]" id="clean_yes" value="yes" 
                                                                                {{ isset($options['clean']) && $options['clean'] == 'yes' ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="clean_yes">
                                                                                    {{trans_dynamic('yes')}}
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline ms-3">
                                                                                <input required class="form-check-input option-radio" type="radio" 
                                                                                name="options[clean]" id="clean_no" value="no" 
                                                                                {{ isset($options['clean']) && $options['clean'] == 'no' ? 'checked' : '' }}>
                                                                                <label class="form-check-label" for="clean_no">
                                                                                    {{trans_dynamic('no')}}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="form-check d-flex align-items-center justify-content-between mb-2">
                                                                        <label class="form-check-label me-2" for="tire_profile">
                                                                            {{trans_dynamic('vehicle_tire_profile')}}
                                                                        </label>
                                                                        <div class="d-flex">
                                                                            <div class="form-group form-group-inline">
                                                                                <input required class="form-control option-radio" type="text" 
                                                                                name="options[tire_profile]" id="tire_profile" value="{{ isset($options['tire_profile']) ? $options['tire_profile'] : '' }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @error('options.triangle_reflector')
                                                                <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                                @error('options.reflective_vest')
                                                                <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                                @error('options.first_aid_kit')
                                                                <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                                @error('options.clean')
                                                                <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                                @error('options.tire_profile')
                                                                <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mt-3">
                                            <a id="previus-tab2" data-bs-toggle="tab" role="tab" aria-current="page" href="#car_details" aria-selected="false" tabindex="-1" class="btn btn-secondary d-block align-items-center justify-content-between">{{trans_dynamic('previous')}}</a>
                                        </div>
                                        <div class="col-6 mt-3">
                                            <a id="next-tab2" data-bs-toggle="tab" role="tab" aria-current="page" href="#car-images" aria-selected="false" tabindex="-1" class="btn btn-primary d-block align-items-center justify-content-between">{{trans_dynamic('next')}}</a>
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            var nextTab = document.getElementById('next-tab2');
                                            var prevTab = document.getElementById('previus-tab2');
                                            var prevTab2 = document.getElementById('previus-tab3');
                                            nextTab.addEventListener('click', function (event) {
                                                event.preventDefault(); // Varsayılan davranışı engelle
                                                
                                                // Sadece $car-info div'inin içerisindeki required inputları seç
                                                var carInfoSection = document.getElementById('car_damages');
                                                var requiredInputs = carInfoSection.querySelectorAll('input[required]');
                                                var allFilled = true; // Tüm alanların dolu olup olmadığını kontrol etmek için flag
                                                
                                                requiredInputs.forEach(function (input) {
                                                    if (!input.value) { // Eğer input boşsa
                                                        allFilled = false; // Tüm alanlar dolu değil
                                                        input.classList.add('is-invalid'); // Boş inputlara hata stili ekleyin
                                                    } else {
                                                        input.classList.remove('is-invalid'); // Dolu olanlardan hata stilini kaldırın
                                                    }
                                                });
                                                
                                                if (!allFilled) {
                                                    alert("{{trans_dynamic('car_add_error')}}"); // Uyarı ver
                                                    return; // Eğer herhangi bir alan boşsa, devam etme
                                                }
                                                
                                                // Eğer tüm inputlar doluysa bir sonraki sekmeye geç
                                                var nextTabId = 'car-images'; // Hedef sekmenin ID'sini belirtin
                                                var nextTabElement = document.querySelector(`a[href="#${nextTabId}"]`);
                                                
                                                if (nextTabElement) {
                                                    var tab = new bootstrap.Tab(nextTabElement);
                                                    tab.show(); // Bir sonraki sekmeyi göster
                                                }
                                            });
                                            prevTab.addEventListener('click', function (event) {
                                                event.preventDefault(); // Varsayılan davranışı engelle
                                                
                                                var nextTabId = 'car_details'; // Hedef sekmenin ID'sini belirtin
                                                var nextTabElement = document.querySelector(`a[href="#${nextTabId}"]`);
                                                
                                                if (nextTabElement) {
                                                    var tab = new bootstrap.Tab(nextTabElement);
                                                    tab.show();
                                                }
                                            });
                                            prevTab2.addEventListener('click', function (event) {
                                                event.preventDefault(); // Varsayılan davranışı engelle
                                                
                                                var nextTabId = 'car_damages'; // Hedef sekmenin ID'sini belirtin
                                                var nextTabElement = document.querySelector(`a[href="#${nextTabId}"]`);
                                                
                                                if (nextTabElement) {
                                                    var tab = new bootstrap.Tab(nextTabElement);
                                                    tab.show();
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                                <div class="tab-pane text-muted" id="car-images" role="tabpanel">
                                    <div class="p-3">
                                        <div id="car-images-container">
                                            @php
                                            // $car->images JSON verisini ayrıştırma
                                            $carImages = json_decode($car->images ?? '[]', true);
                                            @endphp
                                            
                                            @if (!empty($carImages))
                                            @foreach($carImages as $index => $image)
                                            <div class="row gy-2 mb-2 car-image" data-index="{{ $index }}">
                                                <div class="col-xl-4 mt-2">
                                                    <img src="{{ asset($image) }}" class="img-fluid w-50 mx-auto d-block" alt="Car Image">
                                                </div>
                                                <div class="col-xl-2 mt-2" style="place-self: center;">
                                                    <button type="button" class="btn btn-danger" onclick="removeImage({{ $index }}, '{{ $image }}')"><i class="bx bx-trash"></i></button>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            <!-- Eğer images boşsa, bir tane boş input alanı göster -->
                                            <div class="row gy-2 mb-2 car-image" data-index="0">
                                                <div class="col-xl-12">
                                                    <label for="car-photo-0" class="form-label">{{trans_dynamic('photo')}}</label>
                                                    <input required name="images[]" type="file" class="form-control" id="car-photo-0">
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-success mt-3" onclick="addImages()">{{trans_dynamic('add_another_images')}}</button>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mt-3">
                                            <a id="previus-tab3" data-bs-toggle="tab" role="tab" aria-current="page" href="#car_damages" aria-selected="false" tabindex="-1" class="btn btn-secondary d-block align-items-center justify-content-between">{{trans_dynamic('previous')}}</a>
                                        </div>
                                        <div class="col-6 mt-3">
                                            <button class="btn btn-primary w-100">{{trans_dynamic('edit')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End::app-content -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const brandSelect = document.getElementById('edit_brand'); // Marka select elementi
        const modelSelect = document.getElementById('edit_model'); // Model select elementi
        var siteurl = {{asset('/')}}
        
        // Önceden seçili marka ve model bilgilerini almak için PHP tarafından sağlanan değerler
        const selectedBrand = {!! json_encode($car->car ? json_decode($car->car, true)['brand'] : '') !!};
        const selectedModel = {!! json_encode($car->car ? json_decode($car->car, true)['model'] : '') !!};
        
        // Marka ve model verilerini JSON dosyasından yüklemek
        fetch(siteurl + 'assets/js/cars/modelle.json')
        .then(response => response.json())
        .then(data => {
            // Marka seçeneklerini doldurma
            data.forEach(brand => {
                const option = document.createElement('option');
                option.value = brand.label; // Marka değerini option'ın value'su olarak ayarla
                option.textContent = brand.label; // Marka adını option'ın metin içeriği olarak ayarla
                brandSelect.appendChild(option);
                
                // Eğer bu marka seçili marka ise, seçili olarak işaretle
                if (brand.label === selectedBrand) {
                    option.selected = true;
                }
            });
            
            // Marka seçimi değiştikçe model seçeneklerini güncelle
            brandSelect.addEventListener('change', function () {
                const selectedBrandLabel = this.value; // Seçilen marka adını al
                
                // Model select'i temizle
                modelSelect.innerHTML = '';
                
                // Seçilen markaya ait modelleri ekle
                const selectedBrand = data.find(brand => brand.label === selectedBrandLabel);
                if (selectedBrand && selectedBrand.models) {
                    const modelsData = JSON.parse(selectedBrand.models);
                    
                    modelsData.data.forEach(model => {
                        const option = document.createElement('option');
                        option.value = model.label.toString(); // Model değerini option'ın value'su olarak ayarla
                        option.textContent = model.label; // Model adını option'ın metin içeriği olarak ayarla
                        modelSelect.appendChild(option);
                        
                        // Eğer bu model seçili model ise, seçili olarak işaretle
                        if (model.label === selectedModel) {
                            option.selected = true;
                        }
                    });
                }
            });
            
            // İlk yükleme veya edit modunda seçili marka ve modeli ayarla
            brandSelect.value = selectedBrand;
            brandSelect.dispatchEvent(new Event('change')); // Model seçeneklerini güncelle
            modelSelect.value = selectedModel;
        })
        .catch(error => console.error('Error loading JSON data:', error));
    });
    
    function addKmPackage() {
        const container = document.getElementById('km-packages-container');
        const packages = container.getElementsByClassName('km-package');
        const newIndex = packages.length;
        
        const newPackage = document.createElement('div');
        newPackage.classList.add('row', 'gy-2', 'mb-2', 'km-package');
        newPackage.setAttribute('data-index', newIndex);
        newPackage.innerHTML = `
        <div class="col-xl-6">
            <div class="input-group has-validation">
                <input required name="kilometers[${newIndex}][kilometer]" type="number" class="form-control" placeholder="{{trans_dynamic('kilometer')}}">
                <span class="input-group-text" id="inputGroupPrepend">Km</span>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="input-group has-validation">
                <input required name="kilometers[${newIndex}][price]" type="number" class="form-control" placeholder="{{trans_dynamic('price')}}">
                <span class="input-group-text" id="inputGroupPrepend">€</span>
            </div>
        </div>
    `;
        container.appendChild(newPackage);
    }
    
    function addInsurancePackage() {
        const container = document.getElementById('insurance-packages-container');
        const packages = container.getElementsByClassName('insurance-package');
        const newIndex = packages.length;
        
        const newPackage = document.createElement('div');
        newPackage.classList.add('row', 'gy-2', 'mb-2', 'insurance-package');
        newPackage.setAttribute('data-index', newIndex);
        newPackage.innerHTML = `
        <div class="col-xl-6">
            <div class="input-group has-validation">
                <input required name="insurance_packages[${newIndex}][deductible]" type="number" class="form-control" placeholder="{{trans_dynamic('deductible')}}">
                <span class="input-group-text" id="inputGroupPrepend">€ Selbstbeteiligung</span>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="input-group has-validation">
                <input required name="insurance_packages[${newIndex}][price_per_day]" type="number" class="form-control" placeholder="{{trans_dynamic('price')}}">
                <span class="input-group-text" id="inputGroupPrepend">€/day</span>
            </div>
        </div>
    `;
        container.appendChild(newPackage);
    }
    
</script>
<script>
    function addImages() {
        const container = document.getElementById('car-images-container');
        const carImages = document.querySelectorAll('.car-image');
        const newIndex = carImages.length;
        
        const newImages = document.createElement('div');
        newImages.classList.add('row', 'gy-2', 'mb-2', 'car-image');
        newImages.setAttribute('data-index', newIndex);
        newImages.innerHTML = `
<div class="col-xl-12">
    <label for="car-photo-${newIndex}" class="form-label">{{trans_dynamic('photo')}}</label>
<div class="input-group">
<input required name="images[]" type="file" class="form-control" id="car-photo-${newIndex}">
<label for="car-photo" style="padding: 6px;" class="btn btn-light bg-transparent" id="button-addon2"><i class="bx bx-camera fs-16 align-middle"></i></label>
</div>
</div>
`;
        container.appendChild(newImages);
    }
    
    function removeImage(index, imagePath) {
        // Görseli HTML'den silme işlemi
        const imageDiv = document.querySelector(`[data-index="${index}"]`);
        if (imageDiv && imageDiv.parentNode) {
            imageDiv.parentNode.removeChild(imageDiv);
        }
        
        // AJAX isteği ile görseli veritabanından silme işlemi
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/car/delete-image", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.setRequestHeader("X-CSRF-TOKEN", '{{ csrf_token() }}');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log('Image deleted successfully');
            }
        };
        xhr.send(JSON.stringify({
            image_path: imagePath,
            car_id: '{{ $car->id }}'
        }));
    }
</script>
<script>
    const damagesNested = {!! json_encode($damagesArray) !!};
    
    const damages = damagesNested.flat();
    
    const baseURL = window.location.origin;
    
    const defaultDamages = damages.map(damage => {
        return {
            coordinates: { x: `${damage.coordinates.x}`, y: `${damage.coordinates.y}` }, // Yüzdelik formatta
            description: damage.description,
            photo: damage.photo,
        };
    });
    
    let damageCounter = 0;
    const defaultDamageCount = defaultDamages.length;
    
    function loadDefaultDamages() {
        const carContainer = document.getElementById('car-container');
        const defaultDamagesList = document.getElementById('default-damages-list');
        
        defaultDamages.forEach((damage, index) => {
            // const damageMarker = document.createElement('div');
            // damageMarker.classList.add('damage-marker');
            // damageMarker.style.left = damage.coordinates.x;
            // damageMarker.style.top = damage.coordinates.y;
            // damageMarker.innerHTML = `X<span class="marker-number">${index + 1}</span>`;
            // carContainer.appendChild(damageMarker);
            const listItem = document.createElement('li');
            listItem.classList.add('list-group-item', 'example-damage', `damage-${index + 1}`);
            listItem.innerHTML = `
            <div class="d-flex align-items-center">
                <span class="avatar avatar-sm">
                    <img src="${baseURL}/${damage.photo}" alt="img" class="damage-photo">
                </span>
                <div class="ms-2 fw-semibold">
                    <div style="color: red;">X<span class="marker-number">${index + 1}</span></div>
                    <div class="damage-description">Description: ${damage.description}</div>
                    <input required type="hidden" name="old_description_${index + 1}" value="${damage.description}">
                    <input required type="hidden" name="old_image_${index + 1}" value="${damage.photo}">
                    <input required type="hidden" name="old_x_cordinate_${index + 1}" value="${damage.coordinates.x}">
                    <input required type="hidden" name="old_y_cordinate_${index + 1}" value="${damage.coordinates.y}">
                </div>
                <div class="ms-auto">
                    <a class="btn btn-sm btn-danger delete-damage" data-index="${index + 1}"><i class="bx bx-trash"></i></a>
                </div>
            </div>
        `;
            
            listItem.querySelector('.delete-damage').addEventListener('click', function() {
                // List item'ı kaldır
                const listItem = this.closest('.list-group-item');
                listItem.remove();
                
                // Marker'ları ve input isimlerini güncelle
                updateMarkerNumbers();
                updateInputNames();
            });
            // Silme butonu için olay dinleyici ekleyin
            
            function initializeDeleteButtons() {
                document.querySelectorAll('.delete-damage').forEach(button => {
                    button.addEventListener('click', function() {
                        const listItem = this.closest('.list-group-item');
                        listItem.remove(); // List item'ı kaldır
                        
                        // Marker'ları ve input isimlerini güncelle
                        updateMarkerNumbers();
                        updateInputNames();
                    });
                });
            }
            
            function updateMarkerNumbers() {
                const listItems = document.querySelectorAll('.list-group-item');
                listItems.forEach((item, index) => {
                    const markerNumberElement = item.querySelector('.marker-number');
                    if (markerNumberElement) {
                        markerNumberElement.textContent = index + 1; // Numara güncelle
                    }
                });
            }
            
            function updateInputNames() {
                const listItems = document.querySelectorAll('.list-group-item');
                listItems.forEach((item, index) => {
                    const markerNumber = index + 1;
                    const inputs = item.querySelectorAll('input[type="hidden"]');
                    inputs.forEach(input => {
                        // Input adlarını güncelle
                        let name = input.name;
                        let newName = name.replace(/\d+$/, markerNumber); // Son numarayı güncelle
                        input.name = newName; // Güncellenmiş ismi ayarla
                    });
                });
            }
            
            // Ensure that any existing delete buttons on page load are initialized
            initializeDeleteButtons();
            
            document.querySelector('.list-group').appendChild(listItem);
            
        });
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        loadDefaultDamages();
        
        document.querySelector('form').addEventListener('submit', (e) => {
            const damageForms = document.querySelectorAll('.form-group');
            const damages = [];
            
            damageForms.forEach((form, index) => {
                const description = form.querySelector(`textarea[name="damage-description-${index + 1}"]`).value;
                const x = form.querySelector(`input[name="x-coordinate-${index + 1}"]`).value;
                const y = form.querySelector(`input[name="y-coordinate-${index + 1}"]`).value;
                const photo = form.querySelector(`input[name="damage-photo-${index + 1}"]`).files[0];
                
                damages.push({ coordinates: { x, y }, description, photo: photo ? photo.name : null });
            });
            
            const damagesInput = document.createElement('input');
            damagesInput.type = 'hidden';
            damagesInput.name = 'damages';
            damagesInput.value = JSON.stringify(damages);
            e.target.appendChild(damagesInput);
        });
    });
    
    // Ensure the delete button is hidden on initial load
    document.getElementById('delete-last').style.display = 'none';
    
    document.getElementById('car').addEventListener('click', function(event) {
        const car = event.target;
        const rect = car.getBoundingClientRect();
        const x = ((event.clientX - rect.left) / rect.width) * 100;
        const y = ((event.clientY - rect.top) / rect.height) * 100;
        
        damageCounter++;
        
        const damageMarker = document.createElement('div');
        damageMarker.classList.add('damage-marker');
        damageMarker.style.left = `${x}%`;
        damageMarker.style.top = `${y}%`;
        damageMarker.innerHTML = `X<span class="marker-number">${defaultDamageCount + damageCounter}</span>`;
        damageMarker.id = `marker-${damageCounter}`;
        
        car.parentElement.appendChild(damageMarker);
        
        const formContainer = document.getElementById('damage-forms-container');
        const formGroup = document.createElement('div');
        formGroup.classList.add('form-group', 'mt-3');
        formGroup.id = `form-group-${damageCounter}`;
        
        const label = document.createElement('label');
        label.textContent = `Schaden  X${defaultDamageCount + damageCounter}`;
        formGroup.appendChild(label);
        
        const textarea = document.createElement('textarea');
        textarea.classList.add('form-control');
        textarea.name = `damage-description-${damageCounter}`;
        formGroup.appendChild(textarea);
        
        const inputX = document.createElement('input');
        inputX.type = 'hidden';
        inputX.name = `x-coordinate-${damageCounter}`;
        inputX.value = x;
        formGroup.appendChild(inputX);
        
        const inputY = document.createElement('input');
        inputY.type = 'hidden';
        inputY.name = `y-coordinate-${damageCounter}`;
        inputY.value = y;
        formGroup.appendChild(inputY);
        
        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.name = `damage-photo-${damageCounter}`;
        fileInput.classList.add('form-control', 'mt-2');
        formGroup.appendChild(fileInput);
        
        formContainer.appendChild(formGroup);
        
        // Show the delete button when a new damage is added
        document.getElementById('delete-last').style.display = 'block';
    });
    
    document.getElementById('delete-last').addEventListener('click', function() {
        if (damageCounter > 0) {
            document.getElementById(`marker-${damageCounter}`).remove();
            document.getElementById(`form-group-${damageCounter}`).remove();
            damageCounter--;
            
            // Hide the delete button if no more new damages are left
            if (damageCounter === 0) {
                document.getElementById('delete-last').style.display = 'none';
            }
        }
    });
</script>
@endsection