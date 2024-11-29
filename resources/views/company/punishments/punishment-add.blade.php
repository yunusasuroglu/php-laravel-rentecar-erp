@extends('layouts.layout')
@section('title', 'Punishment')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
</style>
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0"> {{trans_dynamic('punishment_add')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">{{auth()->user()->company->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page"> {{trans_dynamic('punishment_add')}}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            {{trans_dynamic('punishment_add')}}
                        </div>
                    </div>
                    <form action="{{route('punishment.store')}}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="form-text" class="form-label fs-14 text-dark">{{trans_dynamic('corporate')}} {{trans_dynamic('email')}}:</label>
                                <input name="email" type="email" class="form-control" id="form-text" placeholder="example@example.com">
                            </div>
                            <div class="mb-3">
                                <label for="form-password" class="form-label fs-14 text-dark">{{trans_dynamic('relevant')}} {{trans_dynamic('contract')}}:</label>
                                <select class="form-control choices" data-trigger name="contract_id" id="choices-single-default">
                                    <option value="">{{trans_dynamic('not_selected')}}</option>
                                    @foreach($contracts as $contract)
                                    @php
                                    if (is_string($contract->customer)) {
                                        $customerData = json_decode($contract->customer, true); // JSON string ise diziye çevir
                                    } else {
                                        // Zaten bir dizi ise, doğrudan kullan
                                        $customerData = $contract->customer;
                                    }
                                    @endphp
                                    <option value="{{$contract->id}}" >
                                        ID: {{$contract->id}} | {{trans_dynamic('customer')}}: {{$customerData['name']}} | {{trans_dynamic('start_date')}}: {{$contract->start_date}} | {{trans_dynamic('end_date')}}: {{$contract->end_date}} | {{trans_dynamic('pickup')}} {{trans_dynamic('date')}}: {{$contract->pickup_date}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="form-text" class="form-label fs-14 text-dark">{{trans_dynamic('punishment')}}:</label>
                                <input name="punishment" type="text" class="form-control" id="form-text" placeholder="{{trans_dynamic('punishment')}}">
                            </div>
                            <div class="mb-3">
                                <label for="form-text" class="form-label fs-14 text-dark">{{trans_dynamic('description')}}:</label>
                                <textarea name="description" class="form-control" rows="2"></textarea>
                            </div>
                            <!-- Sözleşme Bilgileri Gösterilecek Alan -->
                            <div class="row" id="contract-details" style="margin-top: 20px;">
                                <input type="hidden" name="car_id" value="">
                                <input type="hidden" name="customer_id" value="">
                                <input type="hidden" name="car" value="">
                                <input type="hidden" name="driver" value="">
                                <input type="hidden" name="start_date" value="">
                                <input type="hidden" name="end_date" value="">
                                <input type="hidden" name="pickup_date" value="">
                                <div class="col-xl-6">
                                    <h4 class="mb-3"><b>{{trans_dynamic('contract')}} {{trans_dynamic('detail')}}</b></h4>
                                    <p><b>{{trans_dynamic('contract')}} ID:</b> <span class="text-primary" id="contract-id"></span></p>
                                    <p><b>{{trans_dynamic('car')}} {{trans_dynamic('brand')}}:</b> <span class="text-primary" id="contract-car-brand"></span></p>
                                    <p><b>{{trans_dynamic('car')}} {{trans_dynamic('model')}}:</b> <span class="text-primary" id="contract-car-model"></span></p>
                                    <p><b>{{trans_dynamic('car')}} {{trans_dynamic('number_plate')}}:</b> <span class="text-primary" id="contract-car-plate"></span></p>
                                    <p><b>{{trans_dynamic('start_date')}}:</b> <span class="text-primary" id="contract-start-date"></span></p>
                                    <p><b>{{trans_dynamic('end_date')}}:</b> <span class="text-primary" id="contract-end-date"></span></p>
                                    <p><b>{{trans_dynamic('pickup')}} {{trans_dynamic('date')}}:</b> <span class="text-primary" id="contract-pickup-date"></span></p>
                                </div>
                                <div class="col-xl-6">
                                    <h4 class="mb-3"><b>{{trans_dynamic('driver')}} {{trans_dynamic('detail')}}</b></h4>
                                    <p><b>{{trans_dynamic('driver')}} {{trans_dynamic('name')}} & {{trans_dynamic('surname')}}:</b> <span class="text-primary" id="contract-customer-name"></span></p>
                                    <p><b>{{trans_dynamic('driver')}} {{trans_dynamic('phone')}}:</b> <span class="text-primary" id="contract-customer-phone"></span></p>
                                    <p><b>{{trans_dynamic('driver')}} {{trans_dynamic('email')}}:</b> <span class="text-primary" id="contract-customer-email"></span></p>
                                    <img id="contract-identity-front" style="max-width: 200px; max-height: 200px;  margin-bottom: 20px;"/>
                                    <img id="contract-identity-back" style="max-width: 200px; max-height: 200px;  margin-bottom: 20px;"/>
                                    <img id="contract-driving-front" style="max-width: 200px; max-height: 200px;  margin-bottom: 20px;"/>
                                    <img id="contract-driving-back" style="max-width: 200px; max-height: 200px; margin-bottom: 20px;"/>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">{{trans_dynamic('send')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Choices.js initialization
        const selectElement = document.getElementById('choices-single-default');
        
        if (selectElement) {
            const choices = new Choices(selectElement, {
                searchEnabled: true, // İsteğe bağlı arama özelliği
                allowHTML: true // HTML etiketlerine izin verir
            });
            
            // Contract details alanları
            const contractDetails = {
                id: document.getElementById('contract-id'),
                customerName: document.getElementById('contract-customer-name'),
                customerPhone: document.getElementById('contract-customer-phone'),
                customerEmail: document.getElementById('contract-customer-email'),
                identityFront: document.getElementById('contract-identity-front'),
                identityBack: document.getElementById('contract-identity-back'),
                drivingFront: document.getElementById('contract-driving-front'),
                drivingBack: document.getElementById('contract-driving-back'),
                carBrand: document.getElementById('contract-car-brand'),
                carModel: document.getElementById('contract-car-model'),
                carPlate: document.getElementById('contract-car-plate'),
                startDate: document.getElementById('contract-start-date'),
                endDate: document.getElementById('contract-end-date'),
                pickupDate: document.getElementById('contract-pickup-date')
            };
            
            // Gizli inputları güncellemek için referanslar
            const hiddenInputs = {
                carId: document.querySelector('input[name="car_id"]'),
                customerId: document.querySelector('input[name="customer_id"]'),
                car: document.querySelector('input[name="car"]'),
                driver: document.querySelector('input[name="driver"]'),
                startDateHidden: document.querySelector('input[name="start_date"]'),
                endDateHidden: document.querySelector('input[name="end_date"]'),
                pickupDateHidden: document.querySelector('input[name="pickup_date"]'),
            };
            
            // Seçim değiştiğinde sözleşme bilgilerini sunucudan çekecek event listener
            selectElement.addEventListener('change', function () {
                const contractId = selectElement.value; // Seçilen option'un value'su ID'yi verir
                
                if (contractId !== "") {
                    // AJAX ile sunucudan sözleşme bilgilerini çek
                    fetch(`/contracts/${contractId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Sunucudan gelen verilerle HTML içeriğini güncelle
                        contractDetails.id.textContent = data.id;
                        contractDetails.customerName.textContent = data.customer.name + ' ' + data.customer.surname;
                        contractDetails.customerPhone.textContent = data.customer.phone;
                        contractDetails.customerEmail.textContent = data.customer.email;
                        contractDetails.identityFront.src = `/${data.customer.identity_front}`;
                        contractDetails.identityBack.src = `/${data.customer.identity_back}`;
                        contractDetails.drivingFront.src = `/${data.customer.driving_front}`;
                        contractDetails.drivingBack.src = `/${data.customer.driving_back}`;
                        contractDetails.carBrand.textContent = data.car.brand;
                        contractDetails.carModel.textContent = data.car.model;
                        contractDetails.carPlate.textContent = data.car.plate;
                        contractDetails.startDate.textContent = data.start_date;
                        contractDetails.endDate.textContent = data.end_date;
                        contractDetails.pickupDate.textContent = data.pickup_date || data.end_date;
                        
                        // Gizli inputlara değer atama
                        hiddenInputs.carId.value = data.car.id; // Araba ID'si
                        hiddenInputs.customerId.value = data.customer.id; // Müşteri ID'si
                        hiddenInputs.car.value = `${data.car.brand} ${data.car.model} ${data.car.plate}`; // Araba bilgisi
                        hiddenInputs.driver.value = `${data.customer.name} ${data.customer.surname}`; // Şoför bilgisi
                        hiddenInputs.startDateHidden.value = data.start_date;
                        hiddenInputs.endDateHidden.value = data.end_date;
                        hiddenInputs.pickupDateHidden.value = data.pickup_date;
                    })
                    .catch(error => {
                        console.error('Error fetching contract details:', error);
                    });
                } else {
                    // Eğer placeholder seçilirse, bilgileri boşalt
                    contractDetails.id.textContent = '';
                    contractDetails.customerName.textContent = '';
                    contractDetails.customerPhone.textContent = '';
                    contractDetails.customerEmail.textContent = '';
                    contractDetails.identityFront.src = '';
                    contractDetails.identityBack.src = '';
                    contractDetails.drivingFront.src = '';
                    contractDetails.drivingBack.src = '';
                    contractDetails.carBrand.textContent = '';
                    contractDetails.carModel.textContent = '';
                    contractDetails.carPlate.textContent = '';
                    contractDetails.startDate.textContent = '';
                    contractDetails.endDate.textContent = '';
                    contractDetails.pickupDate.textContent = '';
                    
                    // Gizli inputları temizle
                    hiddenInputs.carId.value = '';
                    hiddenInputs.customerId.value = '';
                    hiddenInputs.car.value = '';
                    hiddenInputs.driver.value = '';
                }
            });
        } else {
            console.error('Select element not found!');
        }
    });
</script>
@endsection