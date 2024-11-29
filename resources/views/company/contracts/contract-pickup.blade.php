@extends('layouts.layout')
@section('title', 'Pickup Contract')
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
    #fuellevels {
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
    .car-container {
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
    <h4 class="fw-medium mb-0">{{trans_dynamic('pickup')}} {{trans_dynamic('contract')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('contracts')}}" class="text-white-50">{{trans_dynamic('contracts')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('pickup')}} {{trans_dynamic('contract')}}</li>
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
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body p-0 product-checkout">
                            <nav class="nav nav-tabs flex-column nav-style-5" role="tablist">
                                <div class="row p-3">
                                    @php
                                    $contractId = $contract->id; // Sözleşme ID'sini alın
                                    $contractData = session('contractData', []); // Tüm sözleşme verilerini oturumdan alın
                                    @endphp
                                    <div class="col-3">
                                        <a class="nav-link active" id="order-tab" data-bs-toggle="tab" data-bs-target="#order-tab-pane" type="button" role="tab" aria-controls="order-tab" aria-selected="true">
                                            <i class="ri-truck-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('general_information')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#cardetails" type="button" role="tab" aria-controls="confirmed-tab" aria-selected="false">
                                            <i class="bx bx-car me-2 align-middle d-inline-block"></i>{{trans_dynamic('car')}} {{trans_dynamic('detail')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirm-tab-pane" type="button" role="tab" aria-controls="confirmed-tab" aria-selected="false">
                                            <i class="ri-user-3-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('id_and_driver_card')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivery-tab-pane" type="button" role="tab" aria-controls="delivered-tab" aria-selected="false">
                                            <i class="ri-checkbox-circle-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('signature')}} & {{trans_dynamic('confirmation')}}
                                        </a> 
                                    </div>
                                </div>
                            </nav>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade border-0 p-0" id="cardetails" role="tabpanel" aria-labelledby="cardetails" tabindex="0">
                                    <div class="p-4">
                                        <p class="mb-1 fw-semibold text-muted op-5 fs-20">02</p>
                                        <div class="fs-15 fw-semibold d-sm-flex d-block align-items-center justify-content-between mb-3">
                                            <div>{{trans_dynamic('car')}} {{trans_dynamic('detail')}}:</div>
                                        </div>
                                        <div class="row gy-4 mb-4">
                                            <!-- here all informations -->
                                            <div class="col-xl-12">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="card custom-card">
                                                            <div class="card-header">
                                                                <div class="card-title">
                                                                    {{trans_dynamic('fuel_level')}}
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <input disabled type="range" class="form-range" min="0" max="100" step="10" value="{{$carDetails['fuel_status']}}" id="customRange4" style="float: left; width: 80%;">
                                                                <p id="fuellevels">{{$carDetails['fuel_status']}}%</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row col-xl-12">
                                                        <div class="col-xl-7">
                                                            <div class="card custom-card">
                                                                <div class="card-header">
                                                                    <div class="card-title">
                                                                        {{trans_dynamic('damages')}}
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="container mt-5">
                                                                        <div class="car-container" class="mb-3">
                                                                            <img src="{{ asset('/assets/images/cars/damages/damages.jpg') }}" class="img-fluid" alt="Car Silhouette">
                                                                            
                                                                            @php
                                                                            $oldDamagesArray = json_decode(json_encode($oldDamagesArray), true);
                                                                            $markerIndex = 1; // Başlangıç indeksi
                                                                            @endphp
                                                                            
                                                                            @foreach ($oldDamagesArray as $damage)
                                                                            <div class="damage-marker"
                                                                            style="left: {{ $damage['coordinates']['x'] }}%; top: {{ $damage['coordinates']['y'] }}%;">
                                                                            X<span class="marker-number">{{ $markerIndex }}</span>
                                                                        </div>
                                                                        
                                                                        @php
                                                                        $markerIndex++; // Her hasar için indeksi artır
                                                                        @endphp
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card custom-card">
                                                                <div class="card-header d-flex justify-content-between align-items-center">
                                                                    <div class="card-title">
                                                                        {{trans_dynamic('internal_damages')}}
                                                                    </div>
                                                                </div>
                                                                <div class="card-body" >
                                                                    @php
                                                                    $damageCount = 0;
                                                                    @endphp
                                                                    
                                                                    @foreach($oldInternalDamagesArray as $damage)
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
                                                                                <img src="{{ asset($damage['image']) }}" alt="Damage Image" style="width: 60px; height:60px;">
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                                        <ul class="list-group">
                                                                            @foreach ($oldDamagesArray as $index => $damage)
                                                                            <li class="list-group-item example-damage">
                                                                                <div class="d-flex align-items-center">
                                                                                    <span class="avatar avatar-sm">
                                                                                        <img src="{{ $damage['photo'] ? asset($damage['photo']) : asset('/assets/images/media/media-22.jpg') }}" alt="damage" class="damage-photo">
                                                                                    </span>
                                                                                    <div class="ms-2 fw-semibold">
                                                                                        <div style="color: red;">X<span class="marker-number">{{ $index + 1 }}</span></div>
                                                                                        <div class="damage-description">{{trans_dynamic('description')}}: {{ $damage['description'] }}</div>
                                                                                        <input type="hidden" name="old_description_{{ $index + 1 }}" value="{{ $damage['description'] }}">
                                                                                        <input type="hidden" name="old_image_{{ $index + 1 }}" value="{{ $damage['photo'] }}">
                                                                                        <input type="hidden" name="old_x_cordinate_{{ $index + 1 }}" value="{{ $damage['coordinates']['x'] }}">
                                                                                        <input type="hidden" name="old_y_cordinate_{{ $index + 1 }}" value="{{ $damage['coordinates']['y'] }}">
                                                                                    </div>
                                                                                </div>
                                                                            </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-12">
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
                                                                                        <input disabled class="form-check-input option-radio" type="radio" 
                                                                                        name="options[triangle_reflector]" id="triangle_reflector_yes" value="yes" 
                                                                                        {{ isset($deliverOptions['triangle_reflector']) && $deliverOptions['triangle_reflector'] == 'yes' ? 'checked' : '' }}>
                                                                                        <label class="form-check-label" for="triangle_reflector_yes">
                                                                                            {{trans_dynamic('yes')}}
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline ms-3">
                                                                                        <input disabled class="form-check-input option-radio" type="radio" 
                                                                                        name="options[triangle_reflector]" id="triangle_reflector_no" value="no" 
                                                                                        {{ isset($deliverOptions['triangle_reflector']) && $deliverOptions['triangle_reflector'] == 'no' ? 'checked' : '' }}>
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
                                                                                        <input disabled class="form-check-input option-radio" type="radio" 
                                                                                        name="options[reflective_vest]" id="reflective_vest_yes" value="yes" 
                                                                                        {{ isset($deliverOptions['reflective_vest']) && $deliverOptions['reflective_vest'] == 'yes' ? 'checked' : '' }}>
                                                                                        <label class="form-check-label" for="reflective_vest_yes">
                                                                                            {{trans_dynamic('yes')}}
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline ms-3">
                                                                                        <input disabled class="form-check-input option-radio" type="radio" 
                                                                                        name="options[reflective_vest]" id="reflective_vest_no" value="no" 
                                                                                        {{ isset($deliverOptions['reflective_vest']) && $deliverOptions['reflective_vest'] == 'no' ? 'checked' : '' }}>
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
                                                                                        <input disabled class="form-check-input option-radio" type="radio" 
                                                                                        name="options[first_aid_kit]" id="first_aid_kit_yes" value="yes" 
                                                                                        {{ isset($deliverOptions['first_aid_kit']) && $deliverOptions['first_aid_kit'] == 'yes' ? 'checked' : '' }}>
                                                                                        <label class="form-check-label" for="first_aid_kit_yes">
                                                                                            {{trans_dynamic('yes')}}
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline ms-3">
                                                                                        <input disabled class="form-check-input option-radio" type="radio" 
                                                                                        name="options[first_aid_kit]" id="first_aid_kit_no" value="no" 
                                                                                        {{ isset($deliverOptions['first_aid_kit']) && $deliverOptions['first_aid_kit'] == 'no' ? 'checked' : '' }}>
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
                                                                                        <input disabled class="form-check-input option-radio" type="radio" 
                                                                                        name="options[clean]" id="clean_yes" value="yes" 
                                                                                        {{ isset($deliverOptions['clean']) && $deliverOptions['clean'] == 'yes' ? 'checked' : '' }}>
                                                                                        <label class="form-check-label" for="clean_yes">
                                                                                            {{trans_dynamic('yes')}}
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline ms-3">
                                                                                        <input disabled class="form-check-input option-radio" type="radio" 
                                                                                        name="options[clean]" id="clean_no" value="no" 
                                                                                        {{ isset($deliverOptions['clean']) && $deliverOptions['clean'] == 'no' ? 'checked' : '' }}>
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
                                                                                <div class="col-xl-6">
                                                                                    <div class="input-group has-validation">
                                                                                        @php
                                                                                        $tireProfileValue = isset($deliverOptions['tire_profile']) ? $deliverOptions['tire_profile'] : '';
                                                                                        // Eğer değer bir dizi ise, virgüllerle ayrılmış bir string haline getirin
                                                                                        if (is_array($tireProfileValue)) {
                                                                                            $tireProfileValue = implode(', ', $tireProfileValue);
                                                                                        }
                                                                                        @endphp
                                                                                        
                                                                                        <input disabled name="tire_profile" class="form-control"  value="{{ htmlspecialchars($tireProfileValue, ENT_QUOTES, 'UTF-8') }}" id="tire_profile" placeholder="Tire Profile">
                                                                                        <span class="input-group-text" id="tire_profile">MM</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade border-0 p-0" id="confirm-tab-pane" role="tabpanel" aria-labelledby="confirm-tab-pane" tabindex="0">
                                <div class="p-4">
                                    <p class="mb-1 fw-semibold text-muted op-5 fs-20">03</p>
                                    <div class="fs-15 fw-semibold d-sm-flex d-block align-items-center justify-content-between mb-3">
                                        <div>{{trans_dynamic('id_and_driver_card')}}:</div>
                                    </div>
                                    @php
                                    $identity = json_decode($customer->identity, true);
                                    $drivingLicence = json_decode($customer->driving_licence, true);
                                    $identityFront = $identity['front'] ?? '/assets/images/media/media-22.jpg';
                                    $identityBack = $identity['back'] ?? '/assets/images/media/media-22.jpg';
                                    $drivingLicenceFront = $drivingLicence['front'] ?? '/assets/images/media/media-22.jpg';
                                    $drivingLicenceBack = $drivingLicence['back'] ?? '/assets/images/media/media-22.jpg';
                                    @endphp
                                    <div class="row gy-4 mb-4">                                            
                                        <div class="col-xxl-3 col-xl-12">
                                            <div class="card custom-card">
                                                <a aria-label="anchor" href="javascript:void(0);" class="card-anchor"></a>
                                                <img src="{{asset('/'. $identity['front'])}}" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h6 class="card-title fw-semibold mb-0" style="text-align:center;">{{trans_dynamic('id_card_front')}} </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-xl-12">
                                            <div class="card custom-card">
                                                <a aria-label="anchor" href="javascript:void(0);" class="card-anchor"></a>
                                                <img src="{{asset('/'. $identity['back'] ?? '/assets/images/media/media-22.jpg')}}" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h6 class="card-title fw-semibold mb-0" style="text-align:center;">{{trans_dynamic('id_card_back')}} </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-xl-12">
                                            <div class="card custom-card">
                                                <a aria-label="anchor" href="javascript:void(0);" class="card-anchor"></a>
                                                <img src="{{asset('/'. $drivingLicence['front'])}}" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h6 class="card-title fw-semibold mb-0" style="text-align:center;">{{trans_dynamic('driver_card_front')}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-xl-12">
                                            <div class="card custom-card">
                                                <a aria-label="anchor" href="javascript:void(0);" class="card-anchor"></a>
                                                <img src="{{asset('/'. $drivingLicence['back'])}}" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h6 class="card-title fw-semibold mb-0" style="text-align:center;">{{trans_dynamic('driver_card_back')}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade border-0 p-0" id="delivery-tab-pane" role="tabpanel"varia-labelledby="delivery-tab-pane" tabindex="0">
                                <div class="p-4">
                                    <div class="fs-15 fw-semibold d-sm-flex d-block align-items-center justify-content-between mb-3">
                                        <div>{{trans_dynamic('signature')}} & {{trans_dynamic('confirmation')}}</div>
                                    </div>
                                    
                                    <div class="row gy-4 mb-4">                                            
                                        <div class="col-xxl-6 col-xl-12">
                                            <div class="card custom-card">
                                                <img src="{{asset('/')}}{{$contract->user_signature ?? '/assets/images/media/media-22.jpg'}}" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h6 class="card-title fw-semibold mb-0" style="text-align:center;">{{trans_dynamic('creator')}} {{trans_dynamic('signature')}} </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-12">
                                            <div class="card custom-card">
                                                <img src="{{asset('/')}}{{$contract->signature ?? '/assets/images/media/media-22.jpg'}}" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h6 class="card-title fw-semibold mb-0" style="text-align:center;">{{trans_dynamic('customer')}} {{trans_dynamic('signature')}} </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show active border-0 p-0" id="order-tab-pane" role="tabpanel" aria-labelledby="order-tab-pane" tabindex="0">
                                <div class="p-4">
                                    <p class="mb-1 fw-semibold text-muted op-5 fs-20">01</p>
                                    <div class="fs-15 fw-semibold d-sm-flex d-block align-items-center justify-content-between mb-3">
                                        <div>{{trans_dynamic('list_all_text')}}:</div>
                                    </div>
                                    <div class="row gy-4 mb-4">
                                        <div class="col-xl-12">
                                            {{trans_dynamic('selected_car')}}: <b>{{$carBrand}} {{$carModel}} ({{$carDetails['number_plate']}})</b>
                                        </div>
                                        <div class="col-xl-12">
                                            {{trans_dynamic('start_date')}}: <b>{{$contract->start_date}}</b> | {{trans_dynamic('end_date')}}: <b>{{$contract->end_date}}</b> - {{trans_dynamic('total')}} {{trans_dynamic('day')}}: <b>{{$days}}</b>
                                        </div>
                                        <div class="col-xl-12">
                                            {{trans_dynamic('selected_kilometer_package')}}: 
                                            <b>
                                                {{trans_dynamic('kilometer_package')}} (+ 
                                                {{ intval($kmPackagesJson['kilometers'] ?? '0') }} Km) 
                                                {{ 
                                                    floatval($kmPackagesJson['extra_price'] ?? '0') * 
                                                    intval($kmPackagesJson['kilometers'] ?? '0')
                                                }} €
                                            </b>
                                        </div>
                                        <div class="col-xl-12">
                                            {{trans_dynamic('selected_insurance_package')}}: <b>{{trans_dynamic('insurance_package')}} (+ {{$insurancePackagesJson['deductible'] ?? '0' }} SB) {{ ($days * (float)($insurancePackagesJson['price_per_day'] ?? 0)) }} €</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-1 -->
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body p-0 product-checkout">
                        <div class="p-4">
                            <div class="fs-15 fw-semibold d-sm-flex d-block align-items-center justify-content-between mb-3">
                                <div>{{trans_dynamic('pickup')}} {{trans_dynamic('form')}}:</div>
                            </div>
                            <div class="row gy-4 mb-4">
                                <!-- here all informations -->
                                <form action="{{route('contracts.pickup.store')}}" method="POST" id="damageForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="{{$contract->id}}" name="contract_id">
                                    <div class="col-xl-12">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="card custom-card">
                                                    <div class="card-header">
                                                        <div class="card-title">
                                                            {{trans_dynamic('fuel_level')}}
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <input type="range" name="fuel_status" class="form-range" min="0" max="100" step="10" value="{{$carDetails['fuel_status']}}" id="customRange3" style="float: left; width: 80%;">
                                                        <p id="fuellevel">{{$carDetails['fuel_status']}}%</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row col-xl-12">
                                                <div class="col-xl-7">
                                                    <div class="card custom-card">
                                                        <div class="card-header">
                                                            <div class="card-title">
                                                                {{trans_dynamic('damages')}}
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="container mt-5">
                                                                <div id="car-container" class="mb-3">
                                                                    <img id="car" src="{{ asset('/assets/images/cars/damages/damages.jpg') }}" class="img-fluid" alt="Car Silhouette">
                                                                    
                                                                    @php
                                                                    $newDamagesArray = json_decode(json_encode($newDamagesArray), true);
                                                                    $markerIndex = 1; // Başlangıç indeksi
                                                                    @endphp
                                                                    
                                                                    @foreach ($newDamagesArray as $damage)
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
                                                    <div class="card custom-card">
                                                        <div class="card-header d-flex justify-content-between align-items-center">
                                                            <div class="card-title">
                                                                {{trans_dynamic('internal_damages')}}
                                                            </div>
                                                            <button type="button" class="btn btn-primary" id="addDamageBtn">{{trans_dynamic('damage_add')}}</button>
                                                        </div>
                                                        <div class="card-body" id="damagesContainer">
                                                            @php
                                                            $internalDamageCount = 0;
                                                            @endphp
                                                            
                                                            @foreach($newInternalDamagesArray as $damage)
                                                            @php
                                                            $internalDamageCount++;
                                                            @endphp
                                                            <div class="damage-item mb-3">
                                                                <div class="row">
                                                                    <div class="col-xl-6">
                                                                        <strong>{{trans_dynamic('description')}}:</strong> {{ $damage['description'] }}
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        @if(isset($damage['image']))
                                                                        <img src="{{ asset($damage['image']) }}" alt="Damage Image" style="width: 60px; height:60px;">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', (event) => {
                                                            console.log('Document loaded');
                                                            
                                                            const addButton = document.getElementById('addDamageBtn');
                                                            if (addButton) {
                                                                addButton.addEventListener('click', function() {
                                                                    
                                                                    let internalDamageNumber = {{ $internalDamageCount }};
                                                                    
                                                                    internalDamageNumber++;
                                                                    
                                                                    const damageDiv = document.createElement('div');
                                                                    damageDiv.classList.add('damage-input-group', 'mb-3');
                                                                    damageDiv.setAttribute('id', `damage-group-${internalDamageNumber}`);
                                                                    
                                                                    const textInput = document.createElement('input');
                                                                    textInput.setAttribute('type', 'text');
                                                                    textInput.setAttribute('name', `internal_damage_description_${internalDamageNumber}`);
                                                                    textInput.classList.add('form-control', 'mb-2');
                                                                    textInput.setAttribute('placeholder', 'Describe the damage');
                                                                    
                                                                    const fileInput = document.createElement('input');
                                                                    fileInput.setAttribute('type', 'file');
                                                                    fileInput.setAttribute('name', `internal_damage_image_${internalDamageNumber}`);
                                                                    fileInput.classList.add('form-control');
                                                                    
                                                                    damageDiv.appendChild(textInput);
                                                                    damageDiv.appendChild(fileInput);
                                                                    
                                                                    document.getElementById('damagesContainer').appendChild(damageDiv);
                                                                });
                                                            }
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
                                                                    <ul class="list-group-pickup damage-list mb-3" id="default-damages-list"></ul>
                                                                    <div id="damage-forms-container"></div>
                                                                    <a id="delete-last" class="btn btn-danger mt-3">{{trans_dynamic('remove_last')}}t</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12">
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
                                                                                    <input class="form-check-input option-radio" type="radio" 
                                                                                    name="options[triangle_reflector]" id="triangle_reflector_yes" value="yes">
                                                                                    <label class="form-check-label" for="triangle_reflector_yes">
                                                                                        {{trans_dynamic('yes')}}
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline ms-3">
                                                                                    <input class="form-check-input option-radio" type="radio" 
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
                                                                                    <input class="form-check-input option-radio" type="radio" 
                                                                                    name="options[reflective_vest]" id="reflective_vest_yes" value="yes">
                                                                                    <label class="form-check-label" for="reflective_vest_yes">
                                                                                        {{trans_dynamic('yes')}}
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline ms-3">
                                                                                    <input class="form-check-input option-radio" type="radio" 
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
                                                                                    <input class="form-check-input option-radio" type="radio" 
                                                                                    name="options[first_aid_kit]" id="first_aid_kit_yes" value="yes">
                                                                                    <label class="form-check-label" for="first_aid_kit_yes">
                                                                                        {{trans_dynamic('yes')}}
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline ms-3">
                                                                                    <input class="form-check-input option-radio" type="radio" 
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
                                                                                    <input class="form-check-input option-radio" type="radio" 
                                                                                    name="options[clean]" id="clean_yes" value="yes">
                                                                                    <label class="form-check-label" for="clean_yes">
                                                                                        {{trans_dynamic('yes')}}
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check form-check-inline ms-3">
                                                                                    <input class="form-check-input option-radio" type="radio" 
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
                                                                            <div class="col-xl-6">
                                                                                <div class="input-group has-validation">
                                                                                    <input class="form-control"  value="" name="options[tire_profile]" id="tire_profile" placeholder="Tire Profie">
                                                                                    <span class="input-group-text" id="tire_profile">MM</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 product-checkout">
                            <div class="p-4">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <label for="extra_km" class="form-label">{{trans_dynamic('extra')}} {{trans_dynamic('kilometer')}}</label>
                                        <div class="input-group has-validation">
                                            <input type="text" value="0" name="extra_km" class="form-control" id="extra_km" placeholder="{{trans_dynamic('extra')}} {{trans_dynamic('kilometer')}}">
                                            <span class="input-group-text" id="extra_km_unit">KM</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <label for="odometer" class="form-label">{{trans_dynamic('odometer')}}</label>
                                        <div class="input-group has-validation">
                                            <input name="odometer" class="form-control" id="odometer" placeholder="Odometer">
                                            <span class="input-group-text" id="odometer">KM</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div id="extra_km_price_display">
                                        </div>
                                        <input type="hidden" id="extra_km_price" name="extra_km_price" value="">
                                        <script>
                                            document.getElementById('extra_km').addEventListener('input', function() {
                                                const extraKm = parseFloat(this.value) || 0;
                                                let extraPricePerKm = 0;
                                                
                                                const kmPackages = {!! json_encode($kmPackagesJson) !!};
                                                const carPrices = {!! json_encode($carDetails['prices']) !!};
                                                
                                                if (kmPackages && kmPackages !== "[]" && kmPackages.extra_price && !isNaN(parseFloat(kmPackages.extra_price))) {
                                                    extraPricePerKm = parseFloat(kmPackages.extra_price);
                                                } else if (carPrices && carPrices.price_per_extra_kilometer && !isNaN(parseFloat(carPrices.price_per_extra_kilometer))) {
                                                    extraPricePerKm = parseFloat(carPrices.price_per_extra_kilometer);
                                                }
                                                
                                                const totalExtraPrice = extraKm * extraPricePerKm;
                                                
                                                // Güncellenen fiyatı görüntüleyin
                                                document.getElementById('extra_km_price_display').innerText = `Total Extra KM Price: ${totalExtraPrice.toFixed(2)} currency`;
                                                
                                                // Mevcut input elemanını bul ve değerini güncelle
                                                let extraKmPriceInput = document.getElementById('extra_km_price');
                                                
                                                if (extraKmPriceInput) {
                                                    extraKmPriceInput.value = totalExtraPrice.toFixed(2);
                                                }
                                            });
                                        </script>
                                    </div>
                                    <div class="col-xl-6"></div>
                                    <div class="col-xl-6 mt-3">
                                        <div class="form-floating">
                                            <div class="form-group">
                                                <label for="end_date_contract" class="form-label">{{trans_dynamic('end_date')}}</label>
                                                <div class="input-group">
                                                    <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                                    <input type="text" value="{{$contract->end_date}}" name="end_date_contract" class="form-control end_date_contract" id="datetime" data-date-format="Y-m-d">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 mt-3">
                                        <div class="form-floating">
                                            <div class="form-group">
                                                <label for="pickup_date_contract" class="form-label">{{trans_dynamic('pickup')}} {{trans_dynamic('date')}}</label>
                                                <div class="input-group">
                                                    <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                                    <input type="text" value="{{$contract->end_date}}" name="pickup_date_contract" class="form-control pickup_date_contract" id="datetime" data-date-format="Y-m-d">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 p-3">
                                        <input type="hidden" name="damage_image" id="damage_image">
                                        <button type="button" onclick="captureAndSubmitImage()" class="btn btn-primary w-100">{{trans_dynamic('pickup')}}</button>
                                    </div>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
                                    <script>
                                        function captureAndSubmitImage() {
                                            const carContainer = document.getElementById('car-container');
                                            
                                            html2canvas(carContainer).then(canvas => {
                                                const imageData = canvas.toDataURL('image/png');
                                                console.log('Image data:', imageData); // Base64 verisini konsola yazdır
                                                
                                                // Gizli input alanına Base64 verisini ekle
                                                document.getElementById('damage_image').value = imageData;
                                                
                                                // Formu gönder
                                                document.getElementById('damageForm').submit();
                                            }).catch(error => {
                                                console.error('Image capture failed:', error);
                                            });
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- End::app-content -->
<script>
    const damagesNested = {!! json_encode($newDamagesArray) !!};            
    
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
                    <div class="damage-description">{{trans_dynamic('description')}}: ${damage.description}</div>
                    <input type="hidden" name="old_description_${index + 1}" value="${damage.description}">
                    <input type="hidden" name="old_image_${index + 1}" value="${damage.photo}">
                    <input type="hidden" name="old_x_cordinate_${index + 1}" value="${damage.coordinates.x}">
                    <input type="hidden" name="old_y_cordinate_${index + 1}" value="${damage.coordinates.y}">
                </div>
            </div>
        `;
            
            document.querySelector('.list-group-pickup').appendChild(listItem);
            
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