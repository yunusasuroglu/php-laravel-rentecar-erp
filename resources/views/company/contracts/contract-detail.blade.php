@extends('layouts.layout')
@section('title', 'Contract Detail')
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
    #fuelleve2 {
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
    @if ($contract->status == 1)
    <h4 class="fw-medium mb-0">{{trans_dynamic('contract')}} - {{$carData['car']['brand']}} {{$carData['car']['model']}} ({{$carData['number_plate']}}) -> {{trans_dynamic('delivered')}} </h4>
    @elseif($contract->status == 2)
    <h4 class="fw-medium mb-0">{{trans_dynamic('contract')}} - {{$carData['car']['brand']}} {{$carData['car']['model']}} ({{$carData['number_plate']}}) -> {{trans_dynamic('not_signed')}}</h4>
    @elseif($contract->status == 3)
    <h4 class="fw-medium mb-0">{{trans_dynamic('contract')}} - {{$carData['car']['brand']}} {{$carData['car']['model']}} ({{$carData['number_plate']}}) -> {{trans_dynamic('not_delivered')}}</h4>
    @elseif($contract->status == 4)
    <h4 class="fw-medium mb-0">{{trans_dynamic('contract')}} - {{$carData['car']['brand']}} {{$carData['car']['model']}} ({{$carData['number_plate']}}) -> {{trans_dynamic('cancelled')}}</h4>
    @elseif($contract->status == 5)
    <h4 class="fw-medium mb-0">{{trans_dynamic('contract')}} - {{$carData['car']['brand']}} {{$carData['car']['model']}} ({{$carData['number_plate']}}) -> {{trans_dynamic('received')}}</h4>
    @endif
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('contracts')}}" class="text-white-50">{{trans_dynamic('contracts')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('contract')}} - {{$carData['car']['brand']}} {{$carData['car']['model']}} ({{$carData['number_plate']}})</li>
            </ol>
        </nav>
    </div>
