@extends('layouts.layout')
@section('title', 'Company Dashboard')
@section('content')
<div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
    <h4 class="fw-medium mb-0">{{trans_dynamic('dashboard')}}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">{{env('APP_NAME')}}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('dashboard')}}</li>
    </ol>
</div>
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="row row-cols-xxl-5 row-cols-xl-3 row-cols-md-2">
                    <div class="col card-background flex-fill">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <p class="fw-medium mb-1 text-muted">{{trans_dynamic('users')}}</p>
                                        <h3 class="mb-0">{{$userCount}}</h3>
                                    </div>
                                    <div class="avatar avatar-md br-4 bg-primary-transparent ms-auto">
                                        <i class="bx bxs-user-detail fs-20"></i>
                                    </div>
                                </div>
                                <div class="d-flex mt-2">
                                    <a href="{{route('persons')}}" class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{trans_dynamic('detail')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col card-background flex-fill">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <p class="fw-medium mb-1 text-muted">{{trans_dynamic('cars')}}</p>
                                        <h3 class="mb-0">{{$carCount}}</h3>
                                    </div>
                                    <div class="avatar avatar-md br-4 bg-secondary-transparent ms-auto">
                                        <i class="bx bx-car fs-20"></i>
                                    </div>
                                </div>
                                <div class="d-flex mt-2">
                                    <a href="{{route('cars')}}" class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{trans_dynamic('detail')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col card-background flex-fill">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <p class="fw-medium text-muted mb-1">{{trans_dynamic('contracts')}}</p>
                                        <h3 class="mb-0">{{$contractCount}}</h3>
                                    </div>
                                    <div class="avatar avatar-md br-4 bg-info-transparent ms-auto">
                                        <i class="bx bx-receipt fs-20"></i>
                                    </div>
                                </div>
                                <div class="d-flex mt-2">
                                    <a href="{{route('contracts')}}" class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{trans_dynamic('detail')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col card-background flex-fill">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <p class="fw-medium mb-1 text-muted">{{trans_dynamic('invoices')}}</p>
                                        <h3 class="mb-0">{{$invoiceCount}}</h3>
                                    </div>
                                    <div class="avatar avatar-md br-4 bg-danger-transparent ms-auto">
                                        <i class="bx bxs-receipt fs-20"></i>
                                    </div>
                                </div>
                                <div class="d-flex mt-2">
                                    <a href="{{route('invoices')}}" class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{trans_dynamic('detail')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col card-background flex-fill">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <p class="fw-medium text-muted mb-1">{{trans_dynamic('daily_gain')}}</p>
                                        <h3 class="mb-0">{{ number_format($dailyGain, 2) }} €</h3>
                                    </div>
                                    <div class="avatar avatar-md br-4 bg-warning-transparent ms-auto">
                                        <i class="bi bi-currency-euro fs-20"></i>
                                    </div>
                                </div>
                                <div class="d-flex mt-2">
                                    <a href="{{route('contracts')}}" class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{trans_dynamic('detail')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-1 -->
        <div class="row">
            <div class="col-xxl-3 col-xl-12">
                <div class="row">
                    <div class="col-xxl-12 col-xl-6 col-lg-6">
                        <div class="card custom-card">
                            <div class="card-header d-grid">
                                <a href="{{route('contracts.add')}}" class="btn btn-primary-light btn-wave waves-effect waves-light"><i class="ri-add-line align-middle me-1 fw-semibold d-inline-flex"></i>{{trans_dynamic('add_contract')}}</a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-4 justify-content-between">
                            <h5 class="fw-semibold">
                                {{trans_dynamic('today')}}
                            </h5>
                            <a href="{{route('cars')}}" class="btn btn-primary-light btn-sm btn-wave" style="display:block;">{{trans_dynamic('show_all')}}</a>
                        </div>
                        @foreach($carsStartingToday as $car)
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <span class="fs-14 text-muted"><i class="text-success bx bxs-circle me-1"></i>{{ Carbon\Carbon::now()->format('H:i') }}</span>
                                    <div class="dropdown ms-auto">
                                        <a href="javascript:void(0);" class="p-2 fs-16 text-muted" data-bs-toggle="dropdown">
                                            <i class="fe fe-more-horizontal"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="border-bottom"><a class="dropdown-item" href="{{ route('cars.detail',$car->id) }}">{{trans_dynamic('detail')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <h6 class="mb-1 mt-2">{{trans_dynamic('was_delivered')}}</h6>
                                <p class="text-muted mb-0">{{$car->car ? json_decode($car->car, true)['brand'] : ''}} {{$car->car ? json_decode($car->car, true)['model'] : ''}} ({{ $car->number_plate }})</p>
                            </div>
                        </div>
                        @endforeach

                        @foreach($carsEndingToday as $car)
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <span class="fs-14 text-muted"><i class="text-danger bx bxs-circle me-1"></i>{{ Carbon\Carbon::now()->format('H:i') }}</span>
                                    <div class="dropdown ms-auto">
                                        <a href="javascript:void(0);" class="p-2 fs-16 text-muted" data-bs-toggle="dropdown">
                                            <i class="fe fe-more-horizontal"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="border-bottom"><a class="dropdown-item" href="{{ route('cars.detail',$car->id) }}">{{trans_dynamic('detail')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <h6 class="mb-1 mt-2">{{trans_dynamic('come_back')}}</h6>
                                <p class="text-muted mb-0">{{$car->car ? json_decode($car->car, true)['brand'] : ''}} {{$car->car ? json_decode($car->car, true)['model'] : ''}} ({{ $car->number_plate }})</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-xxl-12 col-xl-6 col-lg-6">
                    
                </div>
            </div>
            <div class="col-xxl-6  col-xl-12">
                <div class="row">
                    <div class="col-xxl-12 col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header  justify-content-between">
                                <div class="card-title">{{trans_dynamic('contract')}} {{trans_dynamic('statistics')}}</div>
                                <div class="dropdown d-flex">
                                    <a href="javascript:void(0);" class="btn dropdown-toggle btn-sm btn-wave waves-effect waves-light btn-primary d-flex align-items-center" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-calendar-2-line me-1"></i><span id="selectedOption">{{trans_dynamic('weekly')}} {{trans_dynamic('analysis')}}</span>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="javascript:void(0);" id="yearly" onclick="fetchAndRefreshChartData('yearly')">{{trans_dynamic('yearly')}} {{trans_dynamic('analysis')}}</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" id="monthly" onclick="fetchAndRefreshChartData('monthly')">{{trans_dynamic('monthyl')}} {{trans_dynamic('analysis')}}</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);" id="weekly" onclick="fetchAndRefreshChartData('weekly')">{{trans_dynamic('weekly')}} {{trans_dynamic('analysis')}}</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="earnings"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-12">
                <div class="row">
                    <div class="col-xxl-12 col-xl-6">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-header justify-content-between">
                            <div class="card-title">
                                {{trans_dynamic('available_vehicles')}}
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush mb-0">
                                @foreach ($availableCars as $car)
                                <li class="list-group-item d-flex">
                                    <a href="{{route('cars.detail',$car->id)}}">
                                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="me-2 lh-1">
                                                    <span class="avatar avatar-md">
                                                        <img src="{{asset('/')}}{{json_decode($car->images, true)[0] ?? ''}}" alt="">
                                                    </span>
                                                </div>
                                                <div>
                                                    <p class="fw-semibold mb-0 fs-14">{{$car->car ? json_decode($car->car, true)['brand'] : ''}} {{$car->car ? json_decode($car->car, true)['model'] : ''}}</p>
                                                    <span class="text-muted fs-12">{{$car->number_plate}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="ms-auto my-auto">
                                        <a href="{{route('cars.detail',$car->id)}}" class="btn btn-primary-light btn-sm  btn-wave waves-effect waves-light">{{trans_dynamic('detail')}}</a>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ROW-1 END -->
<!-- End::row-1 -->

</div>
</div>
@endsection
