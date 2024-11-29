@extends('layouts.layout')
@section('title', $title)
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
</style>
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">{{trans_dynamic('customer')}} - {{$title}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-white-50">{{trans_dynamic('home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('customer')}} - {{$title}}</li>
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
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body d-sm-flex align-items-top p-4   main-profile-cover">
                        <div class="flex-fill main-profile-info my-auto">
                            <h5 class="fw-semibold mb-1 ">{{$title}}</h5>
                            <div>
                                <p class="mb-1 text-muted">{{trans_dynamic('birthday')}}: {{$customer->date_of_birth}}</p>
                                <div class="fs-12 op-7 mb-0 d-flex">
                                    <p class="me-3 mb-0">
                                        <i class="ri-building-line me-1 align-middle d-inline-flex"></i>
                                        {{ isset(json_decode($customer->address, true)['street']) ? json_decode($customer->address, true)['street'] : 'N/A' }} ,
                                        {{ isset(json_decode($customer->address, true)['zip_code']) ? json_decode($customer->address, true)['zip_code'] : 'N/A' }}
                                        {{ isset(json_decode($customer->address, true)['city']) ? json_decode($customer->address, true)['city'] : 'N/A' }}
                                        , {{ isset(json_decode($customer->address, true)['country']) ? json_decode($customer->address, true)['country'] : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                            <div class="mb-0  mt-2">
                                <a href="{{route('customers.edit', $customer->id)}}" class="btn btn-success btn-sm btn-wave"><i class="bi bi-pencil me-1 align-middle"></i>{{trans_dynamic('edit')}} {{trans_dynamic('customer')}}</a>
                            </div>
                        </div>
                        <div class="main-profile-info ms-auto">
                            <div class="mb-0  mt-2 text-end">
                                <button type="button" class="btn btn-secondary btn-sm btn-wave"><i class="ri-add-line me-1 align-middle"></i>{{trans_dynamic('add_contract')}}</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3">
                <div class="card custom-card">
                    <div class="">
                        <div class="p-4  border-bottom border-block-end-dashed">
                            <p class="fs-15 mb-2 me-4 fw-semibold">{{trans_dynamic('customer')}} {{trans_dynamic('info')}}:</p>
                            <ul class="list-group">
                                <li class="list-group-item border-0">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div class="me-2 fw-semibold">
                                            {{trans_dynamic('name')}}:
                                        </div>
                                        <span class="fs-12 text-muted">{{$title}}</span>
                                    </div>
                                </li>
                                <li class="list-group-item border-0">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div class="me-2 fw-semibold">
                                            {{trans_dynamic('age')}}:
                                        </div>
                                        <span class="fs-12 text-muted">{{$age}}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="p-4 border-bottom border-block-end-dashed">
                            <p class="fs-15 mb-2 me-4 fw-semibold">{{trans_dynamic('contract')}} {{trans_dynamic('info')}}:</p>
                            <div class="text-muted">
                                <p class="mb-3">
                                    <span class="avatar avatar-sm avatar-rounded me-2 bg-info-transparent">
                                        <i class="ri-mail-line align-middle fs-14"></i>
                                    </span>
                                    {{$customer->email}}
                                </p>
                                <p class="mb-3">
                                    <span class="avatar avatar-sm avatar-rounded me-2 bg-warning-transparent">
                                        <i class="ri-phone-line align-middle fs-14"></i>
                                    </span>
                                    {{$customer->phone}}
                                </p>
                                <div class="d-flex">
                                    <p class="mb-0">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-success-transparent">
                                            <i class="ri-map-pin-line align-middle fs-14"></i>
                                        </span>
                                    </p>
                                    <p class="mb-0">
                                        {{ isset(json_decode($customer->address, true)['street']) ? json_decode($customer->address, true)['street'] : 'N/A' }},
                                        {{ isset(json_decode($customer->address, true)['zip_code']) ? json_decode($customer->address, true)['zip_code'] : 'N/A' }}
                                        {{ isset(json_decode($customer->address, true)['city']) ? json_decode($customer->address, true)['city'] : 'N/A' }}
                                        , {{ isset(json_decode($customer->address, true)['country']) ? json_decode($customer->address, true)['country'] : 'N/A' }}
                                    </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-4 border-bottom border-block-end-dashed">
                                <p class="fs-15 mb-2 me-4 fw-semibold">{{trans_dynamic('billing')}} {{trans_dynamic('info')}}:</p>
                                <div class="text-muted">
                                    
                                    <div class="d-flex">
                                        <p class="mb-0">
                                            <span class="avatar avatar-sm avatar-rounded me-2 bg-success-transparent">
                                                <i class="ri-map-pin-line align-middle fs-14"></i>
                                            </span>
                                        </p>
                                        <p class="mb-0">
                                            {{ isset(json_decode($customer->invoice_info, true)['street']) ? json_decode($customer->invoice_info, true)['street'] : 'N/A' }},
                                            {{ isset(json_decode($customer->invoice_info, true)['zip_code']) ? json_decode($customer->invoice_info, true)['zip_code'] : 'N/A' }}
                                            {{ isset(json_decode($customer->invoice_info, true)['city']) ? json_decode($customer->invoice_info, true)['city'] : 'N/A' }}
                                            , {{ isset(json_decode($customer->invoice_info, true)['country']) ? json_decode($customer->invoice_info, true)['country'] : 'N/A' }}
                                        </p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-9 col-xl-12">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class=" custom-card">
                                    <div class="card-body p-0">
                                        <div class="border-block-end-dashed  bg-white rounded-2 p-2">
                                            <div>
                                                <ul class="nav nav-pills nav-justified gx-3 tab-style-6 d-sm-flex d-block " id="myTab" role="tablist">
                                                    <li class="nav-item rounded" role="presentation">
                                                        <button class="nav-link active" id="activity-tab" data-bs-toggle="tab"
                                                        data-bs-target="#activity-tab-pane" type="button" role="tab"
                                                        aria-controls="activity-tab-pane" aria-selected="true"><i
                                                        class="ri-exchange-box-line me-1 align-middle d-inline-block fs-16"></i>Activity</button>
                                                    </li>
                                                    <li class="nav-item rounded" role="presentation">
                                                        <button class="nav-link" id="contracts-tab" data-bs-toggle="tab"
                                                        data-bs-target="#contracts-tab-pane" type="button" role="tab"
                                                        aria-controls="contracts-tab-pane" aria-selected="false"><i
                                                        class="ri-money-dollar-box-line me-1 align-middle d-inline-block fs-16"></i>{{trans_dynamic('contracts')}}</button>
                                                    </li>
                                                    <li class="nav-item rounded" role="presentation">
                                                        <button class="nav-link" id="IdDriver-tab" data-bs-toggle="tab"
                                                        data-bs-target="#IdDriver-tab-pane" type="button" role="tab"
                                                        aria-controls="IdDriver-tab-pane" aria-selected="false"><i
                                                        class="ri-money-dollar-box-line me-1 align-middle d-inline-block fs-16"></i>{{trans_dynamic('id_and_driver_card')}}</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="py-4">
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane show active fade p-0 border-0 bg-white p-4 rounded-3" id="activity-tab-pane" role="tabpanel" aria-labelledby="activity-tab" tabindex="0">
                                                    <ul class="list-unstyled profile-timeline">
                                                        @foreach($invoices as $invoice)
                                                            <li>
                                                                <span class="fs-12 text-muted fw-semibold text-end profile-timeline-time">
                                                                    {{ $invoice->created_at->format('d,M Y') }}
                                                                </span>
                                                                <div>
                                                                    <span class="avatar avatar-sm avatar-rounded profile-timeline-avatar">
                                                                        <img src="{{ asset('assets/images/demo_car.jpg') }}" alt="">
                                                                    </span>
                                                                    <p class="text-muted mb-2">
                                                                        <span class="text-default"><b>{{trans_dynamic('invoice')}} {{trans_dynamic('created')}} #{{$invoice->id}}</b></span>
                                                                    </p>
                                                                    <p class="text-muted fs-12 mb-0">
                                                                        <strong>{{ $invoice->created_at->format('d M Y H:i') }}</strong>
                                                                    </p>
                                                                    <div class="btn-group file-attach mt-3" role="group" aria-label="Basic example">
                                                                        <button type="button" class="btn btn-sm btn-danger-light">
                                                                            <a class="text-danger" href="{{ route('invoices.download', $invoice->id) }}"><span class="ri-file-line me-2"></span> {{trans_dynamic('invoice')}}-{{ $invoice->invoice_number }}.pdf</a>
                                                                        </button>
                                                                        <a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-sm btn-danger-light" aria-label="Close">
                                                                            <span class="ri-download-2-line"></span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                
                                                <div class="tab-pane fade p-0 border-0 bg-white" id="contracts-tab-pane"role="tabpanel" aria-labelledby="contracts-tab" tabindex="0">
                                                    <div class="p-4">
                                                        <table id="datatable-basic" class="table mt-3 table-bordered text-nowrap" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">{{trans_dynamic('contract')}} {{trans_dynamic('date')}}</th>
                                                                    <th scope="col">{{trans_dynamic('car')}}</th>
                                                                    <th scope="col">{{trans_dynamic('customer')}}</th>
                                                                    <th scope="col">{{trans_dynamic('status')}}</th>
                                                                    <th scope="col">{{trans_dynamic('detail')}}</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($contracts as $contract)
                                                                @php
                                                                    $carData = json_decode($contract->car, true);
                                                                    $customerData = $contract->customer;
                                                                    if(is_string($customerData)){
                                                                        $customerData = json_decode($contract->customer,true);
                                                                    }else{
                                                                        $customerData = $contract->customer;
                                                                    }
                                
                                                                    // end_date veya extra_date'i kullanarak tarih hesaplama
                                                                    $endDate = \Carbon\Carbon::parse($contract->end_date);
                                                                    $extraDate = $contract->extra_date ? \Carbon\Carbon::parse($contract->extra_date) : null;
                                
                                                                    // Eğer extra_date varsa endDate yerine onu kullan
                                                                    $effectiveEndDate = $extraDate ? $extraDate : $endDate;
                                
                                                                    $now = \Carbon\Carbon::now(); // Şu anki tarih
                                                                    $daysRemaining = $effectiveEndDate->diffInDays($now); // Kalan gün sayısını hesapladık
                                                                    $isExpired = $effectiveEndDate->isPast(); // Sürenin dolup dolmadığını kontrol ettik
                                                                    $almostExpired = $daysRemaining <= 1; // Sürenin dolmasına 1 gün kaldı mı kontrol ettik
                                                                @endphp
                                                                <tr @if ($isExpired) style="background-color: #000;" @endif>
                                                                    <td>
                                                                        {{$contract->created_at->format('d/m/Y H:i')}}
                                                                        @if($contract->status == 6)
                                                                        (<span class="text-success">{{trans_dynamic('completed')}}</span>)
                                                                        @else
                                                                        (
                                                                        @if ($isExpired)
                                                                        <span class="text-danger">{{trans_dynamic('expired')}}</span>
                                                                        @elseif ($almostExpired)
                                                                        <span class="text-danger">{{trans_dynamic('expires_in_1_day')}}</span>
                                                                        @else
                                                                        <span class="text-success">{{trans_dynamic('continues')}}</span>
                                                                        @endif
                                                                        )
                                                                        @endif
                                                                    </td>
                                                                    <td>{{$carData['car']['brand']}} {{$carData['car']['model']}}</td>
                                                                    <td>{{$customerData['name']}} {{$customerData['surname']}}</td>
                                                                    <td>
                                                                        @if ($isExpired)
                                                                        <span class="badge bg-danger">{{trans_dynamic('expired')}}</span>
                                                                        @else
                                                                        @if ($contract->status == 1)
                                                                        <span class="badge bg-primary">{{trans_dynamic('delivered')}}</span>
                                                                        @elseif($contract->status == 4)
                                                                        <span class="badge bg-danger">{{trans_dynamic('cancelled')}}</span>
                                                                        @elseif($contract->status == 3)
                                                                        <span class="badge bg-dark-transparent">{{trans_dynamic('draft')}}</span>
                                                                        @elseif($contract->status == 2 && $contract->signature == null)
                                                                        <span class="badge bg-warning">{{trans_dynamic('not_signed')}}</span>
                                                                        @elseif($contract->status == 5)
                                                                        <span class="badge bg-danger">{{trans_dynamic('pickup')}}</span>
                                                                        @elseif($contract->status == 6)
                                                                        <span class="badge bg-success">{{trans_dynamic('completed')}}</span>
                                                                        @endif
                                                                        @endif
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        @if ($isExpired)
                                                                        <a href="{{route('contracts.detail', $contract->id)}}" class="btn btn-primary-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('detail')}}"><i class="bi bi-eye"></i></a>
                                                                        @elseif ($contract->status != 4 && $contract->status != 5 && $contract->status != 6 && $almostExpired)
                                                                        <a href="{{route('contracts.detail', $contract->id)}}" class="btn btn-primary-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('detail')}}"><i class="bi bi-eye"></i></a>
                                                                        <a href="{{route('contracts.extradate', $contract->id)}}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('expires_in_1_day')}}"><i class="bi bi-calendar-plus"></i></a>
                                                                        @if ($contract->status == 3)
                                                                        <a href="{{route('contracts.deliver', $contract->id)}}" class="btn btn-success-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('handover')}}"><i class="ri ri-car-washing-fill"></i></a>
                                                                        @elseif($contract->status == 1)
                                                                        <a href="{{route('contracts.pickup', $contract->id)}}" class="btn btn-danger-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('pickup')}}"><i class="ri ri-car-line"></i></a>
                                                                        @elseif($contract->status == 5)
                                                                        <a href="{{route('contracts.invoice', $contract->id)}}" class="btn btn-success btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('invoice')}}"><i class="bx bx-archive"></i></a>
                                                                        @endif
                                                                        @if ($contract->status == 2 && $contract->signature == null)
                                                                        <a href="{{route('contracts.sign', $contract->id)}}" class="btn btn-warning-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('sign')}}"><i class="ri ri-pen-nib-line"></i></a>
                                                                        @endif
                                                                        @else
                                                                        <a href="{{route('contracts.detail', $contract->id)}}" class="btn btn-primary-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('detail')}}"><i class="bi bi-eye"></i></a>
                                                                        @if ($contract->status == 3)
                                                                        <a href="{{route('contracts.deliver', $contract->id)}}" class="btn btn-success-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('handover')}}"><i class="ri ri-car-washing-fill"></i></a>
                                                                        @elseif($contract->status == 1)
                                                                        <a href="{{ route('contracts.pdf', $contract->id) }}" class="btn btn-warning-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('download_pdf')}}"><i class="ri ri-file-pdf-line"></i></a>
                                                                        <a href="{{route('contracts.pickup', $contract->id)}}" class="btn btn-danger-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('pickup')}}"><i class="ri ri-car-line"></i></a>
                                                                        @elseif($contract->status == 5)
                                                                        <a href="{{route('contracts.invoice', $contract->id)}}" class="btn btn-success btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('invoice')}}"><i class="bx bx-archive"></i></a>
                                                                        @endif
                                                                        @if ($contract->status == 2 && $contract->signature == null)
                                                                        <a href="{{route('contracts.sign', $contract->id)}}" class="btn btn-warning-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('sign')}}"><i class="ri ri-pen-nib-line"></i></a>
                                                                        @endif
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                
                                                <div class="tab-pane fade p-0 border-0 bg-white" id="IdDriver-tab-pane"role="tabpanel" aria-labelledby="IdDriver-tab" tabindex="0">
                                                    <div class="p-4">
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
                                                                    <img src="{{asset('/'. $identityFront)}}" class="card-img-top" alt="...">
                                                                    <div class="card-body">
                                                                        <h6 class="card-title fw-semibold mb-0" style="text-align:center;">{{trans_dynamic('id_card_front')}} </h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-3 col-xl-12">
                                                                <div class="card custom-card">
                                                                    <a aria-label="anchor" href="javascript:void(0);" class="card-anchor"></a>
                                                                    <img src="{{asset('/'. $identityBack ?? '/assets/images/media/media-22.jpg')}}" class="card-img-top" alt="...">
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
        <!-- End::app-content -->
        
        
        @endsection