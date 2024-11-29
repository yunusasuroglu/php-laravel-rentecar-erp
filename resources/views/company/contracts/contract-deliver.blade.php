@extends('layouts.layout')
@section('title', 'Deliver Contract')
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
    <h4 class="fw-medium mb-0">{{trans_dynamic('handover')}} {{trans_dynamic('contract')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('contracts')}}" class="text-white-50">{{trans_dynamic('contracts')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('handover')}} {{trans_dynamic('contract')}}</li>
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
                                    $contractId = $contract->id; // Sözleşme ID'sini alın
                                    $contractData = session('contractData', []); // Tüm sözleşme verilerini oturumdan alın
                                    $step = $contractData[$contractId]['step'] ?? ''; // Belirli sözleşme ID'sine göre adımı alın
                                    @endphp
                                    @if($step == 5)
                                    <div class="col-3">
                                        <a class="nav-link disabled" id="order-tab" data-bs-toggle="tab" data-bs-target="#order-tab-pane" type="button" role="tab" aria-controls="order-tab" aria-selected="true">
                                            <i class="ri-truck-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('general_information')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link active" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#cardetails" type="button" role="tab" aria-controls="confirmed-tab" aria-selected="false">
                                            <i class="bx bx-car me-2 align-middle d-inline-block"></i>{{trans_dynamic('car')}} {{trans_dynamic('detail')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirm-tab-pane" type="button" role="tab" aria-controls="confirmed-tab" aria-selected="false">
                                            <i class="ri-user-3-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('id_and_driver_Card')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivery-tab-pane" type="button" role="tab" aria-controls="delivered-tab" aria-selected="false">
                                            <i class="ri-checkbox-circle-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('signature')}} & {{trans_dynamic('confirmation')}}
                                        </a> 
                                    </div>
                                    
                                    @elseif($step == 6)
                                    <div class="col-3">
                                        <a class="nav-link disabled" id="order-tab" data-bs-toggle="tab" data-bs-target="#order-tab-pane" type="button" role="tab" aria-controls="order-tab" aria-selected="true">
                                            <i class="ri-truck-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('general_information')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#cardetails" type="button" role="tab" aria-controls="confirmed-tab" aria-selected="false">
                                            <i class="bx bx-car me-2 align-middle d-inline-block"></i>{{trans_dynamic('car')}} {{trans_dynamic('detail')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link active" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirm-tab-pane" type="button" role="tab" aria-controls="confirmed-tab" aria-selected="false">
                                            <i class="ri-user-3-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('id_and_driver_Card')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivery-tab-pane" type="button" role="tab" aria-controls="delivered-tab" aria-selected="false">
                                            <i class="ri-checkbox-circle-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('signature')}} & {{trans_dynamic('confirmation')}}
                                        </a> 
                                    </div>
                                    
                                    @elseif($step == 7)
                                    <div class="col-3">
                                        <a class="nav-link disabled" id="order-tab" data-bs-toggle="tab" data-bs-target="#order-tab-pane" type="button" role="tab" aria-controls="order-tab" aria-selected="true">
                                            <i class="ri-truck-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('general_information')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#cardetails" type="button" role="tab" aria-controls="confirmed-tab" aria-selected="false">
                                            <i class="bx bx-car me-2 align-middle d-inline-block"></i>{{trans_dynamic('car')}} {{trans_dynamic('detail')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirm-tab-pane" type="button" role="tab" aria-controls="confirmed-tab" aria-selected="false">
                                            <i class="ri-user-3-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('id_and_driver_Card')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link active" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivery-tab-pane" type="button" role="tab" aria-controls="delivered-tab" aria-selected="false">
                                            <i class="ri-checkbox-circle-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('signature')}} & {{trans_dynamic('confirmation')}}
                                        </a> 
                                    </div>
                                    @else
                                    <div class="col-3">
                                        <a class="nav-link active" id="order-tab" data-bs-toggle="tab" data-bs-target="#order-tab-pane" type="button" role="tab" aria-controls="order-tab" aria-selected="true">
                                            <i class="ri-truck-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('general_information')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#cardetails" type="button" role="tab" aria-controls="confirmed-tab" aria-selected="false">
                                            <i class="bx bx-car me-2 align-middle d-inline-block"></i>{{trans_dynamic('car')}} {{trans_dynamic('detail')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirm-tab-pane" type="button" role="tab" aria-controls="confirmed-tab" aria-selected="false">
                                            <i class="ri-user-3-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('id_and_driver_Card')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivery-tab-pane" type="button" role="tab" aria-controls="delivered-tab" aria-selected="false">
                                            <i class="ri-checkbox-circle-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('signature')}} & {{trans_dynamic('confirmation')}}
                                        </a> 
                                    </div>
                                    @endif
                                </div>
                            </nav>
                            <div class="tab-content" id="myTabContent">
                                @if($step == 5)
                                <div class="tab-pane fade show active border-0 p-0" id="cardetails" role="tabpanel" aria-labelledby="cardetails" tabindex="0">
                                    <form action="{{route('contracts.deliver.store.step2')}}" method="POST" enctype="multipart/form-data" id="damageForm">
                                        @csrf
                                        <input type="hidden" name="step" value="6">
                                        <input type="hidden" name="car_id" value="{{$contract->car_id}}">
                                        <input type="hidden" name="contract_id" value="{{$contract->id}}">
                                        <div class="p-4">
                                            <p class="mb-1 fw-semibold text-muted op-5 fs-20">02</p>
                                            <div class="fs-15 fw-semibold d-sm-flex d-block align-items-center justify-content-between mb-3">
                                                <div>Car details here:</div>
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
                                                                    @if (isset($contractData[$contract->id]['fuel_status']))
                                                                    <input type="range" name="fuel_status" class="form-range" min="0" max="100" step="10" 
                                                                    value="{{$contractData[$contract->id]['fuel_status']}}" id="customRange3" style="float: left; width: 80%;">
                                                                    <p id="fuellevel">{{$contractData[$contract->id]['fuel_status'] ?? 'N/A'}}%</p>
                                                                    @else
                                                                    <input type="range" name="fuel_status" class="form-range" min="0" max="100" step="10" 
                                                                    value="{{$carDetails['fuel_status']}}" id="customRange3" style="float: left; width: 80%;">
                                                                    <p id="fuellevel">{{$carDetails['fuel_status']}}%</p>
                                                                    @endif
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
                                                                                $damagesArray = json_decode(json_encode($damagesArray), true);
                                                                                $markerIndex = 1; // Başlangıç indeksi
                                                                                @endphp
                                                                                
                                                                                @foreach ($damagesArray as $damage)
                                                                                <div class="damage-marker" id="marker-{{ $markerIndex }}"
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
                                                                        <button type="button" class="btn btn-primary" id="addDamageBtn">Add Damage</button>
                                                                    </div>
                                                                    <div class="card-body" id="damagesContainer">
                                                                        @php
                                                                        $internalDamageCount = 0;
                                                                        @endphp
                                                                        
                                                                        @foreach($internalDamagesArray as $damage)
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
                                                                    // Mevcut hasar sayısını PHP'den alıyoruz
                                                                    let damageNumber = {{ $internalDamageCount }};
                                                                    
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
                                                                            <a id="delete-last" class="btn btn-danger mt-3">{{trans_dynamic('remove_last')}}</a>
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
                                                                                        <input class="form-check-input option-radio" type="radio" name="options[triangle_reflector]" id="triangle_reflector_yes" value="yes"
                                                                                        {{ isset($options['triangle_reflector']) && $options['triangle_reflector'] === 'yes' ? 'checked' : '' }}>
                                                                                        <label class="form-check-label" for="triangle_reflector_yes">
                                                                                            {{trans_dynamic('yes')}}
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline ms-3">
                                                                                        <input class="form-check-input option-radio" type="radio" name="options[triangle_reflector]" id="triangle_reflector_no" value="no"
                                                                                        {{ isset($options['triangle_reflector']) && $options['triangle_reflector'] === 'no' ? 'checked' : '' }}>
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
                                                                                        <input class="form-check-input option-radio" type="radio" name="options[reflective_vest]" id="reflective_vest_yes" value="yes"
                                                                                        {{ isset($options['reflective_vest']) && $options['reflective_vest'] === 'yes' ? 'checked' : '' }}>
                                                                                        <label class="form-check-label" for="reflective_vest_yes">
                                                                                            {{trans_dynamic('yes')}}
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline ms-3">
                                                                                        <input class="form-check-input option-radio" type="radio" name="options[reflective_vest]" id="reflective_vest_no" value="no"
                                                                                        {{ isset($options['reflective_vest']) && $options['reflective_vest'] === 'no' ? 'checked' : '' }}>
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
                                                                                        <input class="form-check-input option-radio" type="radio" name="options[first_aid_kit]" id="first_aid_kit_yes" value="yes"
                                                                                        {{ isset($options['first_aid_kit']) && $options['first_aid_kit'] === 'yes' ? 'checked' : '' }}>
                                                                                        <label class="form-check-label" for="first_aid_kit_yes">
                                                                                            {{trans_dynamic('yes')}}
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline ms-3">
                                                                                        <input class="form-check-input option-radio" type="radio" name="options[first_aid_kit]" id="first_aid_kit_no" value="no"
                                                                                        {{ isset($options['first_aid_kit']) && $options['first_aid_kit'] === 'no' ? 'checked' : '' }}>
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
                                                                                        <input class="form-check-input option-radio" type="radio" name="options[clean]" id="clean_yes" value="yes"
                                                                                        {{ isset($options['clean']) && $options['clean'] === 'yes' ? 'checked' : '' }}>
                                                                                        <label class="form-check-label" for="clean_yes">
                                                                                            {{trans_dynamic('yes')}}
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline ms-3">
                                                                                        <input class="form-check-input option-radio" type="radio" name="options[clean]" id="clean_no" value="no"
                                                                                        {{ isset($options['clean']) && $options['clean'] === 'no' ? 'checked' : '' }}>
                                                                                        <label class="form-check-label" for="clean_no">
                                                                                            {{trans_dynamic('no')}}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            @php
                                                                            $tireProfileValue = isset($options['tire_profile']) ? $options['tire_profile'] : '';
                                                                            if (is_array($tireProfileValue)) {
                                                                                $tireProfileValue = implode(', ', $tireProfileValue); // veya uygun bir işleme göre düzenleme yapın
                                                                            }
                                                                            @endphp
                                                                            <div class="form-check d-flex align-items-center justify-content-between mb-2">
                                                                                <label class="form-check-label me-2" for="tire_profile">
                                                                                    {{trans_dynamic('vehicle_tire_profile')}}
                                                                                </label>
                                                                                <div class="col-xl-6">
                                                                                    <div class="input-group has-validation">
                                                                                        <input type="text" name="options[tire_profile]" class="form-control" value="{{ htmlspecialchars($tireProfileValue, ENT_QUOTES, 'UTF-8') }}" id="tire_profile" placeholder="Tire Profile">
                                                                                        <span class="input-group-text" id="tire_profile">MM</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <label for="odometer" class="form-label">{{trans_dynamic('odometer')}}</label>
                                                            <input type="text" name="odometer" class="form-control" id="odometer" placeholder="Odometer KM" value="{{$carDetails['odometer']}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-between">
                                        <a class="btn btn-danger-light d-inline-flex" onclick="document.getElementById('backStep2Form').submit();">
                                            <i class="ri-information-fill me-2 align-middle"></i>
                                            {{trans_dynamic('backto')}} {{trans_dynamic('general_information')}}
                                        </a>
                                        <input type="hidden" name="damage_image" id="damage_image">
                                        <button type="button" onclick="confirmCaptureAndSubmit()" class="btn btn-success d-inline-flex">
                                            ID Cards<i class="ri-user-3-line ms-2 align-middle"></i>
                                        </button>
                                        
                                        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
                                        <script>
                                            function confirmCaptureAndSubmit() {
                                                const userConfirmed = confirm("Please confirm that the report is approved to continue.");
                                                if (userConfirmed) {
                                                    captureAndSubmitImage();
                                                }
                                            }
                                            
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
                                </form>
                                <form action="{{ route('contracts.deliver.store.back.step2') }}" method="POST" id="backStep2Form">
                                    @csrf
                                    <input type="hidden" name="step" value="4">
                                    <input type="hidden" name="contract_id" value="{{$contract->id}}">
                                </form>
                            </div>
                            @elseif($step == 6)
                            <div class="tab-pane fade show active border-0 p-0" id="confirm-tab-pane" role="tabpanel" aria-labelledby="confirm-tab-pane" tabindex="0">
                                <form action="{{route('contracts.deliver.store.step3')}}" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <input type="hidden" name="step" value="7">
                                    <input type="hidden" name="contract_id" value="{{$contract->id}}">
                                    <div class="p-4">
                                        <p class="mb-1 fw-semibold text-muted op-5 fs-20">03</p>
                                        <div class="fs-15 fw-semibold d-sm-flex d-block align-items-center justify-content-between mb-3">
                                            <div>{{trans_dynamic('id_and_driver_card')}}:</div>
                                        </div>
                                        @php
                                        if (is_string($contract->customer)) {
                                            $customerData = json_decode($contract->customer, true); // JSON string ise diziye çevir
                                        } else {
                                            // Zaten bir dizi ise, doğrudan kullan
                                            $customerData = $contract->customer;
                                        }
                                        
                                        $identityData = $customerData['identity'];
                                        if (is_string($identityData)) {
                                            $identityData = json_decode($customerData['identity'], true);
                                        } else {
                                            // Zaten bir dizi ise, doğrudan kullan
                                            $identityFront = $customerData['identity'];
                                        }
                                        
                                        $drivingData = $customerData['driving_licence'];
                                        if (is_string($drivingData)) {
                                            $drivingData = json_decode($customerData['driving_licence'], true);
                                        } else {
                                            // Zaten bir dizi ise, doğrudan kullan
                                            $drivingData = $customerData['driving_licence'];
                                        }
                                        $drivingLicenceFront = $customerData['driving_licence']['front'] ?? 'assets/images/media/media-22.jpg';
                                        @endphp
                                        <div class="row gy-4 mb-4">                                            
                                            <div class="col-xxl-3 col-xl-12">
                                                <div class="card custom-card">
                                                    <a aria-label="anchor" href="javascript:void(0);" class="card-anchor"></a>
                                                    <img src="{{asset('/'. $identityData['front'] ?? 'assets/images/media/media-22.jpg')}}" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h6 class="card-title fw-semibold mb-0" style="text-align:center;">{{trans_dynamic('id_card_front')}} </h6>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <input name="identity_front" class="form-control" type="file" id="formFile">
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-12">
                                                <div class="card custom-card">
                                                    <a aria-label="anchor" href="javascript:void(0);" class="card-anchor"></a>
                                                    <img src="{{asset('/'. $identityData['back'] ?? 'assets/images/media/media-22.jpg')}}" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h6 class="card-title fw-semibold mb-0" style="text-align:center;">{{trans_dynamic('id_card_back')}} </h6>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <input name="identity_back" class="form-control" type="file" id="formFile">
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-12">
                                                <div class="card custom-card">
                                                    <a aria-label="anchor" href="javascript:void(0);" class="card-anchor"></a>
                                                    <img src="{{asset('/'. $drivingData['front'] ?? 'assets/images/media/media-22.jpg')}}" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h6 class="card-title fw-semibold mb-0" style="text-align:center;">{{trans_dynamic('driver_card_front')}}</h6>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <input name="driver_licence_front" class="form-control" type="file" id="formFile">
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-12">
                                                <div class="card custom-card">
                                                    <a aria-label="anchor" href="javascript:void(0);" class="card-anchor"></a>
                                                    <img src="{{asset('/'. $drivingData['front'] ?? 'assets/images/media/media-22.jpg')}}" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h6 class="card-title fw-semibold mb-0" style="text-align:center;">{{trans_dynamic('driver_card_back')}}</h6>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <input name="driver_licence_back" class="form-control" type="file" id="formFile">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-between btn-list">
                                        <a class="btn btn-danger-light d-inline-flex" onclick="document.getElementById('backStep3Form').submit();">
                                            <i class="ri-car-line me-2 align-middle"></i>
                                            {{trans_dynamic('backto')}} {{trans_dynamic('car')}} {{trans_dynamic('detail')}}
                                        </a>
                                        <button type="submit" class="btn btn-success d-inline-flex" id="payment-trigger">
                                            {{trans_dynamic('contunie')}} {{trans_dynamic('signature')}}
                                            <i class="bi bi-credit-card-2-front align-middle ms-2"></i>
                                        </button>
                                    </div>
                                </form>
                                <form action="{{ route('contracts.deliver.store.back.step3') }}" method="POST" id="backStep3Form">
                                    @csrf
                                    <input type="hidden" name="step" value="5">
                                    <input type="hidden" name="contract_id" value="{{$contract->id}}">
                                </form>
                            </div>
                            @elseif($step == 7)
                            <div class="tab-pane fade show active border-0 p-0" id="delivery-tab-pane" role="tabpanel"varia-labelledby="delivery-tab-pane" tabindex="0">
                                <form action="{{ route('contracts.deliver.store.step4') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="p-5 checkout-payment-success my-3">
                                        <div class="mb-5">
                                            <h5 class="text-success fw-semibold">{{trans_dynamic('signature')}} & {{trans_dynamic('confirmation')}}</h5>
                                        </div>
                                        <div class="mb-4">
                                            <p class="mb-1 fs-14" data-bs-toggle="modal" data-bs-target="#exampleModalFullscreen">
                                                <u>{{trans_dynamic('signature_text')}}</u>
                                            </p>
                                            <div class="modal fade" id="exampleModalFullscreen" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-fullscreen">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title" id="exampleModalFullscreenLabel">{{trans_dynamic('digital_signature')}}</h6>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
                                                            <div id="root"></div>
                                                            <script src="https://cdn.jsdelivr.net/npm/lemonadejs/dist/lemonade.min.js"></script>
                                                            <script src="https://cdn.jsdelivr.net/npm/@lemonadejs/signature/dist/index.min.js"></script>
                                                            <script>
                                                                // İmza bileşenini başlat
                                                                const root = document.getElementById("root");
                                                                const displayWidth = window.innerWidth * 0.8;
                                                                const displayHeight = window.innerHeight * 0.5;
                                                                
                                                                let signatureComponent = Signature(root, {
                                                                    value: [],
                                                                    width: displayWidth,
                                                                    height: displayHeight,
                                                                    instructions: "Please sign this document"
                                                                });
                                                                
                                                                function getSignatureData() {
                                                                    const canvas = document.querySelector('#root canvas');
                                                                    if (canvas) {
                                                                        return canvas.toDataURL(); // Veriyi Base64 formatında alır
                                                                    } else {
                                                                        console.error('Canvas not found');
                                                                        return null;
                                                                    }
                                                                }
                                                                
                                                                function saveSignatureToInput() {
                                                                    const dataURL = getSignatureData();
                                                                    if (dataURL) {
                                                                        document.getElementById('signature').value = dataURL;
                                                                    }
                                                                }
                                                                
                                                                function clearSignature() {
                                                                    const canvas = document.querySelector('#root canvas');
                                                                    if (canvas) {
                                                                        const ctx = canvas.getContext('2d');
                                                                        ctx.clearRect(0, 0, canvas.width, canvas.height); // Canvas'ı temizle
                                                                    } else {
                                                                        console.error('Canvas not found');
                                                                    }
                                                                }
                                                            </script>
                                                            
                                                            <!-- Butonları HTML'e ekleyin -->
                                                            <button type="button" class="btn btn-warning" onclick="clearSignature()">{{trans_dynamic('clear')}} {{trans_dynamic('signature')}}</button>
                                                            <style>
                                                                #root canvas {
                                                                    background-color: rgb(235, 235, 235);
                                                                }
                                                            </style>
                                                            
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-warning" onclick="clearSignature()">{{trans_dynamic('clear')}} {{trans_dynamic('signature')}}</button>
                                                            <button type="button" class="btn btn-primary" onclick="saveSignatureToInput()" data-bs-dismiss="modal">{{trans_dynamic('save_and_close')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-muted">{{trans_dynamic('signature_text_2')}}</p>
                                        </div>
                                        <input type="hidden" id="signature" name="signature">
                                        <input type="hidden" name="contract_id" value="{{$contract->id}}">
                                        <button type="submit" class="btn btn-success" onclick="saveSignatureToInput()">{{trans_dynamic('save_and_complete')}}</button>
                                    </div>
                                </form>
                                <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-between">
                                    <a class="btn btn-danger-light d-inline-flex" onclick="document.getElementById('backStep4Form').submit();">
                                        <i class="ri-user-3-line me-2 align-middle"></i>
                                        {{trans_dynamic('backto')}} {{trans_dynamic('id_and_driver_card')}}
                                    </a>
                                    <a class="btn btn-warning-light d-inline-flex" onclick="document.getElementById('backStep5Form').submit();">
                                        <i class=" ri-user-location-fill me-2 align-middle"></i>
                                        {{trans_dynamic('continueto')}} {{trans_dynamic('without_signing')}}
                                    </a>
                                </div>
                                <form action="{{ route('contracts.deliver.store.back.step4') }}" method="POST" id="backStep4Form">
                                    @csrf
                                    <input type="hidden" name="step" value="6">
                                    <input type="hidden" name="contract_id" value="{{$contract->id}}">
                                </form>
                                <form action="{{ route('contracts.deliver.store.withoutSignature') }}" method="POST" id="backStep5Form">
                                    <input type="hidden" name="contract_id" value="{{$contract->id}}" id="">
                                    @csrf
                                </form>
                            </div>
                            @else
                            <div class="tab-pane fade show active border-0 p-0" id="order-tab-pane" role="tabpanel" aria-labelledby="order-tab-pane" tabindex="0">
                                <form action="{{route('contracts.deliver.store.step1')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="step" value="5">
                                    <input type="hidden" name="contract_id" value="{{$contract->id}}">
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
                                                {{trans_dynamic('start_date')}}: <b>{{$contract->start_date}}</b> | {{trans_dynamic('end_date')}}: <b>{{$contract->end_date}}</b> - {{trans_dynamic('total')}} {{trans_dynamic('days')}}: <b>{{$days}}</b>
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
                                                {{trans_dynamic('selected_insurance_package')}}: <b>{{trans_dynamic('insurance_package')}} (+ {{$insurancePackagesJson['deductible'] ?? '0' }} € SB) {{ ($days * (float)($insurancePackagesJson['price_per_day'] ?? 0)) }} €</b>
                                            </div>
                                            <div class="col-xl-12">
                                                {{trans_dynamic('selected_payment_method')}}: <b>{{$contract->payment_option}}</b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-between">
                                        <button type="submit" class="btn btn-success d-inline-flex">
                                            {{trans_dynamic('car')}} {{trans_dynamic('detail')}}
                                            <i class="ri-car-fill ms-2 align-middle"></i>
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
                        <div class="card-title me-1">{{trans_dynamic('contact')}} {{trans_dynamic('detail')}}</div>
                    </div>
                    <div class="card-body p-0">
                        <div class="p-3 border-bottom border-block-end-dashed">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="fw-semibold fs-14">{{trans_dynamic('car')}}</div>
                                <div class="fw-semibold fs-14">{{trans_dynamic('day')}}</div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div id="carDetails" class="text-muted fs-15">{{$carBrand}} {{$carModel}} {{$carColor}}</div>
                                <div id="days" class="fw-semibold fs-15n ">{{$days}}</div>
                            </div>
                        </div>
                        <div class="p-3 border-bottom border-block-end-dashed">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="text-muted op-7">{{trans_dynamic('subtotal')}}</div>
                                <div class="fw-semibold fs-14">{{$contract->total_amount ?? '0'}}</div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="text-muted op-7">{{trans_dynamic('kilometer_package')}} (+ {{$kmPackagesJson['kilometers'] ?? '0'}} Km)</div>
                                <div class="fw-semibold fs-14 text-danger">
                                    {{
                                        (intval($kmPackagesJson['extra_price'] ?? '0')) * 
                                        (intval($kmPackagesJson['kilometers'] ?? '0'))
                                    }} €
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="text-muted op-7">
                                    
                                    @if(empty($insurancePackagesJson) || $insurancePackagesJson == "[]")
                                    {{trans_dynamic('standard_package')}} ( {{ $standardExemption ?? '0' }} € SB)
                                    @else
                                    {{trans_dynamic('insurance_package')}} ( {{ $insurancePackagesJson['deductible'] ?? '0' }} € SB)
                                    @endif
                                    
                                </div>
                                <div id="insurance_package_price" class="fw-semibold fs-14 text-danger">
                                    @if(empty($insurancePackagesJson) || $insurancePackagesJson == "[]")
                                    {{ $days * (float)($car->prices['standard_exemption'] ?? 0) }} €
                                    @else
                                    {{ $days * (float)($insurancePackagesJson['price_per_day'] ?? 0) }} €
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-muted op-7">{{trans_dynamic('tax')}} (19%)</div>
                                <div id="tax" class="fw-semibold fs-14">{{$contract->tax ?? '0'}} €</div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-muted op-7">{{trans_dynamic('paid')}}</div>
                                <div class="fw-semibold fs-14">{{$contract->amount_paid ?? '0'}} €</div>
                            </div>
                        </div>
                        <div class="p-2 m-2 bg-success-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="fs-15">{{trans_dynamic('total')}}:</div>
                                <div id="totalPrice" class="fw-semibold fs-16 text-success">{{$contract->total_amount ?? '0'}} €</div>
                            </div>
                        </div>
                        <div class="p-2 m-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="fs-15">{{trans_dynamic('deposit')}}</div>
                                <div id="deposito" class="fw-semibold fs-14">{{$contract->deposit ?? '0'}}</div>
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
                    <input type="hidden" name="old_description_${index + 1}" value="${damage.description}">
                    <input type="hidden" name="old_image_${index + 1}" value="${damage.photo}">
                    <input type="hidden" name="old_x_cordinate_${index + 1}" value="${damage.coordinates.x}">
                    <input type="hidden" name="old_y_cordinate_${index + 1}" value="${damage.coordinates.y}">
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
<!-- End::app-content -->

@endsection