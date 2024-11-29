@extends('layouts.layout')
@section('title', 'New Car')
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
    <h4 class="fw-medium mb-0">{{trans_dynamic('car_add')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('cars')}}" class="text-white-50">{{trans_dynamic('cars')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('car_add')}}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->



<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container">
        
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
                        <form action="{{route('cars.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="tab-content mt-4 mt-lg-0">
                                <div class="tab-pane text-muted active show" id="car-info" role="tabpanel">
                                    <div class="p-3">
                                        <div class="row gy-4 mb-4">
                                            <div class="col-xl-12">
                                                <label for="km" class="form-label">{{trans_dynamic('odometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required required name="odometer" type="number" class="form-control @error('odometer') is-invalid @enderror" id="km" placeholder="{{trans_dynamic('odometer')}}">
                                                    <span class="input-group-text" id="inputGroupPrepend">Km</span>
                                                </div>
                                                @error('odometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            
                                            <div class="col-xl-12">
                                                <label for="group" class="form-label">{{trans_dynamic('group')}}</label>
                                                <select name="car_group" class="form-control" id="group">
                                                    <option>{{trans_dynamic('not_selected')}}</option>
                                                    @foreach($carGroups as $carGroup)
                                                    <option value="{{$carGroup->id}}" data-json='{{$carGroup->prices}}' data-km='{{$carGroup->kilometers}}'>{{$carGroup->name}}</option>
                                                    @endforeach
                                                </select>
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
                                                            document.getElementById('weekly-price').value = priceData.weekly_price;
                                                            document.getElementById('weekday-price').value = priceData.weekday_price;
                                                            document.getElementById('monthly-price').value = priceData.monthly_price;
                                                            document.getElementById('weekend-price').value = priceData.weekend_price;
                                                        } else {
                                                            document.getElementById('daily-price').value = '';
                                                            document.getElementById('extra-km-price').value = '';
                                                            document.getElementById('deposito').value = '';
                                                            document.getElementById('standard_exemption').value = '';
                                                            document.getElementById('weekly-price').value = '';
                                                            document.getElementById('weekday-price').value = '';
                                                            document.getElementById('monthly-price').value = '';
                                                            document.getElementById('weekend-price').value = '';
                                                        }
                                                        if (kilometers) {
                                                            var kmData = JSON.parse(kilometers);
                                                            document.getElementById('daily-km').value = kmData.daily_kilometer;
                                                            document.getElementById('weekly_kilometer').value = kmData.weekly_kilometer;
                                                            document.getElementById('weekday_kilometer').value = kmData.weekday_kilometer;
                                                            document.getElementById('monthly_kilometer').value = kmData.monthly_kilometer;
                                                            document.getElementById('weekend_kilometer').value = kmData.weekend_kilometer;
                                                        } else {
                                                            document.getElementById('daily-km').value = '';
                                                            document.getElementById('weekly_kilometer').value = '';
                                                            document.getElementById('weekday_kilometer').value = '';
                                                            document.getElementById('monthly_kilometer').value = '';
                                                            document.getElementById('weekend_kilometer').value = '';
                                                        }
                                                    });
                                                </script>
                                                @error('car_group')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            {{-- <div class="col-xl-6">
                                                <label for="additional-driver-price" class="form-label">Price for Additional Driver</label>
                                                <div class="input-group has-validation">
                                                    <input required required name="price_for_additional_driver" class="form-control" id="additional-driver-price" placeholder="Price for Additional Driver">
                                                    <span class="input-group-text" id="price_for_additional_driver">€</span>
                                                </div>
                                                @error('price_for_additional_driver')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div> --}}
                                            <div class="col-xl-12">
                                                <label for="extra-km-price" class="form-label">{{trans_dynamic('price_per_extra_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required required name="price_per_extra_kilometer" class="form-control" id="extra-km-price" placeholder="{{trans_dynamic('price_per_extra_kilometer')}}">
                                                    <span class="input-group-text" id="price_per_extra_kilometer">€</span>
                                                </div>
                                                @error('price_per_extra_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="deposito" class="form-label">{{trans_dynamic('deposito')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required required name="deposito" class="form-control" id="deposito" placeholder="{{trans_dynamic('deposito')}}">
                                                    <span class="input-group-text" id="deposito">€</span>
                                                </div>
                                                @error('deposito')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="standard_exemption" class="form-label">{{trans_dynamic('standart_insurance')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required required name="standard_exemption" class="form-control" id="standard_exemption" placeholder="{{trans_dynamic('standart_insurance')}}">
                                                    <span class="input-group-text" id="deposito">€</span>
                                                </div>
                                                @error('standard_exemption')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <div class="col-xl-6">
                                                <label for="daily-price" class="form-label">{{trans_dynamic('daily_price')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required required name="daily_price" class="form-control" id="daily-price" placeholder="{{trans_dynamic('daily_price')}}">
                                                    <span class="input-group-text" id="daily_price">€</span>
                                                </div>
                                                @error('daily_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="daily-km" class="form-label">{{trans_dynamic('daily_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required required name="daily_kilometer" type="number" class="form-control" id="daily-km" placeholder="{{trans_dynamic('daily_kilometer')}}">
                                                    <span class="input-group-text" id="inputGroupPrepend">Km</span>
                                                </div>
                                                @error('daily_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <div class="col-xl-6">
                                                <label for="weekly-price" class="form-label">{{trans_dynamic('weekly_price')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required required name="weekly_price" step="0.01" oninput="formatNumber(this)" class="form-control" id="weekly-price" placeholder="{{trans_dynamic('weekly_price')}}">
                                                    <span class="input-group-text" id="weekly_price">€</span>
                                                </div>
                                                @error('weekly_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="weekly_kilometer" class="form-label">{{trans_dynamic('weekly_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required required name="weekly_kilometer" type="number" class="form-control" id="weekly_kilometer" placeholder="{{trans_dynamic('weekly_kilometer')}}">
                                                    <span class="input-group-text" id="inputGroupPrepend">Km</span>
                                                </div>
                                                @error('weekly_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <div class="col-xl-6">
                                                <label for="weekday-price" class="form-label">{{trans_dynamic('weekday_price')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required required name="weekday_price" class="form-control" id="weekday-price" placeholder="{{trans_dynamic('weekday_price')}}">
                                                    <span class="input-group-text" id="weekday_price">€</span>
                                                </div>
                                                @error('weekday_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="weekday_kilometer" class="form-label">{{trans_dynamic('weekday_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required required name="weekday_kilometer" type="number" class="form-control" id="weekday_kilometer" placeholder="{{trans_dynamic('weekday_kilometer')}}">
                                                    <span class="input-group-text" id="inputGroupPrepend">Km</span>
                                                </div>
                                                @error('weekday_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <div class="col-xl-6">
                                                <label for="monthly-price" class="form-label">{{trans_dynamic('monthly_price')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required required name="monthly_price" class="form-control" id="monthly-price" placeholder="{{trans_dynamic('monthly_price')}}">
                                                    <span class="input-group-text" id="monthly_price">€</span>
                                                </div>
                                                @error('monthly_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="monthly_kilometer" class="form-label">{{trans_dynamic('monthly_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required required name="monthly_kilometer" type="number" class="form-control" id="monthly_kilometer" placeholder="{{trans_dynamic('monthly_kilometer')}}">
                                                    <span class="input-group-text" id="inputGroupPrepend">Km</span>
                                                </div>
                                                @error('monthly_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <div class="col-xl-6">
                                                <label for="weekend-price" class="form-label">{{trans_dynamic('weekend_price')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required required name="weekend_price" class="form-control" id="weekend-price" placeholder="{{trans_dynamic('weekend_price')}}">
                                                    <span class="input-group-text" id="weekend_price">€</span>
                                                </div>
                                                @error('weekend_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="weekend_kilometer" class="form-label">{{trans_dynamic('weekend_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required required name="weekend_kilometer" type="number" class="form-control" id="weekend_kilometer" placeholder="{{trans_dynamic('weekend_kilometer')}}">
                                                    <span class="input-group-text" id="inputGroupPrepend">Km</span>
                                                </div>
                                                @error('weekend_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <div class="col-xl-12">
                                                <label for="status" class="form-label">{{trans_dynamic('status')}}</label>
                                                <select name="status" class="form-control" id="status">
                                                    <option value="1">{{trans_dynamic('active')}}</option>
                                                    <option value="2">{{trans_dynamic('inactive')}}</option>
                                                </select>
                                                @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
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
                                                <select name="brand" class="form-control" id="brand"></select>
                                                @error('brand')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror 
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="model" class="form-label">{{trans_dynamic('model')}}</label>
                                                <select name="model" class="form-control" id="model"></select>
                                                @error('model')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror 
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="class" class="form-label">{{trans_dynamic('class')}}</label>
                                                <select name="class" class="form-control">
                                                    <option value="" selected>{{trans_dynamic('not_selected')}}</option>
                                                    <option value="SUV">SUV</option>
                                                    <option value="Kleinwagen">Kleinwagen</option>
                                                    <option value="Limousine">Limousine</option>
                                                    <option value="Kombi">Kombi</option>
                                                    <option value="Minivan">Minivan</option>
                                                    <option value="Coupé">Coupé</option>
                                                    <option value="Cabriolet">Cabriolet</option>
                                                </select>
                                                @error('class')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror 
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="class2" class="form-label">{{trans_dynamic('class')}} <small>(⁠Kleinwagen, Mittelklasse, Oberklasse )</small></label>
                                                <select name="class2" class="form-control">
                                                    <option value="" selected>{{trans_dynamic('not_selected')}}</option>
                                                    <option value="⁠Kleinwagen (A-Klasse)">⁠Kleinwagen (A-Klasse)</option>
                                                    <option value="Mittelklasse (B-Klasse)">Mittelklasse (B-Klasse)</option>
                                                    <option value="Oberklasse (C-Klasse)">Oberklasse (C-Klasse)</option>
                                                    <option value="SUV (Sport Utility Vehicle)">SUV (Sport Utility Vehicle)</option>
                                                    <option value="Coupé">Coupé</option>
                                                    <option value="Kombi">Kombi</option>
                                                    <option value="Van / MPV">Van / MPV</option>
                                                </select>
                                                @error('class2')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror 
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="number_of_doors" class="form-label">{{trans_dynamic('number_of_doors')}}</label>
                                                <input required required name="number_of_doors" type="text" class="form-control" id="number_of_doors" placeholder="{{trans_dynamic('number_of_doors')}}">
                                                @error('number_of_doors')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror 
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="horse_power" class="form-label">{{trans_dynamic('horse_power')}}</label>
                                                <input required required name="horse_power" type="text" class="form-control" id="horse_power" placeholder="{{trans_dynamic('horse_power')}}">
                                                @error('horse_power')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror 
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="fuel" class="form-label">{{trans_dynamic('fuel')}}</label>
                                                <select name="fuel" class="form-control" id="fuel">
                                                    <option value="Gasolina">Gasolina</option>
                                                    <option value="Diesel">Diesel</option>
                                                    <option value="Electric">Electric</option>
                                                </select>
                                                @error('fuel')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="color" class="form-label">{{trans_dynamic('color')}}</label>
                                                <input required required name="color" type="text" class="form-control" id="color" placeholder="Color">
                                                @error('color')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="vin" class="form-label">{{trans_dynamic('vin')}}</label>
                                                <input required required name="vin" type="text" class="form-control" id="vin" placeholder="{{trans_dynamic('vin')}}">
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
                                                    <option>18</option>
                                                    <option>19</option>
                                                    <option>20</option>
                                                    <option>21</option>
                                                    <option>22</option>
                                                    <option>23</option>
                                                    <option>24</option>
                                                    <option>25</option>
                                                    <option>26</option>
                                                    <option>27</option>
                                                    <option>28</option>
                                                    <option>29</option>
                                                    <option>30</option>
                                                </select>
                                                @error('min_age')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="tire_type" class="form-label">{{trans_dynamic('tire_type')}}:</label>
                                                <select name="tire_type" class="form-control" id="tire_type">
                                                    <option value="{{trans_dynamic('summary')}}">{{trans_dynamic('summary')}}</option>
                                                    <option value="{{trans_dynamic('winter')}}">{{trans_dynamic('winter')}}</option>
                                                    <option value="{{trans_dynamic('long_way')}}">{{trans_dynamic('long_way')}}</option>
                                                </select>
                                                @error('tire_type')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="date_to_traffic" class="form-label">{{trans_dynamic('opening_date_to_traffic')}}</label>
                                                <input required required name="traffic_date" type="date" class="form-control" id="date_to_traffic" placeholder="{{trans_dynamic('opening_date_to_traffic')}}">
                                                @error('traffic_date')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="tire_size" class="form-label">{{trans_dynamic('tire_size')}}:</label>
                                                <input required required name="tire_size" type="text" class="form-control" id="tire_size" placeholder="{{trans_dynamic('tire_size')}}">
                                                @error('tire_size')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="rim_size" class="form-label">{{trans_dynamic('rim_size')}}:</label>
                                                <input required required name="rim_size" type="text" class="form-control" id="rim_size" placeholder="{{trans_dynamic('rim_size')}}">
                                                @error('rim_size')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="key_number" class="form-label">{{trans_dynamic('key_number')}}:</label>
                                                <input required required name="key_number" type="text" class="form-control" id="key_number" placeholder="{{trans_dynamic('key_number')}}">
                                                @error('key_number')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="plate" class="form-label">{{trans_dynamic('number_plate')}}</label>
                                                <input required required name="number_plate" type="text" class="form-control" id="plate" placeholder="{{trans_dynamic('number_plate')}}">
                                                @error('number_plate')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-12">
                                                <label for="desc" class="form-label">{{trans_dynamic('description')}}</label>
                                                <textarea name="desc" id="desc" class="form-control" placeholder="{{trans_dynamic('description')}}"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mt-3">
                                            <a id="previus-tab1" data-bs-toggle="tab" role="tab" aria-current="page" href="#car-info" aria-selected="false" tabindex="-1" class="btn btn-secondary d-block align-items-center justify-content-between">{{trans_dynamic('previous')}}</a>
                                        </div>
                                        <div class="col-6 mt-3">
                                            <a id="next-tab3" data-bs-toggle="tab" role="tab" aria-current="page" href="#car_damages" aria-selected="false" tabindex="-1" class="btn btn-primary d-block align-items-center justify-content-between">{{trans_dynamic('next')}}</a>
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            var nextTab = document.getElementById('next-tab3');
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
                                                    alert("{{trans_dynamic('car_add_error')}}"); // Uyarı ver
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
                                                        <input required type="range" name="fuel_status" class="form-range" min="0" max="100" step="10" value="20"
                                                        id="customRange3" style="float: left; width: 80%;">
                                                        <p id="fuellevel">20%</p>
                                                    </div>
                                                    @error('fuel_status')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row col-xl-12">
                                                <div class="col-xl-7">
                                                    <div class="card custom-card">
                                                        <div class="card-header">
                                                            <div class="card-title">
                                                                {{trans_dynamic('damage_add')}}
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="container mt-5">
                                                                <div id="car-container" class="mb-3">
                                                                    <img id="car" src="{{asset('/assets/images/cars/damages/damages.jpg')}}" class="img-fluid" alt="Car Silhouette">
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
                                                                <button type="button" class="btn btn-primary" id="addDamageBtn">{{trans_dynamic('internal_damage_add')}}</button>
                                                            </div>
                                                            <div class="card-body" id="damagesContainer">
                                                                <!-- Damages will be added here -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <script>
                                                        let damageNumber = 0; // To keep track of how many inputs are added
                                                        
                                                        document.getElementById('addDamageBtn').addEventListener('click', function() {
                                                            damageNumber++;
                                                            
                                                            // Create a new div for the damage inputs
                                                            const damageDiv = document.createElement('div');
                                                            damageDiv.classList.add('damage-input-group', 'mb-3');
                                                            damageDiv.setAttribute('id', `damage-group-${damageNumber}`);
                                                            
                                                            // Create a text input for damage description
                                                            const textInput = document.createElement('input');
                                                            textInput.setAttribute('type', 'text');
                                                            textInput.setAttribute('name', `internal_damage_description_${damageNumber}`);
                                                            textInput.classList.add('form-control', 'mb-2');
                                                            textInput.setAttribute('placeholder', 'Describe the damage');
                                                            
                                                            // Create a file input for uploading damage images
                                                            const fileInput = document.createElement('input');
                                                            fileInput.setAttribute('type', 'file');
                                                            fileInput.setAttribute('name', `internal_damage_image_${damageNumber}`);
                                                            fileInput.classList.add('form-control');
                                                            
                                                            // Append the inputs to the damage div
                                                            damageDiv.appendChild(textInput);
                                                            damageDiv.appendChild(fileInput);
                                                            
                                                            // Append the damage div to the container
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
                                                                                name="options[triangle_reflector]" id="triangle_reflector_yes" value="yes" checked>
                                                                                <label class="form-check-label" for="triangle_reflector_yes">
                                                                                    {{trans_dynamic('yes')}}
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline ms-3">
                                                                                <input required class="form-check-input option-radio" type="radio" 
                                                                                name="options[triangle_reflector]" id="triangle_reflector_no" value="no">
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
                                                                                name="options[reflective_vest]" id="reflective_vest_yes" value="yes" checked>
                                                                                <label class="form-check-label" for="reflective_vest_yes">
                                                                                    {{trans_dynamic('yes')}}
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline ms-3">
                                                                                <input required class="form-check-input option-radio" type="radio" 
                                                                                name="options[reflective_vest]" id="reflective_vest_no" value="no">
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
                                                                                name="options[first_aid_kit]" id="first_aid_kit_yes" value="yes" checked>
                                                                                <label class="form-check-label" for="first_aid_kit_yes">
                                                                                    {{trans_dynamic('yes')}}
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline ms-3">
                                                                                <input required class="form-check-input option-radio" type="radio" 
                                                                                name="options[first_aid_kit]" id="first_aid_kit_no" value="no">
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
                                                                                name="options[clean]" id="clean_yes" value="yes" checked>
                                                                                <label class="form-check-label" for="clean_yes">
                                                                                    {{trans_dynamic('yes')}}
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline ms-3">
                                                                                <input required class="form-check-input option-radio" type="radio" 
                                                                                name="options[clean]" id="clean_no" value="no">
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
                                                                                name="options[tire_profile]" id="tire_profile" value="">
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
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mt-3">
                                            <a id="previus-tab2" data-bs-toggle="tab" role="tab" aria-current="page" href="#car-info" aria-selected="false" tabindex="-1" class="btn btn-secondary d-block align-items-center justify-content-between">{{trans_dynamic('previous')}}</a>
                                        </div>
                                        <div class="col-6 mt-3">
                                            <a id="next-tab4" data-bs-toggle="tab" role="tab" aria-current="page" href="#car-images" aria-selected="false" tabindex="-1" class="btn btn-primary d-block align-items-center justify-content-between">{{trans_dynamic('next')}}</a>
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            var nextTab = document.getElementById('next-tab4');
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
                                            <div class="row gy-2 mb-2">
                                                <div class="col-xl-12">
                                                    <label for="car-photo" class="form-label">{{trans_dynamic('main_photo')}}</label>
                                                    <div class="input-group">
                                                        <input required required name="images[]" type="file" class="form-control" id="car-photo" multiple>
                                                        <label for="car-photo" style="padding: 6px;" class="btn btn-light bg-transparent" id="button-addon2"><i class="bx bx-camera fs-16 align-middle"></i></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success mt-3" onclick="addIImagesInput()">{{trans_dynamic('add_another_images')}}</button>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mt-3">
                                            <a id="previus-tab3" data-bs-toggle="tab" role="tab" aria-current="page" href="#car_damages" aria-selected="false" tabindex="-1" class="btn btn-secondary d-block align-items-center justify-content-between">{{trans_dynamic('previous')}}</a>
                                        </div>
                                        <div class="col-6 mt-3">
                                            <button class="btn btn-primary w-100">{{trans_dynamic('create')}}</button>
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
    function formatNumber(input) {
        // Mevcut değeri alın
        let value = input.value;
        
        // Sadece sayılar ve virgül (,) içermesi için filtreleyin
        value = value.replace(/[^0-9,]/g, '');
        
        // Ondalık virgülünden sonra en fazla iki basamak olmasını sağlayın
        if (value.includes(',')) {
            let parts = value.split(',');
            // Virgülden sonra sadece iki basamak bırakın
            parts[1] = parts[1].slice(0, 2);
            value = parts.join(',');
        }
        
        // Ondalık virgülden önceki kısmı üçlü gruplar halinde ayırın
        let beforeComma = value.split(',')[0];
        beforeComma = beforeComma.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        
        // Değeri güncelleyin
        if (value.includes(',')) {
            let afterComma = value.split(',')[1];
            input.value = beforeComma + ',' + afterComma;
        } else {
            input.value = beforeComma;
        }
    }
    document.getElementById('image-upload').addEventListener('change', function(event) {
        displayImage(event.target.files[0]);
    });
    
    document.getElementById('camera-btn').addEventListener('click', function() {
        document.getElementById('camera-input').click();
    });
    
    document.getElementById('camera-input').addEventListener('change', function(event) {
        displayImage(event.target.files[0]);
    });
    
    function displayImage(file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const imgElement = document.createElement('img');
            imgElement.src = event.target.result;
            const previewContainer = document.getElementById('preview');
            previewContainer.innerHTML = ''; // Clear previous images
            previewContainer.appendChild(imgElement);
        };
        reader.readAsDataURL(file);
    }
</script>
<script>
    function addKmPackage() {
        const container = document.getElementById('km-packages-container');
        const packages = container.getElementsByClassName('km-package');
        const newIndex = packages.length + 1;
        
        const newPackage = document.createElement('div');
        newPackage.classList.add('row', 'gy-2', 'mb-2', 'km-package');
        newPackage.setAttribute('data-index', newIndex);
        newPackage.innerHTML = `
                    <div class="col-xl-6">
                        <div class="input-group has-validation">
                            <input required required name="kilometers_kilometer_${newIndex}" type="number" class="form-control" placeholder="{{trans_dynamic('kilometers')}}">
                            <span class="input-group-text" id="inputGroupPrepend">Km</span>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="input-group has-validation">
                            <input required required name="kilometers_price_${newIndex}" type="number" class="form-control" placeholder="{{trans_dynamic('price')}}">
                            <span class="input-group-text" id="inputGroupPrepend">€</span>
                        </div>
                    </div>
                `;
        container.appendChild(newPackage);
    }
    
    function addInsurancePackage() {
        const container = document.getElementById('insurance-packages-container');
        const packages = container.getElementsByClassName('insurance-package');
        const newIndex = packages.length + 1;
        
        const newPackage = document.createElement('div');
        newPackage.classList.add('row', 'gy-2', 'mb-2', 'insurance-package');
        newPackage.setAttribute('data-index', newIndex);
        newPackage.innerHTML = `
                <div class="col-xl-6">
                    <div class="input-group has-validation">
                        <input required required name="insurance_deductible_${newIndex}" type="number" class="form-control" placeholder="{{trans_dynamic('deductible')}}">
                        <span class="input-group-text" id="inputGroupPrepend">€ Selbstbeteiligung</span>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="input-group has-validation">
                        <input required required name="insurance_price_day_${newIndex}" type="number" class="form-control" placeholder="{{trans_dynamic('price_per_day')}}">
                        <span class="input-group-text" id="inputGroupPrepend">€/day</span>
                    </div>
                </div>
            `;
        container.appendChild(newPackage);
    }
    
    function addIImagesInput() {
        const container = document.getElementById('car-images-container');
        const packages = container.getElementsByClassName('car-image');
        const newIndex = packages.length + 1;
        
        const newPackage = document.createElement('div');
        newPackage.classList.add('row', 'gy-2', 'mb-2', 'car-image');
        newPackage.setAttribute('data-index', newIndex);
        newPackage.innerHTML = `
                    <div class="col-xl-12">
                        <label for="car-photo" class="form-label">{{trans_dynamic('photo')}}</label>
                        <div class="input-group">
                            <input required required name="images[]" type="file" class="form-control" id="car-photo" multiple>
                            <label for="car-photo" style="padding: 6px;" class="btn btn-light bg-transparent" id="button-addon2"><i class="bx bx-camera fs-16 align-middle"></i></label>
                        </div>
                    </div>
                `;
        container.appendChild(newPackage);
    }
    
    const defaultDamages = [];
    let damageCounter = 0;
    const defaultDamageCount = defaultDamages.length;
    
    function loadDefaultDamages() {
        const carContainer = document.getElementById('car-container');
        const defaultDamagesList = document.getElementById('default-damages-list');
        
        defaultDamages.forEach((damage, index) => {
            const damageMarker = document.createElement('div');
            damageMarker.classList.add('damage-marker');
            damageMarker.style.left = damage.coordinates.x;
            damageMarker.style.top = damage.coordinates.y;
            damageMarker.innerHTML = `X<span class="marker-number">${index + 1}</span>`;
            carContainer.appendChild(damageMarker);
            
            const listItem = document.createElement('li');
            listItem.classList.add('list-group-item', 'example-damage');
            listItem.innerHTML = `
                    <div class="d-flex align-items-center">
                        <span class="avatar avatar-sm">
                            <img src="${damage.photo}" alt="img">
                        </span>
                        <div class="ms-2 fw-semibold">
                            <div style="color: red;">X<span class="marker-number">${index + 1}</span></div>
                            <div>{{trans_dynamic('description')}}: ${damage.description}</div>
                        </div>
                    </div>
                `;
            defaultDamagesList.appendChild(listItem);
        });
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        loadDefaultDamages();
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