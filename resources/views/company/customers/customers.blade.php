@extends('layouts.layout')
@section('title', 'Customers')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
</style>
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">{{trans_dynamic('customers')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-white-50">{{trans_dynamic('home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('customers')}}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->



<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            {{trans_dynamic('all')}} {{trans_dynamic('customers')}}
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="responsivemodal-DataTable" class="table table-bordered text-nowrap"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">{{trans_dynamic('name')}}</th>
                                    <th scope="col">{{trans_dynamic('last_rent')}}</th>
                                    <th scope="col">{{trans_dynamic('age')}}</th>
                                    <th scope="col">{{trans_dynamic('detail')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customersWithAge as $customer)
                                @php
                                $lastRent = json_decode($customer->last_rented_car, true);
                                $firstImage = $lastRent['images'][0] ?? 'default_image.jpg';
                                @endphp
                                <tr>
                                    <td>{{$customer->name}} {{$customer->surname}}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2 lh-1">
                                                <span class="avatar avatar-sm avatar-rounded">
                                                    @if($customer->last_rented_car != {{trans_dynamic('no_rentals')}})
                                                    <img src="{{asset('/')}}{{$firstImage}}" alt="">
                                                    @else
                                                    <img src="{{asset('/')}}assets/images/media/chat.png" alt="">
                                                    @endif
                                                </span>
                                            </div>
                                            <div>
                                            @if($customer->last_rented_car != {{trans_dynamic('no_rentals')}})
                                                <p class="mb-0 fw-semibold">{{ $lastRent['car']['brand'] ?? '' }} {{ $lastRent['car']['model'] ?? '' }} ({{ $lastRent['number_plate'] ?? {{trans_dynamic('not_car_number_plate')}} }})</p>
                                            @else
                                                <p class="mb-0 fw-semibold">{{trans_dynamic('no_rentals')}}</p>
                                            @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$customer->age}}</td>
                                    <td style="text-align: center;">
                                        
                                        <a href="{{route('customers.detail',$customer->id)}}" class="btn btn-primary-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('detail')}}"><i class="bi bi-eye"></i></a>
                                        <a href="{{route('customers.edit', $customer->id)}}" class="btn btn-success-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('edit')}}"><i class="bi bi-pencil"></i></a>
                                        {{-- <a href="{{route('customers.detail')}}" class="btn btn-danger-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Passive"><i class="bi bi-pencil"></i></a> --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-1 -->



    </div>
</div>
<!-- End::app-content -->


@endsection