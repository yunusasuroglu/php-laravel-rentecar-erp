@extends('layouts.layout')
@section('title', 'New Customer')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
</style>
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">{{trans_dynamic('edit')}} {{trans_dynamic('customer')}} - {{$customer->name}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('customers')}}" class="text-white-50">{{trans_dynamic('customers')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('edit')}} {{trans_dynamic('customer')}} - {{$customer->name}}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->



<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container">

        <!-- Start::row-1 -->
        <div class="card custom-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-lg-3">
                        <nav class="nav nav-tabs flex-column nav-style-5" role="tablist">
                            <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page" href="#customer-info" aria-selected="true">
                                <i class="bx bx-user me-2 fs-18 align-middle"></i>{{trans_dynamic('customer')}} {{trans_dynamic('info')}}
                            </a>
                            <a class="nav-link mt-3" data-bs-toggle="tab" role="tab" aria-current="page" href="#id-license-info" aria-selected="false" tabindex="-1">
                                <i class="bx bx-id-card me-2 fs-18 align-middle"></i>{{trans_dynamic('id_and_driver_card')}}
                            </a>
                        </nav>
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <form method="POST" enctype="multipart/form-data" action="{{route('customers.update', $customer->id)}}">
                            @csrf
                            <div class="tab-content mt-4 mt-lg-0">
                                <div class="tab-pane text-muted active show" id="customer-info" role="tabpanel">
                                    <div class="p-3">
                                        <div class="row gy-4 mb-4">
                                            <div class="col-xl-12">
                                                <label for="cname" class="form-label">{{trans_dynamic('company')}} {{trans_dynamic('name')}}</label>
                                                <input type="text" value="{{$customer->company_name}}" name="company_name" class="form-control" id="cname" placeholder="{{trans_dynamic('company')}} {{trans_dynamic('name')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('company')}} {{trans_dynamic('name')}}.
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="name" class="form-label">{{trans_dynamic('name')}}*</label>
                                                <input type="text" name="name" value="{{$customer->name}}" class="form-control" id="name" placeholder="{{trans_dynamic('name')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('name')}}.
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="surname" class="form-label">{{trans_dynamic('surname')}}*</label>
                                                <input type="text" name="surname" value="{{$customer->surname}}" class="form-control" id="surname" placeholder="{{trans_dynamic('surname')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('surname')}}.
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="phone" class="form-label">{{trans_dynamic('phone')}}</label>
                                                <input type="text" name="phone" value="{{$customer->phone}}" class="form-control" id="phone" placeholder="{{trans_dynamic('phone')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('phone')}}.
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="email" class="form-label">{{trans_dynamic('email')}}</label>
                                                <input type="email" name="email" value="{{$customer->email}}" class="form-control" id="email" placeholder="{{trans_dynamic('email')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('email')}}.
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="street" class="form-label">{{trans_dynamic('street')}}*</label>
                                                <input type="text" name="street" value="{{ isset(json_decode($customer->address, true)['street']) ? json_decode($customer->address, true)['street'] : 'N/A' }}" class="form-control" id="street" placeholder="{{trans_dynamic('street')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('street')}}.
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="plz" class="form-label">{{trans_dynamic('zip_code')}}*</label>
                                                <input type="text" name="zip_code" value="{{ isset(json_decode($customer->address, true)['zip_code']) ? json_decode($customer->address, true)['zip_code'] : 'N/A' }}" class="form-control" id="plz" placeholder="{{trans_dynamic('zip_code')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('zip_code')}}.
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="city" class="form-label">{{trans_dynamic('city')}}*</label>
                                                <input type="text" name="city" value="{{ isset(json_decode($customer->address, true)['city']) ? json_decode($customer->address, true)['city'] : 'N/A' }}" class="form-control" id="city" placeholder="{{trans_dynamic('city')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('city')}}.
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="country" class="form-label">{{trans_dynamic('country')}}*</label>
                                                <select name="country" class="form-control" id="country">
                                                    <option selected value="Germany">Deutschland</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="birthdate" class="form-label">{{trans_dynamic('date_of_birth')}}*</label>
                                                <input type="date" class="form-control" name="date_of_birth" id="birthdate" placeholder="{{trans_dynamic('date_of_birth')}}" value="{{ old('date_of_birth', $customer->date_of_birth) }}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('date_of_birth')}}.
                                                </div>
                                            </div>
                                            @if ($customer->invoice_status == 2)
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
                                                            <option selected value="Germany">Deutschland</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="col-xl-12">
                                                <label for="billing-cname" class="form-label">{{trans_dynamic('company')}} {{trans_dynamic('name')}}</label>
                                                <input type="text" class="form-control" value="{{ isset(json_decode($customer->invoice_info, true)['company_name']) ? json_decode($customer->invoice_info, true)['company_name'] : 'N/A' }}" id="billing-cname" name="invoice_company_name" placeholder="Company name">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="billing-name" class="form-label">{{trans_dynamic('company')}} {{trans_dynamic('name')}}*</label>
                                                <input type="text" class="form-control" value="{{ isset(json_decode($customer->invoice_info, true)['name']) ? json_decode($customer->invoice_info, true)['name'] : 'N/A' }}" name="invoice_name" id="billing-name" placeholder="Name">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="billing-surname" class="form-label">{{trans_dynamic('surname')}}*</label>
                                                <input type="text" name="invoice_surname" value="{{ isset(json_decode($customer->invoice_info, true)['surname']) ? json_decode($customer->invoice_info, true)['surname'] : 'N/A' }}" class="form-control" id="billing-surname" placeholder="{{trans_dynamic('surname')}}">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="billing-street" class="form-label">{{trans_dynamic('street')}}*</label>
                                                <input type="text" name="invoice_street" value="{{ isset(json_decode($customer->invoice_info, true)['street']) ? json_decode($customer->invoice_info, true)['street'] : 'N/A' }}" class="form-control" id="billing-street" placeholder="{{trans_dynamic('street')}}">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="billing-plz" class="form-label">{{trans_dynamic('zip_code')}}*</label>
                                                <input type="text" name="invoice_zip_code" value="{{ isset(json_decode($customer->invoice_info, true)['zip_code']) ? json_decode($customer->invoice_info, true)['zip_code'] : 'N/A' }}" class="form-control" id="billing-plz" placeholder="{{trans_dynamic('zip_code')}}">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="billing-city" class="form-label">City*</label>
                                                <input type="text" name="invoice_city" value="{{ isset(json_decode($customer->invoice_info, true)['city']) ? json_decode($customer->invoice_info, true)['city'] : 'N/A' }}" class="form-control" id="billing-city" placeholder="City">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="billing-country" class="form-label">{{trans_dynamic('country')}}*</label>
                                                <select class="form-control" name="invoice_country" id="billing-country">
                                                    <option selected value="Germany">Deutschland</option>
                                                </select>
                                            </div>
                                            @endif
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
                                                <input type="date" value="{{ isset(json_decode($customer->identity, true)['expiry_date']) ? json_decode($customer->identity, true)['expiry_date'] : 'N/A' }}" name="identity_expiry_date" class="form-control" id="id-expire-date" placeholder="{{trans_dynamic('id_card_expiry')}}">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="license-expiry-date" class="form-label">{{trans_dynamic('driver_card_expiry')}}</label>
                                                <input type="date" value="{{ isset(json_decode($customer->driving_licence, true)['expiry_date']) ? json_decode($customer->driving_licence, true)['expiry_date'] : 'N/A' }}" name="driver_licence_expiry_date" class="form-control" id="license-expiry-date" placeholder="{{trans_dynamic('driver_card_expiry')}}">
                                            </div>
                                            <div class="col-xl-12">
                                                <button type="submit" class="btn btn-primary w-100">{{trans_dynamic('edit')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function toggleBillingAddress() {
                const billingAddress = document.getElementById('billing-address');
                billingAddress.classList.toggle('d-none');
            }
        </script>


    </div>
</div>
<!-- End::app-content -->


@endsection