@extends('layouts.layout')
@section('title', 'Cars - ww')
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
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">Safari</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('cars')}} - {{$car->car ? json_decode($car->car, true)['brand'] : ''}} {{$car->car ? json_decode($car->car, true)['model'] : ''}}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->



<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xxl-4 col-xl-12">
                                <div class="row">
                                    <div class="col-xxl-12 col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-md-5 mb-3">
                                        <div class="">
                                            <div class="swiper swiper-preview-details bd-gray-100 product-details-page">
                                                <div class="swiper-wrapper">
                                                    @if ($images && $images != "[]")
                                                    @foreach($images as $image)
                                                    <div class="swiper-slide" id="img-container">
                                                        <img class="img-fluid" src="{{ asset($image) }}" alt="img">
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                                <div class="swiper-button-next"></div>
                                                <div class="swiper-button-prev"></div>
                                            </div>
                                            <div class="swiper swiper-preview-details bd-gray-100 product-details-page swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden">
                                                
                                                <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-6994c63dbcdee416" aria-disabled="false"></div>
                                                <div class="swiper-button-prev swiper-button-disabled" tabindex="-1" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-6994c63dbcdee416" aria-disabled="true"></div>
                                                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                                                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                                                <div class="swiper swiper-view-details mt-2 swiper-initialized swiper-horizontal swiper-pointer-events swiper-free-mode swiper-watch-progress swiper-backface-hidden swiper-thumbs">
                                                    <div class="swiper-wrapper" id="swiper-wrapper-5cfbae4a8a7875fe" aria-live="polite" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                                                        @if ($images && $images != "[]")
                                                        @foreach($images as $image)
                                                        <div class="swiper-slide swiper-slide-visible swiper-slide-active swiper-slide-thumb-active" role="group" aria-label="1 / 4" style="width: 94.75px; margin-right: 10px;">
                                                            <img class="img-fluid" src="{{ asset($image) }}" alt="img">
                                                        </div>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                                                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-12 col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-md-5 mb-3">
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-8 col-xl-12">
                                        <div class="row g-0 product-scroll rounded-3 p-3 px-0">
                                            <div class="col-xl-6 mt-xxl-0 mt-3">
                                                <div>
                                                    <p class="fs-18 fw-semibold mb-0">{{$car->car ? json_decode($car->car, true)['brand'] : ''}} {{$car->car ? json_decode($car->car, true)['model'] : ''}}</p>
                                                    
                                                    <div class="row mb-4 mt-3">
                                                        <div class="col-xxl-6 col-xl-12">
                                                            
                                                            <div class="d-flex align-items-center">
                                                                <h3 class="mb-1 fw-semibold"><span>{{$car->prices ? json_decode($car->prices, true)['daily_price'] : ''}} €/{{trans_dynamic('day')}}</span></h3>
                                                                
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-4">
                                                        <a href="{{route('contracts.add')}}" class="btn btn-success me-2 mb-2">Buchen</a>
                                                    </div>
                                                    
                                                    <div class="mb-4">
                                                        <p class="fs-15 fw-semibold mb-1">{{trans_dynamic('description')}}:</p>
                                                        <p class="text-muted mb-0">
                                                            {{$car->description}}
                                                        </p>
                                                    </div>
                                                    
                                                    
                                                </div>
                                            </div>
                                            <div class="col-xl-6 mt-xxl-0 mt-3">
                                                <div class="mb-3 border p-3 rounded-3">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <ul class="ps-3 mb-0">
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('horse_power')}}: {{$car->horse_power}} PS
                                                                </li>
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('vin')}}: {{$car->vin}}
                                                                </li>
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('tire_type')}}: {{$car->tire_type}}
                                                                </li>
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('number_of_doors')}}: {{$car->number_of_doors}}
                                                                </li>
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('tire_size')}}: {{$car->tire_size}}
                                                                </li>
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('rim_size')}}: {{$car->rim_size}}
                                                                </li>
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('key_number')}}: {{$car->key_number}}
                                                                </li>
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('color')}}: {{$car->color}}
                                                                </li>
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('date_to_traffic')}}: {{ $car->date_to_traffic}}
                                                                </li>
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('number_plate')}}: {{$car->number_plate}}
                                                                </li>
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('min_age')}}: {{$car->age}}
                                                                </li>
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('odometer')}}: {{$car->odometer}} km
                                                                </li>
                                                                {{-- <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    GPS IMEI: <a href="#">123456789012345</a> //
                                                                </li> --}}
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('daily_kilometer')}}: {{$car->kilometers ? json_decode($car->kilometers, true)['daily_kilometer'] : ''}} km
                                                                </li>
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('extra')}} KM: {{$car->prices ? json_decode($car->prices, true)['price_per_extra_kilometer'] : ''}} €/Km
                                                                </li>
                                                                {{-- <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    Branch: İstanbul //
                                                                </li> --}}
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('car')}} {{trans_dynamic('group')}}: {{$car->car_group}}
                                                                </li>
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('fuel')}}: {{$car->fuel}}
                                                                </li>
                                                                <li class="text-muted mb-2">
                                                                    <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                    {{trans_dynamic('standart_insurance')}}: {{$car->standard_exemption}} €
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>   
                                            </div>
                                            
                                            <div class="border rounded-3 p-3 mb-3">
                                                <small class="text-danger">Voll Kasko mlt SB</small>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p class="fs-16 fw-semibold mb-2">Insurance Packages</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="fs-16 text-danger">Voll Kasko ohne SB</span>
                                                    </div>
                                                </div>
                                                <hr style="border-top: 1px solid rgb(184, 184, 184);">
                                                <div class="row">
                                                    
                                                    @foreach ($car->carGroup->insurance_packages ?? []  as $index => $item)
                                                    <div class="col-xl-12">
                                                        <div class="row">
                                                            <div class="col-xl-5">
                                                                <span class="fs-14 fw-semibold">{{ $item['deductible'] }} € SB</span>
                                                            </div>
                                                            <div class="col-xl-7">
                                                                <p class="text-muted fs-14">+{{ $item['price_per_day'] }} €/{{trans_dynamic('day')}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="border rounded-3 p-3 mb-3">
                                                <small class="text-danger">Voll Kasko mlt SB</small>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p class="fs-16 fw-semibold mb-2">Kilometers Packages</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="fs-16 text-danger">Extra Kilometer</span>
                                                    </div>
                                                </div>
                                                <hr style="border-top: 1px solid rgb(184, 184, 184);">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        @foreach ($car->carGroup->km_packages ?? [] as $item)
                                                        <div class="row">
                                                            <div class="col-xl-5">
                                                                <span class="fs-14 fw-semibold">{{$item['kilometers'] ?? '0'}} {{trans_dynamic('extra')}} KM</span>
                                                            </div>
                                                            <div class="col-xl-7">
                                                                <p class="text-muted fs-14">+{{$item['extra_price'] ?? '0'}} €</p>
                                                                <small>{{$car->prices ? json_decode($car->prices, true)['price_per_extra_kilometer'] : ''}} €</small>
                                                            </div>
                                                        </div>
                                                        @endforeach
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
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">
                                    {{trans_dynamic('fuel_level')}}
                                </div>
                            </div>
                            <div class="card-body">
                                <input type="range" disabled name="fuel_status" class="form-range" min="0" max="100" step="10" value="{{$car->fuel_status}}" id="customRange3" style="float: left; width: 80%;">
                                <p id="fuellevel">{{$car->fuel_status}}%</p>
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
                                                <img id="car" src="{{asset('/assets/images/cars/damages/damages.jpg')}}" class="img-fluid" alt="Car Silhouette">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                @if(!empty($internalDamagesArray) && is_array($internalDamagesArray))
                                    <div class="card custom-card">
                                        <div class="card-header">
                                            <div class="card-title">{{trans_dynamic('internal_damages')}}</div>
                                        </div>
                                        <div class="card-body">
                                            @foreach($internalDamagesArray as $damagesGroup)
                                                @foreach($damagesGroup as $damage)
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
                                @else
                                    <p>No internal damages recorded for this car.</p>
                                @endif
                                </div>
                            </div>
                        
                            <div class="col-xl-5">
                                <div class="card custom-card">
                                    <div class="card-header">
                                        <div class="card-title">
                                            {{trans_dynamic('damages')}}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group mb-3" id="default-damages-list"></ul>
                                        
                                        <div id="damage-forms-container"></div>
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
                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                    name="options[triangle_reflector]" id="triangle_reflector_yes" value="yes" 
                                                    {{ isset($options['triangle_reflector']) && $options['triangle_reflector'] == 'yes' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="triangle_reflector_yes">
                                                        {{trans_dynamic('yes')}}
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline ms-3">
                                                    <input disabled class="form-check-input option-radio" type="radio" 
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
                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                    name="options[reflective_vest]" id="reflective_vest_yes" value="yes" 
                                                    {{ isset($options['reflective_vest']) && $options['reflective_vest'] == 'yes' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="reflective_vest_yes">
                                                        {{trans_dynamic('yes')}}
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline ms-3">
                                                    <input disabled class="form-check-input option-radio" type="radio" 
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
                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                    name="options[first_aid_kit]" id="first_aid_kit_yes" value="yes" 
                                                    {{ isset($options['first_aid_kit']) && $options['first_aid_kit'] == 'yes' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="first_aid_kit_yes">
                                                        {{trans_dynamic('yes')}}
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline ms-3">
                                                    <input disabled class="form-check-input option-radio" type="radio" 
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
                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                    name="options[clean]" id="clean_yes" value="yes" 
                                                    {{ isset($options['clean']) && $options['clean'] == 'yes' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="clean_yes">
                                                        {{trans_dynamic('yes')}}
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline ms-3">
                                                    <input disabled class="form-check-input option-radio" type="radio" 
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
                                            <div class="col-xl-6">
                                                <div class="input-group has-validation">
                                                @php
                                                    $tireProfileValue = isset($options['tire_profile']) ? $options['tire_profile'] : '';
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
                <!--End::row-1 -->
                
            </div>
        </div>
        <script>
            const damagesNested = {!! json_encode($damagesArray) !!};            
            const damages = damagesNested.flat();
            const baseURL = window.location.origin;
            const defaultDamages = damages.map(damage => {
                console.log(`x: ${damage.coordinates.x}, y: ${damage.coordinates.y}`);
                return {
                    coordinates: { x: `${damage.coordinates.x}%`, y: `${damage.coordinates.y}%` }, // Yüzdelik formatta
                    description: damage.description,
                    photo: damage.photo ? `${baseURL}/${damage.photo}` : null
                };
            });
            
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
                                    <div>Description: ${damage.description}</div>
                                </div>
                            </div>
                        `;
                    defaultDamagesList.appendChild(listItem);
                });
            }
            
            document.addEventListener('DOMContentLoaded', () => {
                loadDefaultDamages();
            });
            
        </script>
        <!-- End::app-content -->
        @endsection