</div>
<!-- End::app-content -->
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
                                            <div class="swiper swiper-preview-details bd-gray-100 product-details-page swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden">
                                                <div class="swiper-wrapper" id="swiper-wrapper-6994c63dbcdee416" aria-live="polite" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                                                    @foreach ($carData['images'] as $image)
                                                    <div class="swiper-slide swiper-slide-active" id="img-container" role="group" aria-label="1 / 4" style="width: 409px; margin-right: 10px;">
                                                        <img class="img-fluid" src="{{ asset($image ?? '4') }}" alt="img">
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-6994c63dbcdee416" aria-disabled="false"></div>
                                                <div class="swiper-button-prev swiper-button-disabled" tabindex="-1" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-6994c63dbcdee416" aria-disabled="true"></div>
                                                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                                                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                                                <div class="swiper swiper-view-details mt-2 swiper-initialized swiper-horizontal swiper-pointer-events swiper-free-mode swiper-watch-progress swiper-backface-hidden swiper-thumbs">
                                                    <div class="swiper-wrapper" id="swiper-wrapper-5cfbae4a8a7875fe" aria-live="polite" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                                                        @foreach ($carData['images'] as $image)
                                                        <div class="swiper-slide swiper-slide-active" id="img-container" role="group" aria-label="1 / 4" style="width: 409px; margin-right: 10px;">
                                                            <img class="img-fluid" src="{{ asset($image ?? '/assets/images/media/chatdark.png')}}" alt="img">
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                                                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                                                </div>
                                            </div>
                                            <div class="col-xxl-12 col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-md-5 mb-3">
                                                <div class="border rounded-3 p-3 mb-3">
                                                    <p class="fs-16 fw-semibold mb-2">{{trans_dynamic('selected_insurance_package')}}</p>
                                                    <hr style="border-top: 1px solid rgb(184, 184, 184);">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="row">
                                                                <div class="col-xl-5">
                                                                    <span class="fs-14 fw-semibold">{{$insurancePackage['deductible'] ?? '0'}} € SB</span>
                                                                </div>
                                                                <div class="col-xl-7">
                                                                    <p class="text-muted fs-14">+{{$insurancePackage['price_per_day'] ?? '0'}} €/{{trans_dynamic('day')}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="border rounded-3 p-3 mb-3">
                                                    <p class="fs-16 fw-semibold mb-2">{{trans_dynamic('selected_kilometer_package')}}</p>
                                                    <hr style="border-top: 1px solid rgb(184, 184, 184);">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="row">
                                                                <div class="col-xl-5">
                                                                    <span class="fs-14 fw-semibold">{{$kmPackage['kilometers'] ?? '0'}} {{trans_dynamic('extra')}} KM</span>
                                                                </div>
                                                                <div class="col-xl-7">
                                                                    <p class="text-muted fs-14">+{{$kmPackage['extra_price'] ?? '0'}}/KM €</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-8 col-xl-12">
                                        <div class="row g-0 product-scroll rounded-3 p-3 px-0">
                                            <div class="col-xl-6 mt-xxl-0 mt-3">
                                                <div>
                                                    <p class="fs-18 fw-semibold mb-0">{{$carData['car']['brand']}} {{$carData['car']['model']}} ({{$carData['number_plate']}}) <br> <small>{{$contract->start_date}} - {{$contract->end_date}}</small></p>
                                                    <div class="row mb-4 mt-3">
                                                        <div class="col-xxl-6 col-xl-12">
                                                            <div class="d-flex align-items-center">
                                                                <h3 class="mb-1 fw-semibold">{{trans_dynamic('total')}} {{trans_dynamic('amount')}}: <span>{{$contract->total_amount}} €</span></h3>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    @php
                                                    $carData = json_decode($contract->car, true);
                                                    if (is_string($contract->customer)) {
                                                        $customerData = json_decode($contract->customer, true); // JSON string ise diziye çevir
                                                    } else {
                                                        // Zaten bir dizi ise, doğrudan kullan
                                                        $customerData = $contract->customer;
                                                    }
                                                    $customerIdentityData = $customerData['identity'];
                                                    if (is_string($customerIdentityData)) {
                                                        $customerIdentityData = json_decode($customerData['identity'], true); // JSON string ise diziye çevir
                                                    } else {
                                                        // Zaten bir dizi ise, doğrudan kullan
                                                        $customerIdentityData = $customerData['identity'];
                                                    }
                                                    $customerDrivingData = $customerData['driving_licence'];
                                                    $customerDrivingData = $customerData['driving_licence'];
                                                    if (is_string($customerDrivingData)) {
                                                        $customerDrivingData = json_decode($customerData['driving_licence'], true); // JSON string ise diziye çevir
                                                    } else {
                                                        // Zaten bir dizi ise, doğrudan kullan
                                                        $customerDrivingData = $customerData['driving_licence'];
                                                    }
                                                    $customerDataAddress = $customerData['address'];
                                                    if (is_string($customerDataAddress)) {
                                                        $customerDataAddress = json_decode($customerData['address'],true); // JSON string ise diziye çevir
                                                    } else {
                                                        $customerDataAddress = $customerData['address'];
                                                    }

                                                    $endDate = \Carbon\Carbon::parse($contract->end_date); // Bitiş tarihini Carbon ile parse ettik
                                                    $now = \Carbon\Carbon::now(); // Şu anki tarih
                                                    $daysRemaining = $endDate->diffInDays($now); // Kalan gün sayısını hesapladık
                                                    $isExpired = $endDate->isPast(); // Sürenin dolup dolmadığını kontrol ettik
                                                    $almostExpired = $daysRemaining <= 1; // Sürenin dolmasına 1 gün kaldı mı kontrol ettik
                                                    @endphp
                                                    <div class="mb-4">
                                                        @if ($isExpired)
                                                        <span class="badge bg-danger me-2 mb-2">>{{trans_dynamic('expired')}}</span>
                                                        @elseif ($almostExpired)
                                                        @if ($contract->status == 1)
                                                        <span class="badge bg-success me-2 mb-2">>{{trans_dynamic('was_delivered')}}</span>
                                                        @elseif($contract->status == 2)
                                                        <span class="badge bg-danger me-2 mb-2">>{{trans_dynamic('not_signed')}}</span>
                                                        @elseif($contract->status == 3)
                                                        <span class="badge  bg-dark-transparent me-2 mb-2">>{{trans_dynamic('draft')}}</span>
                                                        @elseif($contract->status == 4)
                                                        <span class="badge bg-danger me-2 mb-2">>{{trans_dynamic('cancelled')}}</span>
                                                        @elseif($contract->status == 5)
                                                        <span class="badge bg-success me-2 mb-2">>{{trans_dynamic('received')}}</span>
                                                        @elseif($contract->status == 6)
                                                        <span class="badge bg-success me-2 mb-2">>{{trans_dynamic('completed')}}</span>
                                                        @endif
                                                        <br>
                                                        @if ($contract->status == 3)
                                                        <a href="{{route('contracts.deliver', $contract->id)}}" class="btn btn-success-light btn-sm" data-bs-title="Deliver"><i class="ri ri-car-washing-fill"></i> {{trans_dynamic('handover')}}</a>
                                                        @elseif($contract->status == 1)
                                                        <a href="{{route('contracts.pickup', $contract->id)}}" class="btn btn-danger-light btn-sm" data-bs-title="Pickup"><i class="ri ri-car-line"></i> {{trans_dynamic('pickup')}}</a>
                                                        <button data-bs-toggle="modal" data-bs-target="#damagesModal" class="btn btn-danger btn-sm">{{trans_dynamic('damages')}}</button>
                                                        <div class="modal fade" id="damagesModal" tabindex="-1" aria-labelledby="damagesModal" data-bs-keyboard="false" style="display: none;" aria-hidden="true">
                                                            <!-- Scrollable modal -->
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title" id="staticBackdropLabel2">{{trans_dynamic('damages')}}
                                                                        </h6>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="card custom-card">
                                                                                    <div class="card-header">
                                                                                        <div class="card-title">
                                                                                            {{trans_dynamic('fuel_level')}}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <input type="range" disabled name="fuel_status" class="form-range" min="0" max="100" step="10" value="{{$carData['fuel_status']}}" id="customRange3" style="float: left; width: 80%;">
                                                                                        <p id="fuellevel">{{$carData['fuel_status']}}%</p>
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
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @elseif($contract->status == 5)
                                                        <a href="{{route('contracts.invoice', $contract->id)}}" class="btn btn-success btn-sm" data-bs-title="Invoice"><i class="bx bx-archive"></i> {{trans_dynamic('invoice_add')}}</a>
                                                        @elseif($contract->status == 6)
                                                        
                                                        @if(isset($invoice))
                                                        <a href="{{route('invoices.show', $invoice->id)}}" class="btn btn-primary btn-sm" data-bs-title="Invoice"><i class="bx bx-eye"></i> {{trans_dynamic('invoice_show')}}</a>
                                                        @endif
                                                        
                                                        @endif
                                                        
                                                        @if ($contract->status == 2 && $contract->signature == null)
                                                        <a href="{{route('contracts.sign', $contract->id)}}" class="btn btn-warning-light btn-sm" data-bs-title="Sign"><i class="ri ri-pen-nib-line"></i> {{trans_dynamic('sign')}}</a>
                                                        <button data-bs-toggle="modal" data-bs-target="#damagesModal" class="btn btn-danger btn-sm">{{trans_dynamic('damages')}}</button>
                                                        <div class="modal fade" id="damagesModal" tabindex="-1" aria-labelledby="damagesModal" data-bs-keyboard="false" style="display: none;" aria-hidden="true">
                                                            <!-- Scrollable modal -->
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title" id="staticBackdropLabel2">{{trans_dynamic('damages')}}
                                                                        </h6>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="card custom-card">
                                                                                    <div class="card-header">
                                                                                        <div class="card-title">
                                                                                            {{trans_dynamic('fuel_level')}}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <input type="range" disabled name="fuel_status" class="form-range" min="0" max="100" step="10" value="{{$carData['fuel_status']}}" id="customRange3" style="float: left; width: 80%;">
                                                                                        <p id="fuellevel">{{$carData['fuel_status']}}%</p>
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
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($contract->status != 4 && $contract->status != 5 && $contract->status != 6)
                                                        <a href="#" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Expires in day"><i class="bi bi-calendar-plus"></i> {{trans_dynamic('extra')}} {{trans_dynamic('day')}}</a>
                                                        <form action="{{ route('contracts.resend', $contract->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" style="background-color: rgb(226, 29, 147) !important; color:white;" class="btn btn-sm">
                                                                {{trans_dynamic('resend_the_contract')}}
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('contract.cancel', $contract->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-warning btn-sm ">{{trans_dynamic('contract')}} {{trans_dynamic('cancelled')}}</button>
                                                        </form>
                                                        @endif
                                                        
                                                        @else
                                                        @if ($contract->status == 1)
                                                        <span class="badge bg-success me-2 mb-2">{{trans_dynamic('was_delivered')}}</span>
                                                        @elseif($contract->status == 2)
                                                        <span class="badge bg-danger me-2 mb-2">{{trans_dynamic('not_signed')}}</span>
                                                        @elseif($contract->status == 3)
                                                        <span class="badge  bg-dark-transparent me-2 mb-2">{{trans_dynamic('draft')}}</span>
                                                        @elseif($contract->status == 4)
                                                        <span class="badge bg-danger me-2 mb-2">{{trans_dynamic('cancelled')}}</span>
                                                        @elseif($contract->status == 5)
                                                        <span class="badge bg-success me-2 mb-2">{{trans_dynamic('received')}}</span>
                                                        @endif
                                                        <br>
                                                        @if ($contract->status == 3)
                                                        <a href="{{route('contracts.deliver', $contract->id)}}" class="btn btn-success-light btn-sm" data-bs-title="Deliver"><i class="ri ri-car-washing-fill"></i> {{trans_dynamic('handover')}}</a>
                                                        @elseif($contract->status == 1)
                                                        <a href="{{route('contracts.pickup', $contract->id)}}" class="btn btn-danger-light btn-sm" data-bs-title="Pickup"><i class="ri ri-car-line"></i> {{trans_dynamic('pickup')}}</a>
                                                        <button data-bs-toggle="modal" data-bs-target="#damagesModal" class="btn btn-danger btn-sm">{{trans_dynamic('damages')}}</button>
                                                        <div class="modal fade" id="damagesModal" tabindex="-1" aria-labelledby="damagesModal" data-bs-keyboard="false" style="display: none;" aria-hidden="true">
                                                            <!-- Scrollable modal -->
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title" id="staticBackdropLabel2">{{trans_dynamic('damages')}}
                                                                        </h6>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="card custom-card">
                                                                                    <div class="card-header">
                                                                                        <div class="card-title">
                                                                                            {{trans_dynamic('fuel_level')}}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <input type="range" disabled name="fuel_status" class="form-range" min="0" max="100" step="10" value="{{$carData['fuel_status']}}" id="customRange3" style="float: left; width: 80%;">
                                                                                        <p id="fuellevel">{{$carData['fuel_status']}}%</p>
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
                                                                                                        name="options_detail[triangle_reflector]" id="triangle_reflector_yes" value="yes" 
                                                                                                        {{ isset($deliverOptions['triangle_reflector']) && $deliverOptions['triangle_reflector'] == 'yes' ? 'checked' : '' }}>
                                                                                                        <label class="form-check-label" for="triangle_reflector_yes">
                                                                                                            Yes
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <div class="form-check form-check-inline ms-3">
                                                                                                        <input disabled class="form-check-input option-radio" type="radio" 
                                                                                                        name="options_detail[triangle_reflector]" id="triangle_reflector_no" value="no" 
                                                                                                        {{ isset($deliverOptions['triangle_reflector']) && $deliverOptions['triangle_reflector'] == 'no' ? 'checked' : '' }}>
                                                                                                        <label class="form-check-label" for="triangle_reflector_no">
                                                                                                            No
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
                                                                                                        name="options_detail[reflective_vest]" id="reflective_vest_yes" value="yes" 
                                                                                                        {{ isset($deliverOptions['reflective_vest']) && $deliverOptions['reflective_vest'] == 'yes' ? 'checked' : '' }}>
                                                                                                        <label class="form-check-label" for="reflective_vest_yes">
                                                                                                            Yes
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <div class="form-check form-check-inline ms-3">
                                                                                                        <input disabled class="form-check-input option-radio" type="radio" 
                                                                                                        name="options_detail[reflective_vest]" id="reflective_vest_no" value="no" 
                                                                                                        {{ isset($deliverOptions['reflective_vest']) && $deliverOptions['reflective_vest'] == 'no' ? 'checked' : '' }}>
                                                                                                        <label class="form-check-label" for="reflective_vest_no">
                                                                                                            No
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
                                                                                                        name="options_detail[first_aid_kit]" id="first_aid_kit_yes" value="yes" 
                                                                                                        {{ isset($deliverOptions['first_aid_kit']) && $deliverOptions['first_aid_kit'] == 'yes' ? 'checked' : '' }}>
                                                                                                        <label class="form-check-label" for="first_aid_kit_yes">
                                                                                                            Yes
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <div class="form-check form-check-inline ms-3">
                                                                                                        <input disabled class="form-check-input option-radio" type="radio" 
                                                                                                        name="options_detail[first_aid_kit]" id="first_aid_kit_no" value="no" 
                                                                                                        {{ isset($deliverOptions['first_aid_kit']) && $deliverOptions['first_aid_kit'] == 'no' ? 'checked' : '' }}>
                                                                                                        <label class="form-check-label" for="first_aid_kit_no">
                                                                                                            No
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
                                                                                                        name="options_detail[clean]" id="clean_yes" value="yes" 
                                                                                                        {{ isset($deliverOptions['clean']) && $deliverOptions['clean'] == 'yes' ? 'checked' : '' }}>
                                                                                                        <label class="form-check-label" for="clean_yes">
                                                                                                            Yes
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <div class="form-check form-check-inline ms-3">
                                                                                                        <input disabled class="form-check-input option-radio" type="radio" 
                                                                                                        name="options_detail[clean]" id="clean_no" value="no" 
                                                                                                        {{ isset($deliverOptions['clean']) && $deliverOptions['clean'] == 'no' ? 'checked' : '' }}>
                                                                                                        <label class="form-check-label" for="clean_no">
                                                                                                            No
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
                                                        @elseif($contract->status == 5)
                                                        <a href="{{route('contracts.invoice', $contract->id)}}" class="btn btn-success btn-sm" data-bs-title="Invoice"><i class="bx bx-archive"></i> {{trans_dynamic('inovice')}}</a>
                                                        @endif
                                                        
                                                        @if ($contract->status == 2 && $contract->signature == null)
                                                        <a href="{{route('contracts.sign', $contract->id)}}" class="btn btn-warning-light btn-sm" data-bs-title="Sign"><i class="ri ri-pen-nib-line"></i> Sign</a>
                                                        <button data-bs-toggle="modal" data-bs-target="#damagesModal" class="btn btn-danger btn-sm">{{trans_dynamic('damages')}}</button>
                                                        <div class="modal fade" id="damagesModal" tabindex="-1" aria-labelledby="damagesModal" data-bs-keyboard="false" style="display: none;" aria-hidden="true">
                                                            <!-- Scrollable modal -->
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title" id="staticBackdropLabel2">{{trans_dynamic('damages')}}
                                                                        </h6>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="card custom-card">
                                                                                    <div class="card-header">
                                                                                        <div class="card-title">
                                                                                            {{trans_dynamic('fuel_level')}}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="card-body">
                                                                                        <input type="range" disabled name="fuel_status" class="form-range" min="0" max="100" step="10" value="{{$carData['fuel_status']}}" id="customRange3" style="float: left; width: 80%;">
                                                                                        <p id="fuellevel">{{$carData['fuel_status']}}%</p>
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
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($contract->status != 4 && $contract->status != 5)
                                                        <form action="{{ route('contracts.resend', $contract->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" style="background-color: rgb(226, 29, 147) !important; color:white;" class="btn btn-sm">
                                                                {{trans_dynamic('resend_the_contract')}}
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('contract.cancel', $contract->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-warning btn-sm ">{{trans_dynamic('contract')}} {{trans_dynamic('cancelled')}}</button>
                                                        </form>
                                                        @endif
                                                        @endif
                                                        
                                                    </div>
                                                    
                                                    <div class="mb-4">
                                                        <p class="fs-15 fw-semibold mb-1">{{trans_dynamic('description')}}:</p>
                                                        <p class="text-muted mb-0">
                                                            {{$carData['car']['brand']}} {{$carData['car']['model']}} - {{$carData['color']}}, {{$carData['horse_power']}} PS, 2022 model. This vehicle is high
                                                            It attracts attention with its performance and comfort. daily rental
                                                            The fee is {{$carData['prices']['daily_price']}} € and there is a daily limit of {{$carData['daily_kilometer'] ?? '0'}} km.
                                                            Extra kilometer fee is {{$carData['prices']['price_per_extra_kilometer']}} €.
                                                            
                                                            
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="mb-4">
                                                        <p class="fs-15 fw-semibold mb-1">{{trans_dynamic('customer')}}:</p>
                                                        <p class="text-muted mb-0">
                                                            {{$customerData['name'] ?? 'N/A'}} {{$customerData['surname'] ?? 'N/A'}} - {{$customerData['phone'] ?? 'N/A'}} - {{$customerData['email'] ?? 'N/A'}} - {{$customerDataAddress['street'] ?? 'N/A'}}, {{$customerDataAddress['zip_code'] ?? 'N/A'}} {{$customerDataAddress['city'] ?? 'N/A'}}, {{$customerDataAddress['country'] ?? 'N/A'}}
                                                        </p>
                                                        <div class="row mt-3">
                                                            <div class="col-xl-3 col-sm-12">
                                                                <p class="text-muted mb-0">{{trans_dynamic('driver_card_front')}}</p>
                                                                <img class="w-100" src="{{asset('/')}}{{$customerIdentityData['front'] ?? 'N/A'}}" alt="">
                                                            </div>
                                                            <div class="col-xl-3 col-sm-12">
                                                                <p class="text-muted mb-0">{{trans_dynamic('driver_card_back')}}</p>
                                                                <img class="w-100" src="{{asset('/')}}{{$customerIdentityData['back'] ?? 'N/A'}}" alt="">
                                                            </div>
                                                            <div class="col-xl-3 col-sm-12">
                                                                <p class="text-muted mb-0">{{trans_dynamic('id_card_front')}}</p>
                                                                <img class="w-100" src="{{asset('/')}}{{$customerDrivingData['front'] ?? 'N/A'}}" alt="">
                                                            </div>
                                                            <div class="col-xl-3 col-sm-12">
                                                                <p class="text-muted mb-0">{{trans_dynamic('id_card_back')}}</p>
                                                                <img class="w-100" src="{{asset('/')}}{{$customerDrivingData['back'] ?? 'N/A'}}" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 mt-xxl-0 mt-3">
                                                <div class="mb-3 border p-3 rounded-3">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <ul class="ps-3 mb-0">
                                                                <ul class="ps-3 mb-0">
                                                                    <li class="text-muted mb-2">
                                                                        <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                        {{trans_dynamic('horse_power')}}: {{$carData['horse_power']}} PS
                                                                    </li>
                                                                    <li class="text-muted mb-2">
                                                                        <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                        {{trans_dynamic('vin')}}: {{$carData['vin']}}
                                                                    </li>
                                                                    <li class="text-muted mb-2">
                                                                        <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                        {{trans_dynamic('color')}}: {{$carData['color']}}
                                                                    </li>
                                                                    <li class="text-muted mb-2">
                                                                        <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                        {{trans_dynamic('date_to_traffic')}}: {{$carData['date_to_traffic'] ?? 'N/A'}}
                                                                    </li>
                                                                    <li class="text-muted mb-2">
                                                                        <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                        {{trans_dynamic('number_plate')}}: {{$carData['number_plate']}}
                                                                    </li>
                                                                    <li class="text-muted mb-2">
                                                                        <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                        {{trans_dynamic('min_age')}}: {{$carData['age']}}
                                                                    </li>
                                                                    <li class="text-muted mb-2">
                                                                        <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                        {{trans_dynamic('odometer')}}: {{$carData['odometer']}} km
                                                                    </li>
                                                                    <li class="text-muted mb-2">
                                                                        <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                        {{trans_dynamic('daily_kilometer')}}: {{$carData['kilometers']['daily_kilometer'] ?? 'N/A'}} km
                                                                    </li>
                                                                    <li class="text-muted mb-2">
                                                                        <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                        {{trans_dynamic('car_group')}}: {{$carData['car_group']}}
                                                                    </li>
                                                                    <li class="text-muted mb-2">
                                                                        <i class="bx bxs-circle fs-6 me-2 op-5"></i>
                                                                        {{trans_dynamic('fuel')}}: {{$carData['fuel']}}
                                                                    </li>
                                                                </ul>
                                                                
                                                            </ul>
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
                <!--End::row-1 -->
                
                
                @if($contract->status == 5)
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xxl-12 col-xl-12">
                                <div class="row">
                                    <div class="col-xxl-12 col-xl-12">
                                        @if($contract->extra_km)
                                        <div class="alert alert-warning" role="alert">
                                            {{trans_dynamic('extra')}} {{$contract->extra_km}} {{trans_dynamic('kilometer')}} {{trans_dynamic('used')}}
                                        </div>
                                        @endif
                                        <div class="card-title mb-3"><h6>{{trans_dynamic('tocompare')}}</h6></div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="card-title"><strong>{{trans_dynamic('handover')}}</strong></div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="card custom-card">
                                                    <div class="card-header">
                                                        <div class="card-title">
                                                            {{trans_dynamic('fuel_level')}}
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <input type="range" disabled name="fuel_status" class="form-range" min="0" max="100" step="10" value="{{$carData['fuel_status']}}" id="customRange3" style="float: left; width: 80%;">
                                                        <p id="fuellevel">{{$carData['fuel_status']}}%</p>
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
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="card custom-card">
                                                    <div class="card-header">
                                                        <div class="card-title">
                                                            {{trans_dynamic('handover')}} {{trans_dynamic('options')}}
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
                                                                    name="optionsDeliver[triangle_reflector]" id="triangle_reflector_yes" value="yes" 
                                                                    {{ isset($deliverOptions['triangle_reflector']) && $deliverOptions['triangle_reflector'] == 'yes' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="triangle_reflector_yes">
                                                                        {{trans_dynamic('yes')}}
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline ms-3">
                                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                                    name="optionsDeliver[triangle_reflector]" id="triangle_reflector_no" value="no" 
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
                                                                    name="optionsDeliver[reflective_vest]" id="reflective_vest_yes" value="yes" 
                                                                    {{ isset($deliverOptions['reflective_vest']) && $deliverOptions['reflective_vest'] == 'yes' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="reflective_vest_yes">
                                                                        {{trans_dynamic('yes')}}
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline ms-3">
                                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                                    name="optionsDeliver[reflective_vest]" id="reflective_vest_no" value="no" 
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
                                                                    name="optionsDeliver[first_aid_kit]" id="first_aid_kit_yes" value="yes" 
                                                                    {{ isset($deliverOptions['first_aid_kit']) && $deliverOptions['first_aid_kit'] == 'yes' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="first_aid_kit_yes">
                                                                        {{trans_dynamic('yes')}}
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline ms-3">
                                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                                    name="optionsDeliver[first_aid_kit]" id="first_aid_kit_no" value="no" 
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
                                                                    name="optionsDeliver[clean]" id="clean_yes" value="yes" 
                                                                    {{ isset($deliverOptions['clean']) && $deliverOptions['clean'] == 'yes' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="clean_yes">
                                                                        {{trans_dynamic('yes')}}
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline ms-3">
                                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                                    name="optionsDeliver[clean]" id="clean_no" value="no" 
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
                                    <div class="col-xl-6">
                                        <div class="card-title"><strong>{{trans_dynamic('pickup')}}</strong></div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="card custom-card">
                                                    <div class="card-header">
                                                        <div class="card-title">
                                                            {{trans_dynamic('fuel_level')}}
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <input type="range" disabled name="fuel_status" class="form-range" min="0" max="100" step="10" value="{{$carData['fuel_status']}}" id="customRange5" style="float: left; width: 80%;">
                                                        <p id="fuelleve2">{{$contract->fuel_status}}%</p>
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
                                                                    @php
                                                                    $counter = 1; 
                                                                    // dd($pickupDamages);// Sayacı tanımlıyoruz
                                                                    @endphp
                                                                    
                                                                    @foreach ($pickupDamages as $damage)
                                                                    <div class="damage-marker" style="left: {{$damage['coordinates']['x']}}%; top: {{$damage['coordinates']['y']}}%;">X<span class="marker-number">{{$counter}}</span></div>
                                                                    @php
                                                                    $counter++; // Sayacı her döngüde artırıyoruz
                                                                    @endphp
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                            <ul class="list-group mb-3" id="default-damages-list">
                                                                @php
                                                                $counter = 1; 
                                                                // dd($pickupDamages);// Sayacı tanımlıyoruz
                                                                @endphp
                                                                
                                                                @foreach ($pickupDamages as $damage)
                                                                <li class="list-group-item example-damage">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="avatar avatar-sm">
                                                                            <img src="{{asset('/') }}{{$damage['photo']}}" alt="img"> <!-- Dizi indexi ile erişiyoruz -->
                                                                        </span>
                                                                        <div class="ms-2 fw-semibold">
                                                                            <div style="color: red;">X<span class="marker-number">{{ $counter }}</span></div> <!-- Sayacı gösteriyoruz -->
                                                                            <div>{{ $damage['description'] }}</div> <!-- Dizi indexi ile erişiyoruz -->
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                
                                                                @php
                                                                $counter++; // Sayacı her döngüde artırıyoruz
                                                                @endphp
                                                                @endforeach
                                                            </ul>
                                                            
                                                            <div id="damage-forms-container"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-12">
                                                <div class="card custom-card">
                                                    <div class="card-header">
                                                        <div class="card-title">{{trans_dynamic('pickup')}} {{trans_dynamic('options')}}</div>
                                                    </div>
                                                    <div class="card-body">
                                                        
                                                        <div class="form-check d-flex align-items-center justify-content-between mb-2">
                                                            <label class="form-check-label me-2" for="triangle_reflector">{{trans_dynamic('triangle_reflector')}}</label>
                                                            <div class="d-flex">
                                                                <div class="form-check form-check-inline">
                                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                                    name="options_pickup[triangle_reflector]" id="triangle_reflector_yes" value="yes" 
                                                                    {{ isset($pickupOptions['triangle_reflector']) && $pickupOptions['triangle_reflector'] == 'yes' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="triangle_reflector_yes">{{trans_dynamic('yes')}}</label>
                                                                </div>
                                                                <div class="form-check form-check-inline ms-3">
                                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                                    name="options_pickup[triangle_reflector]" id="triangle_reflector_no" value="no" 
                                                                    {{ isset($pickupOptions['triangle_reflector']) && $pickupOptions['triangle_reflector'] == 'no' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="triangle_reflector_no">{{trans_dynamic('no')}}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- Triangle Reflector --}}
                                                        @if(isset($deliverOptions['triangle_reflector']) && $pickupOptions['triangle_reflector'] !== $deliverOptions['triangle_reflector'])
                                                        <div class="alert alert-warning">
                                                            {{trans_dynamic('triangle_reflector_message')}}: {{trans_dynamic('delivered')}} - {{ $deliverOptions['triangle_reflector'] }}, {{trans_dynamic('picked_up')}} - {{ $pickupOptions['triangle_reflector'] }}.
                                                        </div>
                                                        @endif
                                                        
                                                        <div class="form-check d-flex align-items-center justify-content-between mb-2">
                                                            <label class="form-check-label me-2" for="reflective_vest">{{trans_dynamic('reflective_vest')}}</label>
                                                            <div class="d-flex">
                                                                <div class="form-check form-check-inline">
                                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                                    name="options_pickup[reflective_vest]" id="reflective_vest_yes" value="yes" 
                                                                    {{ isset($pickupOptions['reflective_vest']) && $pickupOptions['reflective_vest'] == 'yes' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="reflective_vest_yes">{{trans_dynamic('yes')}}</label>
                                                                </div>
                                                                <div class="form-check form-check-inline ms-3">
                                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                                    name="options_pickup[reflective_vest]" id="reflective_vest_no" value="no" 
                                                                    {{ isset($pickupOptions['reflective_vest']) && $pickupOptions['reflective_vest'] == 'no' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="reflective_vest_no">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- Reflective Vest --}}
                                                        @if(isset($deliverOptions['reflective_vest']) && $pickupOptions['reflective_vest'] !== $deliverOptions['reflective_vest'])
                                                        <div class="alert alert-warning">
                                                            {{trans_dynamic('reflective_vest_message')}}: {{trans_dynamic('delivered')}} - {{ $deliverOptions['reflective_vest'] }}, {{trans_dynamic('picked_up')}} - {{ $pickupOptions['reflective_vest'] }}.
                                                        </div>
                                                        @endif
                                                        
                                                        <div class="form-check d-flex align-items-center justify-content-between mb-2">
                                                            <label class="form-check-label me-2" for="first_aid_kit">{{trans_dynamic('first_aid_kit')}}</label>
                                                            <div class="d-flex">
                                                                <div class="form-check form-check-inline">
                                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                                    name="options_pickup[first_aid_kit]" id="first_aid_kit_yes" value="yes" 
                                                                    {{ isset($pickupOptions['first_aid_kit']) && $pickupOptions['first_aid_kit'] == 'yes' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="first_aid_kit_yes">{{trans_dynamic('yes')}}</label>
                                                                </div>
                                                                <div class="form-check form-check-inline ms-3">
                                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                                    name="options_pickup[first_aid_kit]" id="first_aid_kit_no" value="no" 
                                                                    {{ isset($pickupOptions['first_aid_kit']) && $pickupOptions['first_aid_kit'] == 'no' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="first_aid_kit_no">{{trans_dynamic('no')}}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- First Aid Kit --}}
                                                        @if(isset($deliverOptions['first_aid_kit']) && $pickupOptions['first_aid_kit'] !== $deliverOptions['first_aid_kit'])
                                                        <div class="alert alert-warning">
                                                            {{trans_dynamic('first_aid_kit_message')}}: {{trans_dynamic('delivered')}} - {{ $deliverOptions['first_aid_kit'] }}, {{trans_dynamic('picked_up')}} - {{ $pickupOptions['first_aid_kit'] }}.
                                                        </div>
                                                        @endif
                                                        
                                                        <div class="form-check d-flex align-items-center justify-content-between mb-2">
                                                            <label class="form-check-label me-2" for="clean">{{trans_dynamic('it_clean')}}</label>
                                                            <div class="d-flex">
                                                                <div class="form-check form-check-inline">
                                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                                    name="options_pickup[clean]" id="clean_yes" value="yes" 
                                                                    {{ isset($pickupOptions['clean']) && $pickupOptions['clean'] == 'yes' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="clean_yes">{{trans_dynamic('yes')}}</label>
                                                                </div>
                                                                <div class="form-check form-check-inline ms-3">
                                                                    <input disabled class="form-check-input option-radio" type="radio" 
                                                                    name="options_pickup[clean]" id="clean_no" value="no" 
                                                                    {{ isset($pickupOptions['clean']) && $pickupOptions['clean'] == 'no' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="clean_no">{{trans_dynamic('no')}}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- Clean --}}
                                                        @if(isset($deliverOptions['clean']) && $pickupOptions['clean'] !== $deliverOptions['clean'])
                                                        <div class="alert alert-warning">
                                                            {{trans_dynamic('clean_lines_message')}}: {{trans_dynamic('delivered')}} - {{ $deliverOptions['clean'] }}, {{trans_dynamic('picked_up')}} - {{ $pickupOptions['clean'] }}.
                                                        </div>
                                                        @endif
                                                        
                                                        <div class="form-check d-flex align-items-center justify-content-between mb-2">
                                                            <label class="form-check-label me-2" for="tire_profile">{{trans_dynamic('vehicle_tire_profile')}}</label>
                                                            <div class="col-xl-6">
                                                                <div class="input-group has-validation">
                                                                    @php
                                                                    $tireProfileValue = isset($pickupOptions['tire_profile']) ? $pickupOptions['tire_profile'] : '';
                                                                    if (is_array($tireProfileValue)) {
                                                                        $tireProfileValue = implode(', ', $tireProfileValue);
                                                                    }
                                                                    @endphp
                                                                    <input disabled name="tire_profile" class="form-control"  value="{{ htmlspecialchars($tireProfileValue, ENT_QUOTES, 'UTF-8') }}" id="tire_profile" placeholder="Tire Profile">
                                                                    <span class="input-group-text" id="tire_profile">MM</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Tire Profile --}}
                                                        @if(isset($deliverOptions['tire_profile']) || isset($pickupOptions['tire_profile']))
                                                        @if(
                                                        (isset($deliverOptions['tire_profile']) && !isset($pickupOptions['tire_profile'])) || 
                                                        (!isset($deliverOptions['tire_profile']) && isset($pickupOptions['tire_profile'])) || 
                                                        (isset($deliverOptions['tire_profile']) && isset($pickupOptions['tire_profile']) && $pickupOptions['tire_profile'] !== $deliverOptions['tire_profile'])
                                                        )
                                                        <div class="alert alert-warning">
                                                            {{trans_dynamic('tire_profile_message')}}: 
                                                            {{trans_dynamic('delivered')}} - {{ $deliverOptions['tire_profile'] ?? 'not provided' }}, 
                                                            {{trans_dynamic('picked_up')}} - {{ $pickupOptions['tire_profile'] ?? 'not provided' }}.
                                                        </div>
                                                        @endif
                                                        @endif
                                                        
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
                @endif
            </div>
        </div>
        <!-- End::app-content -->
        
        <script>
            const damagesNested = {!! json_encode($carData['damages']) !!};            
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
        @endsection