@extends('layouts.layout')

@section('title', 'Car Group Add')
@section('content')
<div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
    <h4 class="fw-medium mb-0">{{trans_dynamic('car_group_add')}}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">{{trans_dynamic('car_groups')}}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('car_group_add')}}</li>
    </ol>
</div>

<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start:: row-6 -->
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-lg-3">
                        <nav class="nav nav-tabs flex-column nav-style-5" role="tablist">
                            <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page" href="#car-info" aria-selected="true">
                                <i class="bx bx-car me-2 fs-18 align-middle"></i>{{trans_dynamic('car_groups')}} {{trans_dynamic('info')}}
                            </a>
                            <a class="nav-link mt-3" data-bs-toggle="tab" role="tab" aria-current="page" href="#km-packages" aria-selected="false" tabindex="-1">
                                <i class="bx bx-plus me-2 fs-18 align-middle"></i>{{trans_dynamic('kilometer_packages')}}
                            </a>
                            <a class="nav-link mt-3" data-bs-toggle="tab" role="tab" aria-current="page" href="#insurance-packages" aria-selected="false" tabindex="-1">
                                <i class="bx bx-shield-quarter me-2 fs-18 align-middle"></i>{{trans_dynamic('insurance_packages')}}
                            </a>
                        </nav>
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <form action="{{ route('cars.group.store') }}" method="POST">
                            @csrf
                            <div class="tab-content mt-4 mt-lg-0">
                                <div class="tab-pane text-muted active show" id="car-info" role="tabpanel">
                                    <div class="p-3">
                                        <div class="row gy-4 mb-4">
                                            <div class="col-md-12">
                                                <label class="form-label">{{trans_dynamic('group')}} {{trans_dynamic('name')}}:</label>
                                                <input type="text" name="name" class="form-control" placeholder="{{trans_dynamic('name')}}" aria-label="{{trans_dynamic('name')}}">
                                                @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            {{-- <div class="col-xl-6 mt-3">
                                                <label for="additional-driver-price" class="form-label">Price for Additional Driver</label>
                                                <div class="input-group has-validation">
                                                    <input required name="price_for_additional_driver" class="form-control" id="additional-driver-price" placeholder="Price for Additional Driver">
                                                    <span class="input-group-text" id="price_for_additional_driver">€</span>
                                                </div>
                                                @error('price_for_additional_driver')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div> --}}
                                            <div class="col-xl-12 mt-3">
                                                <label for="deposito" class="form-label">{{trans_dynamic('deposito')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required name="deposito" class="form-control" id="deposito" placeholder="{{trans_dynamic('deposito')}}">
                                                    <span class="input-group-text" id="deposito">€</span>
                                                </div>
                                                @error('deposito')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6 mt-3">
                                                <label for="standard_exemption" class="form-label">{{trans_dynamic('standart_insurance')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required name="standard_exemption" class="form-control" id="standard_exemption" placeholder="{{trans_dynamic('standart_insurance')}}">
                                                    <span class="input-group-text" id="deposito">€</span>
                                                </div>
                                                @error('standard_exemption')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6 mt-3">
                                                <label for="extra-km-price" class="form-label">{{trans_dynamic('price_per_extra_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required name="price_per_extra_kilometer" class="form-control" id="extra-km-price" placeholder="{{trans_dynamic('price_per_extra_kilometer')}}">
                                                    <span class="input-group-text" id="price_per_extra_kilometer">€</span>
                                                </div>
                                                @error('price_per_extra_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <div class="col-xl-6 mt-3">
                                                <label for="daily-price" class="form-label">{{trans_dynamic('daily_price')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required name="daily_price" class="form-control" id="daily-price" placeholder="{{trans_dynamic('daily_price')}}">
                                                    <span class="input-group-text" id="daily_price">€</span>
                                                </div>
                                                @error('daily_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-xl-6 mt-3">
                                                <label for="daily_kilometer" class="form-label">{{trans_dynamic('daily_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required name="daily_kilometer" type="number" class="form-control" id="daily_kilometer" placeholder="{{trans_dynamic('daily_kilometer')}}">
                                                    <span class="input-group-text" id="daily_kilometer">KM</span>
                                                </div>
                                                @error('daily_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <div class="col-xl-6 mt-3">
                                                <label for="weekly_price" class="form-label">{{trans_dynamic('weekly_price')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required name="weekly_price" type="number" class="form-control" step="0.01" oninput="formatNumber(this)" id="weekly_price" placeholder="{{trans_dynamic('weekly_price')}}">
                                                    <span class="input-group-text" id="weekly_price">€</span>
                                                </div>
                                                @error('weekly_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6 mt-3">
                                                <label for="weekly_kilometer" class="form-label">{{trans_dynamic('weekly_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required name="weekly_kilometer" type="number" class="form-control" id="weekly_kilometer" placeholder="{{trans_dynamic('weekly_kilometer')}}">
                                                    <span class="input-group-text" id="weekly_kilometer">€</span>
                                                </div>
                                                @error('weekly_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <div class="col-xl-6">
                                                <label for="weekday-price" class="form-label">{{trans_dynamic('weekday_price')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required name="weekday_price" type="number" class="form-control" step="0.01" oninput="formatNumber(this)" id="weekday-price" placeholder="{{trans_dynamic('weekday_price')}}">
                                                    <span class="input-group-text" id="weekday_price">€</span>
                                                </div>
                                                @error('weekday_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="weekday_kilometer" class="form-label">{{trans_dynamic('weekday_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required name="weekday_kilometer" type="number" class="form-control" id="weekday_kilometer" placeholder="{{trans_dynamic('weekday_kilometer')}}">
                                                    <span class="input-group-text" id="inputGroupPrepend">Km</span>
                                                </div>
                                                @error('weekday_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <div class="col-xl-6 mt-3">
                                                <label for="monthly_price" class="form-label">{{trans_dynamic('monthly_price')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required name="monthly_price" type="number" class="form-control" step="0.01" oninput="formatNumber(this)" id="monthly_price" placeholder="{{trans_dynamic('monthly_price')}}">
                                                    <span class="input-group-text" id="monthly_price">€</span>
                                                </div>
                                                @error('monthly_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6 mt-3">
                                                <label for="monthly_kilometer" class="form-label">{{trans_dynamic('monthly_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required name="monthly_kilometer" type="number" class="form-control" id="monthly_kilometer" placeholder="{{trans_dynamic('monthly_kilometer')}}">
                                                    <span class="input-group-text" id="monthly_kilometer">€</span>
                                                </div>
                                                @error('monthly_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <div class="col-xl-6 mt-3">
                                                <label for="weekend_price" class="form-label">{{trans_dynamic('weekend_price')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required name="weekend_price" type="number" class="form-control" step="0.01" oninput="formatNumber(this)" id="weekend_price" placeholder="{{trans_dynamic('weekend_price')}}">
                                                    <span class="input-group-text" id="weekend_price">€</span>
                                                </div>
                                                @error('weekend_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-xl-6 mt-3">
                                                <label for="weekend_kilometer" class="form-label">{{trans_dynamic('weekend_kilometer')}}</label>
                                                <div class="input-group has-validation">
                                                    <input required name="weekend_kilometer" type="number" class="form-control" id="weekend_kilometer" placeholder="{{trans_dynamic('weekend_kilometer')}}">
                                                    <span class="input-group-text" id="weekend_kilometer">KM</span>
                                                </div>
                                                @error('weekend_kilometer')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12 mt-3">
                                                <a id="next-tab" data-bs-toggle="tab" role="tab" aria-current="page" href="#km-packages" aria-selected="false" tabindex="-1" class="btn btn-primary d-block align-items-center justify-content-between">{{trans_dynamic('next')}}</a>
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
                                                    var nextTabId = 'km-packages'; // Hedef sekmenin ID'sini belirtin
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
                                <div class="tab-pane text-muted" id="km-packages" role="tabpanel">
                                    <div class="p-3">
                                        <div id="km-packages-container">
                                            <div class="row gy-2 mb-2">
                                                <div class="col-xl-6">
                                                    <div class="input-group has-validation">
                                                        <input required name="kilometers_kilometer" type="number" class="form-control" placeholder="{{trans_dynamic('kilometer')}}">
                                                        <span class="input-group-text" id="inputGroupPrepend">Km</span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="input-group has-validation">
                                                        <input required name="kilometers_extra_price" class="form-control" placeholder="{{trans_dynamic('extra')}} {{trans_dynamic('kilometer')}} {{trans_dynamic('price')}}">
                                                        <span class="input-group-text" id="inputGroupPrepend">€</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success mt-3" onclick="addKmPackage()"><i class="bx bx-plus"></i> {{trans_dynamic('add_another_kilometer_packages')}}</button>
                                        <div class="row">
                                            <div class="col-6 mt-3">
                                                <a id="previus-tab1" data-bs-toggle="tab" role="tab" aria-current="page" href="#car-info" aria-selected="false" tabindex="-1" class="btn btn-secondary d-block align-items-center justify-content-between">{{trans_dynamic('previous')}}</a>
                                            </div>
                                            <div class="col-6 mt-3">
                                                <a id="next-tab3" data-bs-toggle="tab" role="tab" aria-current="page" href="#insurance-packages" aria-selected="false" tabindex="-1" class="btn btn-primary d-block align-items-center justify-content-between">{{trans_dynamic('next')}}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            var nextTab = document.getElementById('next-tab3');
                                            var prevTab = document.getElementById('previus-tab1');
                                            var prevTab2 = document.getElementById('previus-tab2');
                                            nextTab.addEventListener('click', function (event) {
                                                event.preventDefault(); // Varsayılan davranışı engelle
                                                
                                                // Sadece $car-info div'inin içerisindeki required inputları seç
                                                var carInfoSection = document.getElementById('km-packages');
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
                                                var nextTabId = 'insurance-packages'; // Hedef sekmenin ID'sini belirtin
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
                                            
                                            prevTab2.addEventListener('click', function (event) {
                                                event.preventDefault(); // Varsayılan davranışı engelle
                                                
                                                var nextTabId = 'km-packages'; // Hedef sekmenin ID'sini belirtin
                                                var nextTabElement = document.querySelector(`a[href="#${nextTabId}"]`);
                                                
                                                if (nextTabElement) {
                                                    var tab = new bootstrap.Tab(nextTabElement);
                                                    tab.show();
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                                <div class="tab-pane text-muted" id="insurance-packages" role="tabpanel">
                                    <div class="p-3">
                                        <div id="insurance-packages-container">
                                            <div class="row gy-2 mb-2">
                                                <div class="col-xl-6">
                                                    <div class="input-group has-validation">
                                                        <input required name="insurance_deductible" type="number" class="form-control" placeholder="{{trans_dynamic('deductible')}}">
                                                        <span class="input-group-text" id="inputGroupPrepend">€ {{trans_dynamic('deductible')}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="input-group has-validation">
                                                        <input required name="insurance_price_day" class="form-control" placeholder="Price">
                                                        <span class="input-group-text" id="inputGroupPrepend">€/{{trans_dynamic('day')}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success mt-3" onclick="addInsurancePackage()">{{trans_dynamic('add_another_insurance_packages')}}</button>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mt-3">
                                            <a id="previus-tab2" data-bs-toggle="tab" role="tab" aria-current="page" href="#km-packages" aria-selected="false" tabindex="-1" class="btn btn-secondary d-block align-items-center justify-content-between">{{trans_dynamic('previous')}}</a>
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
        <!-- End:: row-6 -->
        
    </div>
</div>

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
                            <input required name="kilometers_kilometer_${newIndex}" type="number" class="form-control" placeholder="{{trans_dynamic('kilometer')}}">
                            <span class="input-group-text" id="inputGroupPrepend">Km</span>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="input-group has-validation">
                            <input required name="kilometers_extra_price_${newIndex}" class="form-control" placeholder="{{trans_dynamic('extra')}} {{trans_dynamic('kilometer')}} {{trans_dynamic('price')}}">
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
                        <input required name="insurance_deductible_${newIndex}" type="number" class="form-control" placeholder="{{trans_dynamic('deductible')}}">
                        <span class="input-group-text" id="inputGroupPrepend">€ Selbstbeteiligung</span>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="input-group has-validation">
                        <input required name="insurance_price_day_${newIndex}" type="number" class="form-control" placeholder="{{trans_dynamic('price')}}">
                        <span class="input-group-text" id="inputGroupPrepend">€/day</span>
                    </div>
                </div>
            `;
        container.appendChild(newPackage);
    }
</script>
@endsection