@extends('layouts.layout')
@section('title', 'New Contract')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
    #payment-message {
        color: rgb(105, 115, 134);
        font-size: 16px;
        line-height: 20px;
        padding-top: 12px;
        text-align: center;
    }
    
    #payment-element {
        margin-bottom: 24px;
    }
    
    /* Buttons and links */
    .buttonstripe {
        font-family: Arial, sans-serif;
        color: #ffffff;
        border-radius: 4px;
        border: 0;
        padding: 12px 16px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        display: block;
        transition: all 0.2s ease;
        box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
        width: 100%;
    }
    button:hover {
        filter: contrast(115%);
    }
    button:disabled {
        opacity: 0.5;
        cursor: default;
    }
    
    /* spinner/processing state, errors */
    .spinner,
    .spinner:before,
    .spinner:after {
        border-radius: 50%;
    }
    .spinner {
        color: #ffffff;
        font-size: 22px;
        text-indent: -99999px;
        margin: 0px auto;
        position: relative;
        width: 20px;
        height: 20px;
        box-shadow: inset 0 0 0 2px;
        -webkit-transform: translateZ(0);
        -ms-transform: translateZ(0);
        transform: translateZ(0);
    }
    .spinner:before,
    .spinner:after {
        position: absolute;
        content: "";
    }
    .spinner:before {
        width: 10.4px;
        height: 20.4px;
        border-radius: 20.4px 0 0 20.4px;
        top: -0.2px;
        left: -0.2px;
        -webkit-transform-origin: 10.4px 10.2px;
        transform-origin: 10.4px 10.2px;
        -webkit-animation: loading 2s infinite ease 1.5s;
        animation: loading 2s infinite ease 1.5s;
    }
    .spinner:after {
        width: 10.4px;
        height: 10.2px;
        border-radius: 0 10.2px 10.2px 0;
        top: -0.1px;
        left: 10.2px;
        -webkit-transform-origin: 0px 10.2px;
        transform-origin: 0px 10.2px;
        -webkit-animation: loading 2s infinite ease;
        animation: loading 2s infinite ease;
    }
    
    @-webkit-keyframes loading {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @keyframes loading {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    
    @media only screen and (max-width: 600px) {
        form {
            width: 80vw;
            min-width: initial;
        }
    }
</style>
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">{{trans_dynamic('add_contract')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('contracts')}}" class="text-white-50">{{trans_dynamic('contracts')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('add_contract')}}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- End::app-content -->

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        
        
        <div class="container">
            <!-- Start::row-1 -->
            <div class="row">
                <div class="col-xl-9">
                    
                    <div class="card custom-card">
                        <div class="card-body p-0 product-checkout">
                            <nav class="nav nav-tabs flex-column nav-style-5" role="tablist">
                                <div class="row p-3">
                                    @php
                                    $step = $contractData['step'] ?? '';
                                    @endphp
                                    @if ($step == 1)
                                    <div class="col-3">
                                        <a class="nav-link disabled" data-bs-toggle="tab" role="tab" aria-current="page" href="#order-tab-pane" aria-selected="true">
                                            <i class="bx bx-user me-2 fs-18 align-middle"></i>{{trans_dynamic('general_information')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page" href="#confirm-tab-pane" aria-selected="true">
                                            <i class="bx bx-user me-2 fs-18 align-middle"></i>{{trans_dynamic('kilometers')}}/{{trans_dynamic('insurance')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" data-bs-toggle="tab" role="tab" aria-current="page" href="#shipped-tab-pane" aria-selected="true">
                                            <i class="bx bx-user me-2 fs-18 align-middle"></i>{{trans_dynamic('payment')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" data-bs-toggle="tab" role="tab" aria-current="page" href="#delivery-tab-pane" aria-selected="false" tabindex="-1">
                                            <i class="bx bx-id-card me-2 fs-18 align-middle"></i>{{trans_dynamic('confirmation')}}
                                        </a>
                                    </div>
                                    @elseif ($step == 2)
                                    <div class="col-3">
                                        <a class="nav-link disabled" data-bs-toggle="tab" role="tab" aria-current="page" href="#order-tab-pane" aria-selected="true">
                                            <i class="bx bx-user me-2 fs-18 align-middle"></i>{{trans_dynamic('general_information')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" data-bs-toggle="tab" role="tab" aria-current="page" href="#confirm-tab-pane" aria-selected="true">
                                            <i class="bx bx-user me-2 fs-18 align-middle"></i>{{trans_dynamic('kilometers')}}/{{trans_dynamic('insurance')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page" href="#shipped-tab-pane" aria-selected="true">
                                            <i class="bx bx-user me-2 fs-18 align-middle"></i>{{trans_dynamic('payment')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" data-bs-toggle="tab" role="tab" aria-current="page" href="#delivery-tab-pane" aria-selected="false" tabindex="-1">
                                            <i class="bx bx-id-card me-2 fs-18 align-middle"></i>{{trans_dynamic('confirmation')}}
                                        </a>
                                    </div>
                                    @elseif ($step == 3)
                                    <div class="col-3">
                                        <a class="nav-link disabled" data-bs-toggle="tab" role="tab" aria-current="page" href="#order-tab-pane" aria-selected="true">
                                            <i class="bx bx-user me-2 fs-18 align-middle"></i>{{trans_dynamic('general_information')}}
                                        </a>
                                    </div>
                                    <div class="col-3 dis">
                                        <a class="nav-link disabled" data-bs-toggle="tab" role="tab" aria-current="page" href="#confirm-tab-pane" aria-selected="true">
                                            <i class="bx bx-user me-2 fs-18 align-middle"></i>{{trans_dynamic('kilometers')}}/{{trans_dynamic('insurance')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" data-bs-toggle="tab" role="tab" aria-current="page" href="#shipped-tab-pane" aria-selected="true">
                                            <i class="bx bx-user me-2 fs-18 align-middle"></i>{{trans_dynamic('payment')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page" href="#delivery-tab-pane" aria-selected="false" tabindex="-1">
                                            <i class="bx bx-id-card me-2 fs-18 align-middle"></i>{{trans_dynamic('confirmation')}}
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-3">
                                        <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page" href="#order-tab-pane" aria-selected="true">
                                            <i class="bx bx-user me-2 fs-18 align-middle"></i>{{trans_dynamic('general_information')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" data-bs-toggle="tab" role="tab" aria-current="page" href="#confirm-tab-pane" aria-selected="true">
                                            <i class="bx bx-user me-2 fs-18 align-middle"></i>{{trans_dynamic('kilometers')}}/{{trans_dynamic('insurance')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" data-bs-toggle="tab" role="tab" aria-current="page" href="#shipped-tab-pane" aria-selected="true">
                                            <i class="bx bx-user me-2 fs-18 align-middle"></i>{{trans_dynamic('payment')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" data-bs-toggle="tab" role="tab" aria-current="page" href="#delivery-tab-pane" aria-selected="false" tabindex="-1">
                                            <i class="bx bx-id-card me-2 fs-18 align-middle"></i>{{trans_dynamic('confirmation')}}
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </nav>
                            <div class="tab-content" id="myTabContent">
                                @if ($step == 1)
                                <div class="tab-pane fade border-0 p-0 show active" id="confirm-tab-pane" role="tabpanel" aria-labelledby="confirm-tab-pane" tabindex="0">
                                    <form action="{{ route('contracts.store.step2') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="step" value="2">
                                        <div class="p-4">
                                            <div class="fs-15 fw-semibold d-sm-flex d-block align-items-center justify-content-between mb-3">
                                                <div>{{trans_dynamic('kilometers')}}/{{trans_dynamic('insurance')}}:</div>
                                            </div>
                                            <div class="row gy-4 mb-4">
                                                <div class="col-xl-12">
                                                    <label class="form-label" for="km_packages_group">{{trans_dynamic("extra_kilometer_package")}}:</label>
                                                    <select class="form-control form-select" name="km_packages_group" id="km_packages_group" data-selected="{{ $contractData['km_packages']['kilometers'] ?? '' }}">
                                                        <option value="">{{trans_dynamic("selected_package")}}</option>
                                                        {{-- <option value="">Enter The Mileage Yourself</option> --}}
                                                        @foreach($kmPackages as $package)
                                                        @php
                                                        $kilometers = isset($package['kilometers']) ? (float)$package['kilometers'] : 0;
                                                        $extraPrice = isset($package['extra_price']) ? (float)$package['extra_price'] : 0;
                                                        $totalExtraPrice = $kilometers * $extraPrice;
                                                        @endphp
                                                        <option value="{{ $package['kilometers'] }}" data-package='@json($package)'>
                                                            {{ $kilometers }} km - {{ $totalExtraPrice }} | € 1KM = {{ $extraPrice }} €
                                                        </option>
                                                        @endforeach
                                                        <option id="enter_km_package" value="enter_yourself">{{trans_dynamic("enter_yourself")}}</option>
                                                    </select>
                                                    
                                                    <div id="km-packages-container" style="display: none;" class="mt-3">
                                                        <div class="row gy-2 mb-2">
                                                            <div class="col-xl-6">
                                                                <div class="input-group has-validation">
                                                                    <input id="inputKilometers" name="kilometers_kilometer" type="number" class="form-control" placeholder="Kilometers">
                                                                    <span class="input-group-text" id="inputGroupPrepend">Km</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="input-group has-validation">
                                                                    <input id="inputExtraPrice" name="kilometers_extra_price" class="form-control" placeholder="Extra Kilometer Price">
                                                                    <span class="input-group-text" id="inputGroupPrepend">€</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <label class="form-label" for="insurance_packages_group">{{trans_dynamic("extra_insurance_package")}}:</label>
                                                    <select class="form-control form-select" name="insurance_packages_group" id="insurance_packages_group" data-selected="{{ $contractData['insurance_packages']['deductible'] ?? '' }}">
                                                        <option value="">{{trans_dynamic("selected_package")}}</option>
                                                        @foreach($insurancePackages as $package)
                                                        <option value="{{ $package['deductible'] }}" data-package='@json($package)'>
                                                            {{trans_dynamic("deductible")}}: {{ $package['deductible'] }} € - {{trans_dynamic("price_per_day")}}: {{ $package['price_per_day'] }} €
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                // Kilometer Package Select
                                                var kmSelect = document.getElementById('km_packages_group');
                                                var selectedKmValue = kmSelect.getAttribute('data-selected');
                                                
                                                if (selectedKmValue) {
                                                    // Tüm seçenekleri döngüye alıp, seçili olanı buluyoruz
                                                    for (var i = 0; i < kmSelect.options.length; i++) {
                                                        if (kmSelect.options[i].value === selectedKmValue) {
                                                            kmSelect.options[i].selected = true;
                                                            break;
                                                        }
                                                    }
                                                }
                                                
                                                // Insurance Package Select
                                                var insuranceSelect = document.getElementById('insurance_packages_group');
                                                var selectedInsuranceValue = insuranceSelect.getAttribute('data-selected');
                                                
                                                if (selectedInsuranceValue) {
                                                    // Tüm seçenekleri döngüye alıp, seçili olanı buluyoruz
                                                    for (var i = 0; i < insuranceSelect.options.length; i++) {
                                                        if (insuranceSelect.options[i].value === selectedInsuranceValue) {
                                                            insuranceSelect.options[i].selected = true;
                                                            break;
                                                        }
                                                    }
                                                }
                                            });
                                        </script>
                                        <input type="hidden" name="selected_km_package" id="selected_km_package" value="{{ json_encode($contractData['km_packages'] ?? []) }}">
                                        <input type="hidden" name="selected_insurance_package" id="selected_insurance_package" value="{{ json_encode($contractData['insurance_packages'] ?? []) }}">
                                        <input type="hidden" name="tax" id="hidden_tax" value="{{$contractData['tax'] ?? '0'}}">
                                        <input type="hidden" name="totalprice" id="hidden_totalprice" value="{{$contractData['totalprice'] ?? '0'}}">
                                        <input type="hidden" name="subtotalprice" id="hiddenSubTotalPrice" value="{{$contractData['subtotalprice'] ?? '0'}}">
                                        <script>
                                            const defaultContractData = @json($contractData);
                                        </script>
                                        <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-between btn-list">
                                            <a class="btn btn-danger-light d-inline-flex" onclick="document.getElementById('backStep1Form').submit();">
                                                <i class="ri-truck-line me-2 align-middle"></i>{{trans_dynamic('backto')}} {{trans_dynamic('general_information')}}
                                            </a>
                                            <button type="submit" class="btn btn-success d-inline-flex">
                                                {{trans_dynamic('continueto')}} {{trans_dynamic('payment')}}<i class="bi bi-credit-card-2-front align-middle ms-2"></i>
                                            </button>
                                        </div>
                                    </form>
                                    <form action="{{ route('contracts.store.back.step1') }}" method="POST" id="backStep1Form">
                                        @csrf
                                        <input type="hidden" name="step" value="0">
                                    </form>
                                </div>
                                @elseif ($step == 2)
                                <div class="tab-pane fade border-0 p-0 show active" id="shipped-tab-pane" role="tabpanel" aria-labelledby="shipped-tab-pane" tabindex="0">
                                    <div class="p-4">
                                        <p class="mb-1 fw-semibold text-muted op-5 fs-20">03</p>
                                        <div class="fs-15 fw-semibold d-sm-flex d-block align-items-center justify-content-between mb-3">
                                            <div>{{trans_dynamic('payment')}} {{trans_dynamic('detail')}} :</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="card-body">
                                                    <div class="btn-group mb-3 d-sm-flex d-block" role="group" aria-label="Basic radio toggle button group">
                                                        <input type="radio" class="btn-check" value="Cash" name="payment" id="btnradio1" checked>
                                                        <label class="btn btn-outline-light text-default" for="btnradio1">{{trans_dynamic('cash')}}</label>
                                                        
                                                        <input type="radio" class="btn-check" value="Credit Card" name="payment" id="btnradio2">
                                                        <label class="btn btn-outline-light text-default mt-sm-0 mt-1" for="btnradio2">{{trans_dynamic('creditcard')}}</label>
                                                        
                                                        <input type="radio" class="btn-check" value="Invoice" name="payment" id="btnradio3">
                                                        <label class="btn btn-outline-light text-default mt-sm-0 mt-1" for="btnradio3">{{trans_dynamic('invoice')}}</label>
                                                    </div>
                                                    <div id="payment_cash">
                                                        <form action="{{route('contracts.store.step3')}}" method="POST" id="goStep1">
                                                            @csrf
                                                            <div class="row gy-3">
                                                                <div class="col-xl-12">
                                                                    <label for="payment-card-number" class="form-label">{{trans_dynamic('amount')}} ({{trans_dynamic('today')}})</label>
                                                                    @if (isset($contractData['remaining_amount']))
                                                                    <input type="text" name="amount_paid" class="form-control" id="" placeholder="{{trans_dynamic('pay')}} {{trans_dynamic('today')}}" value="{{$contractData['remaining_amount'] ?? '0.00'}}">
                                                                    @else
                                                                    <input type="text" name="amount_paid" class="form-control" id="" placeholder="{{trans_dynamic('pay')}} {{trans_dynamic('today')}}" value="{{$contractData['totalprice'] ?? '0.00'}}">
                                                                    @endif
                                                                    <input type="hidden" value="Cash" name="payment">
                                                                </div>
                                                                <div class="col-xl-12">
                                                                    <label for="payment-card-number" class="form-label">{{trans_dynamic('deposit')}}</label>
                                                                    <input type="text" readonly name="deposit" class="form-control" id="" placeholder="{{trans_dynamic('deposit')}}" value="{{$contractData['deposito'] ?? '0'}}">
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="step" value="3">
                                                        </form>
                                                    </div>
                                                    <div id="payment_credit">
                                                        <div class="row gy-3">
                                                            
                                                        </div>
                                                    </div>
                                                    <div id="payment_invoice" class="payment-section" style="display: none;">
                                                        <div class="row gy-3">
                                                            <form action="{{route('contracts.store.step3')}}" method="POST" id="goStep2">
                                                                @csrf
                                                                <input type="hidden" value="Invoice" name="payment">
                                                                <div class="row gy-3">
                                                                    <div class="col-xl-12">
                                                                        <label for="payment-card-number" class="form-label">{{trans_dynamic('deposit')}}</label>
                                                                        <input type="text" readonly name="deposit" class="form-control" id="" placeholder="{{trans_dynamic('deposit')}}" value="{{$contractData['deposito'] ?? '0'}}">
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="step" value="3">
                                                            </form>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="payment_paypal" class="payment-section" style="display: none;">
                                                        <div class="row gy-3">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        const paymentOptions = document.querySelectorAll('input[name="payment"]');
                                                        const paymentSections = {
                                                            'Cash': document.getElementById('payment_cash'),
                                                            'Credit Card': document.getElementById('payment_credit'),
                                                            'Invoice': document.getElementById('payment_invoice'),
                                                            'Paypal': document.getElementById('payment_paypal')
                                                        };
                                                        
                                                        // Show/Hide Sections based on selected radio button
                                                        function togglePaymentSections() {
                                                            const selectedOption = document.querySelector('input[name="payment"]:checked').value;
                                                            Object.keys(paymentSections).forEach(section => {
                                                                paymentSections[section].style.display = section === selectedOption ? 'block' : 'none';
                                                            });
                                                        }
                                                        
                                                        // Initially display the correct section
                                                        togglePaymentSections();
                                                        
                                                        // Add event listeners to all payment options
                                                        paymentOptions.forEach(option => {
                                                            option.addEventListener('change', togglePaymentSections);
                                                        });
                                                    });
                                                    
                                                    function submitSelectedForm() {
                                                        const selectedPaymentMethod = document.querySelector('input[name="payment"]:checked').value;
                                                        let formId;
                                                        
                                                        switch(selectedPaymentMethod) {
                                                            case 'Cash':
                                                            formId = 'goStep1';
                                                            break;
                                                            case 'Credit Card':
                                                            formId = 'payment-form';
                                                            break;
                                                            case 'Invoice':
                                                            formId = 'goStep2';
                                                            break;
                                                            case 'Paypal':
                                                            alert('Paypal seçildi, ancak bu ödeme yöntemi henüz uygulanmadı.');
                                                            return;
                                                            default:
                                                            console.error('Bilinmeyen ödeme yöntemi.');
                                                            return;
                                                        }
                                                        
                                                        if (formId) {
                                                            document.getElementById(formId).submit();
                                                        }
                                                    }
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-between">
                                        <a class="btn btn-danger-light d-inline-flex" onclick="document.getElementById('backStep2Form').submit();">
                                            <i class="ri-user-3-line me-2 align-middle"></i>
                                            {{trans_dynamic("backto")}} {{trans_dynamic('kilometers')}}/{{trans_dynamic('insurance')}}
                                        </a>
                                        <a onclick="submitSelectedForm();" class="btn btn-success mt-sm-0 mt-2">{{trans_dynamic("continueto")}} <i class="bi bi-credit-card-2-front align-middle ms-2"></i></a>
                                    </div>
                                    <form action="{{ route('contracts.store.back.step2') }}" method="POST" id="backStep2Form">
                                        @csrf
                                        <input type="hidden" name="step" value="1">
                                    </form>
                                </div>
                                @elseif ($step == 3)
                                <div class="tab-pane fade border-0 p-0 show active" id="delivery-tab-pane" role="tabpanel" aria-labelledby="delivery-tab-pane" tabindex="0">
                                    <form action="{{route('contracts.store.step4')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="step" value="4">
                                        <div class="p-5 checkout-payment-success my-3">
                                            <div class="mb-5">
                                                <h5 class="text-success fw-semibold">All informations listed here: </h5>
                                            </div>
                                            <div class="mb-4">
                                                <p class="mb-1 fs-14">You can check and deliver this contract with Id
                                                    <b>SPK#1FR</b> from <a class="link-success" href=""><u>here</u></a>
                                                </p>
                                                <p class="text-muted">Please open the page on your mobile phone or tablet.</p>
                                            </div>
                                            <button type="submit" class="btn btn-success">Save and prepare to deliver<i class="bi bi-cart ms-2"></i></button>
                                        </div>
                                    </form>
                                    <div class="p-4">
                                        <a class="btn btn-danger-light d-inline-flex" onclick="document.getElementById('backStep3Form').submit();">
                                            <i class=" ri-money-euro-box-fill me-2 align-middle"></i>
                                            {{trans_dynamic("backto")}} {{trans_dynamic("payment")}}
                                        </a>
                                        <form action="{{ route('contracts.store.back.step3') }}" method="POST" id="backStep3Form">
                                            @csrf
                                            <input type="hidden" name="step" value="2">
                                        </form>
                                    </div>
                                </div>
                                @else
                                <div class="tab-pane fade show active border-0 p-0" id="order-tab-pane" role="tabpanel" aria-labelledby="order-tab-pane" tabindex="0">
                                    <form action="{{route('contracts.store.step1')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="step" value="1">
                                        <input type="hidden" id="hiddenSubTotalPrice" value="{{$contractData['subtotalprice'] ?? '0'}}" name="subTotalPrice">
                                        <input type="hidden" id="hiddenDeposito" value="{{$contractData['deposito'] ?? '0'}}" name="deposito">
                                        <input type="hidden" id="hiddenTAX" value="{{$contractData['tax'] ?? '0'}}" name="tax">
                                        <input type="hidden" id="hiddenTotalPrice" value="{{$contractData['totalprice'] ?? '0'}}" name="totalPrice">
                                        <input type="hidden" id="hiddenStandardExemption" value="{{$contractData['car_details']['prices']['standard_exemption'] ?? '0'}}" name="standard_exemption">
                                        <div class="p-4">
                                            <p class="mb-1 fw-semibold text-muted op-5 fs-20">01</p>
                                            <div class="fs-15 fw-semibold d-sm-flex d-block align-items-center justify-content-between mb-3">
                                                <div>{{trans_dynamic('select_date')}}:</div>
                                            </div>
                                            <div class="row gy-4 mb-4">
                                                <div class="col-xl-6">
                                                    <div class="form-floating">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                                                <input value="{{ $contractData['start_date'] ?? '' }}" type="text" name="start_date" class="form-control start_date_contract" id="datetime" data-date-format="Y-m-d">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-floating">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                                                <input value="{{ $contractData['end_date'] ?? '' }}" type="text" name="end_date" class="form-control end_date_contract" id="datetime" data-date-format="Y-m-d">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fs-15 fw-semibold d-sm-flex d-block align-items-center justify-content-between mb-3">
                                                <div>{{trans_dynamic('select_car')}}:</div>
                                                <div class="mt-sm-0 mt-2"></div>
                                            </div>
                                            <div class="row gy-4 mb-4">
                                                <div class="col-xl-6">
                                                    <select class="form-control form-select" data-trigger name="car_group" id="car_group">
                                                        <option value="">{{trans_dynamic('select_group')}}</option>
                                                        @foreach($car_groups as $group)
                                                        <option value="{{ $group->id }}" {{ isset($contractData['car_group']) && $contractData['car_group'] == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-xl-6">
                                                    <select class="form-control form-select" data-trigger name="car" id="car">
                                                        <option>{{trans_dynamic('select_car')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <script>
                                            </script>
                                            <div id="availability_status" class="alert alert-info mt-2"></div>
                                            <div id="calendar"></div>
                                            
                                            <div class="fs-15 fw-semibold d-sm-flex d-block align-items-center justify-content-between mb-3">
                                                <div>{{trans_dynamic('select_customer')}}:</div>
                                            </div>
                                            <div class="row gy-4 mb-4">
                                                <div class="col-xl-12">
                                                    <select class="form-control choices" data-trigger name="customer" id="choices-single-default" onchange="handleCustomerChange()">
                                                        <option value="">{{trans_dynamic('not_selected')}}</option>
                                                        <option value="new_customer" {{ isset($contractData['customer']) && $contractData['customer'] == 'new_customer' ? 'selected' : '' }}>1 {{trans_dynamic('new_customer')}}</option>
                                                        @foreach ($customers as $customer)
                                                        <option value="{{$customer->id}}" {{ isset($contractData['customer']) && $contractData['customer'] == $customer->id ? 'selected' : '' }}>{{$customer->name}} {{$customer->surname}} | {{$customer->email}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div id="customer-add-container" style="display: none;">
                                                    <nav class="nav nav-tabs flex-column nav-style-5" role="tablist">
                                                        <div class="row p-3">
                                                            <div class="col-6">
                                                                <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page" href="#customer-info" aria-selected="true">
                                                                    <i class="bx bx-user me-2 fs-18 align-middle"></i>{{trans_dynamic('customer_information')}}
                                                                </a>
                                                            </div>
                                                            <div class="col-6">
                                                                <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page" href="#id-license-info" aria-selected="false" tabindex="-1">
                                                                    <i class="bx bx-id-card me-2 fs-18 align-middle"></i>{{trans_dynamic('id_driver_card')}}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </nav>
                                                    <div class="tab-content mt-4 mt-lg-0">
                                                        <div class="tab-pane text-muted active show" id="customer-info" role="tabpanel">
                                                            <div class="p-3">
                                                                <div class="row gy-4 mb-4">
                                                                    <div class="col-xl-12">
                                                                        <label for="cname" class="form-label">{{trans_dynamic('company')}} {{trans_dynamic('name')}}</label>
                                                                        <input type="text" name="company_name" class="form-control" id="cname" placeholder="Company name">
                                                                        <div class="invalid-feedback">
                                                                            Please enter the company name.
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <label for="name" class="form-label">{{trans_dynamic('name')}}*</label>
                                                                        <input type="text" name="name" class="form-control" id="name" placeholder="{{trans_dynamic('name')}}">
                                                                        <div class="invalid-feedback">
                                                                            Please enter the name.
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <label for="surname" class="form-label">{{trans_dynamic('surname')}}*</label>
                                                                        <input type="text" name="surname" class="form-control" id="surname" placeholder="{{trans_dynamic('surname')}}">
                                                                        <div class="invalid-feedback">
                                                                            Please enter the surname.
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <label for="phone" class="form-label">{{trans_dynamic('phone')}}</label>
                                                                        <input type="text" name="phone" class="form-control" id="phone" placeholder="{{trans_dynamic('phone')}}">
                                                                        <div class="invalid-feedback">
                                                                            Please enter the Phone.
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <label for="email" class="form-label">{{trans_dynamic('email')}}</label>
                                                                        <input type="email" name="email" class="form-control" id="email" placeholder="{{trans_dynamic('email')}}">
                                                                        <div class="invalid-feedback">
                                                                            Please enter the Email.
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <label for="street" class="form-label">{{trans_dynamic('street')}}*</label>
                                                                        <input type="text" name="street" class="form-control" id="street" placeholder="{{trans_dynamic('street')}}">
                                                                        <div class="invalid-feedback">
                                                                            Please enter the street.
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <label for="plz" class="form-label">{{trans_dynamic('zip_code')}}*</label>
                                                                        <input type="text" name="zip_code" class="form-control" id="plz" placeholder="{{trans_dynamic('zip_code')}}">
                                                                        <div class="invalid-feedback">
                                                                            Please enter the postal code.
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <label for="city" class="form-label">{{trans_dynamic('city')}}*</label>
                                                                        <input type="text" name="city" class="form-control" id="city" placeholder="{{trans_dynamic('city')}}">
                                                                        <div class="invalid-feedback">
                                                                            Please enter the city.
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <label for="country" class="form-label">{{trans_dynamic('country')}}*</label>
                                                                        <select name="country" class="form-control" id="country">
                                                                            <option selected value="Deutschland">Deutschland</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <label for="birthdate" class="form-label">{{trans_dynamic('date_of_birth')}}*</label>
                                                                        <input type="date" class="form-control" name="date_of_birth" id="birthdate" placeholder="Date of Birth">
                                                                        <div class="invalid-feedback">
                                                                            Please enter the date of birth.
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" name="invoice_address_active" type="checkbox" value="1" id="different-billing-address" onclick="toggleBillingAddress()">
                                                                            <label class="form-check-label" for="different-billing-address">
                                                                                {{trans_dynamic('different_billgin_address')}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div id="billing-address" class="d-none">
                                                                        <div class="row gy-4 mt-3">
                                                                            <div class="col-xl-12">
                                                                                <label for="billing-cname" class="form-label">{{trans_dynamic('company')}} {{trans_dynamic('name')}}</label>
                                                                                <input type="text" class="form-control" id="billing-cname" name="invoice_company_name" placeholder="{{trans_dynamic('company')}} {{trans_dynamic('name')}}">
                                                                            </div>
                                                                            <div class="col-xl-6">
                                                                                <label for="billing-name" class="form-label">{{trans_dynamic('name')}}*</label>
                                                                                <input type="text" class="form-control" name="invoice_name" id="billing-name" placeholder="{{trans_dynamic('name')}}">
                                                                            </div>
                                                                            <div class="col-xl-6">
                                                                                <label for="billing-surname" class="form-label">{{trans_dynamic('surname')}}*</label>
                                                                                <input type="text" name="invoice_surname" class="form-control" id="billing-surname" placeholder="{{trans_dynamic('surname')}}">
                                                                            </div>
                                                                            <div class="col-xl-6">
                                                                                <label for="billing-street" class="form-label">{{trans_dynamic('street')}}*</label>
                                                                                <input type="text" name="invoice_street" class="form-control" id="billing-street" placeholder="{{trans_dynamic('street')}}">
                                                                            </div>
                                                                            <div class="col-xl-6">
                                                                                <label for="billing-plz" class="form-label">{{trans_dynamic('zip_code')}}*</label>
                                                                                <input type="text" name="invoice_zip_code" class="form-control" id="billing-plz" placeholder="{{trans_dynamic('zip_code')}}">
                                                                            </div>
                                                                            <div class="col-xl-6">
                                                                                <label for="billing-city" class="form-label">{{trans_dynamic('city')}}*</label>
                                                                                <input type="text" name="invoice_city" class="form-control" id="billing-city" placeholder="{{trans_dynamic('city')}}">
                                                                            </div>
                                                                            <div class="col-xl-6">
                                                                                <label for="billing-country" class="form-label">{{trans_dynamic('country')}}*</label>
                                                                                <select class="form-control" name="invoice_country" id="billing-country">
                                                                                    <option selected value="Deutschland">Deutschland</option>
                                                                                </select>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 mt-3">
                                                                        <a id="next-tab" data-bs-toggle="tab" role="tab" aria-current="page" href="#id-license-info" aria-selected="false" tabindex="-1" class="btn btn-primary d-block align-items-center justify-content-between">{{trans_dynamic('next')}}</a>
                                                                    </div>
                                                                    <script>
                                                                        document.addEventListener('DOMContentLoaded', function () {
                                                                            var nextTab = document.getElementById('next-tab');
                                                                            nextTab.addEventListener('click', function (event) {
                                                                                event.preventDefault(); // Varsayılan davranışı engelle
                                                                                
                                                                                var nextTabId = 'id-license-info'; // Hedef sekmenin ID'sini belirtin
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
                                                        </div>
                                                        
                                                        <!-- ID/Driver's License Tab -->
                                                        <div class="tab-pane text-muted" id="id-license-info" role="tabpanel">
                                                            <div class="p-3">
                                                                <div class="row gy-4 mb-4">
                                                                    
                                                                    <div class="col-xl-6">
                                                                        <label for="id-front" class="form-label">{{trans_dynamic('id_card_front')}}</label>
                                                                        <input type="file" name="identity_front" class="form-control" id="id-front">
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <label for="id-back" class="form-label">{{trans_dynamic('id_card_back')}}</label>
                                                                        <input type="file" name="identity_back" class="form-control" id="id-back">
                                                                    </div>
                                                                    <div class="col-xl-6 mt-5">
                                                                        <label for="license-front" class="form-label">{{trans_dynamic('driver_card_front')}}</label>
                                                                        <input type="file" name="driver_licence_front" class="form-control" id="license-front">
                                                                    </div>
                                                                    <div class="col-xl-6 mt-5">
                                                                        <label for="license-back" class="form-label">{{trans_dynamic('driver_card_back')}}</label>
                                                                        <input type="file" name="driver_licence_back" class="form-control" id="license-back">
                                                                    </div>
                                                                    
                                                                    <div class="col-xl-6">
                                                                        <label for="id-expire-date" class="form-label">{{trans_dynamic('id_card_expiry')}}</label>
                                                                        <input type="date" name="identity_expiry_date" class="form-control" id="id-expire-date" placeholder="{{trans_dynamic('id_card_expiry')}}">
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <label for="license-expiry-date" class="form-label">{{trans_dynamic('driver_card_expiry')}}</label>
                                                                        <input type="date" name="driver_licence_expiry_date" class="form-control" id="license-expiry-date" placeholder="{{trans_dynamic('driver_card_expiry')}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function () {
                                                        const selectElement = document.getElementById('choices-single-default');
                                                        const choices = new Choices(selectElement, {
                                                            searchEnabled: true, // İsteğe bağlı olarak arama özelliğini kapatabilirsiniz
                                                            allowHTML: true // allowHTML seçeneğini true olarak ayarlayın
                                                        });
                                                        
                                                        selectElement.addEventListener('change', handleCustomerChange);
                                                    });
                                                    
                                                    function handleCustomerChange() {
                                                        const selectElement = document.getElementById('choices-single-default');
                                                        const selectedValue = selectElement.value;
                                                        const customerAddContainer = document.getElementById('customer-add-container');
                                                        
                                                        console.log('Selected Value:', selectedValue); // Debugging için ekleyin
                                                        
                                                        if (selectedValue === "new_customer") {
                                                            customerAddContainer.classList.remove('d-none');
                                                            customerAddContainer.classList.add('d-block');
                                                        } else {
                                                            customerAddContainer.classList.add('d-none');
                                                        }
                                                    }
                                                    
                                                    function toggleBillingAddress() {
                                                        const billingAddress = document.getElementById('billing-address');
                                                        billingAddress.classList.toggle('d-none');
                                                    }
                                                </script>
                                                <div class="col-xl-12">
                                                    
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-end">
                                            <button id="step_1_button" type="submit" class="btn btn-success d-inline-flex" >
                                                {{trans_dynamic('kilometers')}}/{{trans_dynamic('insurance')}}
                                                <i class="ri-user-3-line ms-2 align-middle"></i>
                                                <i style="place-self: center; margin-left:5px" class="bx bxs-arrow-from-left align-content-center"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title me-1">{{trans_dynamic('contract')}} {{trans_dynamic('detail')}}</div>
                        </div>
                        <div class="card-body p-0">
                            <div class="p-3 border-bottom border-block-end-dashed">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="fw-semibold fs-14">{{trans_dynamic("car")}}</div>
                                    <div class="fw-semibold fs-14">{{trans_dynamic("day")}}</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div id="carDetails" class="text-muted fs-15">{{$contractData['car_details']['car']['brand'] ?? ''}} {{$contractData['car_details']['car']['model'] ?? ''}} {{$contractData['car_details']['number_plate'] ?? ''}}</div>
                                    <div id="days" class="fw-semibold fs-15n ">{{$days}}</div>
                                </div>
                            </div>
                            <div class="p-3 border-bottom border-block-end-dashed">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="text-muted op-7">{{trans_dynamic("sub_total")}}</div>
                                    <div id="subTotalPrice" class="fw-semibold fs-14">{{$contractData['subtotalprice'] ?? '0'}}</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div id="km_package_kilometerss" class="text-muted op-7">{{trans_dynamic("kilometer_package")}} (+ {{$contractData['km_packages']['kilometers'] ?? '0'}} Km)</div>
                                    <div id="km_package_pricess" class="fw-semibold fs-14 text-danger">
                                        {{
                                            (floatval($contractData['km_packages']['extra_price'] ?? '0')) * 
                                            (floatval($contractData['km_packages']['kilometers'] ?? '0'))
                                        }} €
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div id="insurance_packagess" class="text-muted op-7">{{trans_dynamic("insurance_package")}} ({{$contractData['insurance_packages']['deductible'] ?? '0' }} € SB)</div>
                                    <div id="insurance_package_price" class="fw-semibold fs-14 text-danger">{{ ($days * (float)($contractData['insurance_packages']['price_per_day'] ?? 0)) }} €</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="text-muted op-7">{{trans_dynamic("standart_exemption")}} ( <span id="standardExemption">{{$contractData['car_details']['prices']['standard_exemption'] ?? '0' }}</span> € SB )</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="text-muted op-7">{{trans_dynamic("tax")}} (19%)</div>
                                    <div id="tax" class="fw-semibold fs-14">{{$contractData['tax'] ?? '0'}} €</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="text-muted op-7">{{trans_dynamic("paid")}}</div>
                                    <div class="fw-semibold fs-14">{{$contractData['amount_paid'] ?? '0'}} €</div>
                                </div>
                            </div>
                            <div class="p-2 m-2 bg-success-transparent">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="fs-15">{{trans_dynamic("total")}}:</div>
                                    @if (isset($contractData['remaining_amount']))
                                    <div id="totalPrice" class="fw-semibold fs-16 text-success">{{$contractData['remaining_amount'] ?? '0'}} €</div>
                                    @else
                                    <div id="totalPrice" class="fw-semibold fs-16 text-success">{{$contractData['totalprice'] ?? '0'}} €</div>
                                    @endif
                                </div>
                            </div>
                            <div class="p-2 m-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="fs-15">{{trans_dynamic("deposit")}}</div>
                                    <div id="deposito" class="fw-semibold fs-14">{{$contractData['deposito'] ?? '0'}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End::row-1 -->
        </div>
        
    </div>
</div>
<!-- End::app-content -->
<script src="{{asset('/')}}assets/js/choices.js"></script>
<script>
    var initialCarId = "{{ $contractData['car'] ?? '' }}";
</script>
@endsection
