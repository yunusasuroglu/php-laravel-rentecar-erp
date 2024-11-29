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
    <h4 class="fw-medium mb-0">{{trans_dynamic('customer_add')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-white-50">{{trans_dynamic('home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('customer_add')}}</li>
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
                        <form method="POST" enctype="multipart/form-data" action="{{route('customers.store')}}">
                            @csrf
                            <div class="tab-content mt-4 mt-lg-0">
                                <div class="tab-pane text-muted active show" id="customer-info" role="tabpanel">
                                    <div class="p-3">
                                        <div class="row gy-4 mb-4">
                                            <div class="col-xl-12">
                                                <label for="cname" class="form-label">{{trans_dynamic('company')}} {{trans_dynamic('name')}}</label>
                                                <input type="text" name="company_name" class="form-control" id="cname" placeholder="{{trans_dynamic('company')}} {{trans_dynamic('name')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('company')}} {{trans_dynamic('name')}}.
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="name" class="form-label">{{trans_dynamic('name')}}*</label>
                                                <input type="text" name="name" class="form-control" id="name" placeholder="{{trans_dynamic('name')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('name')}}.
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="surname" class="form-label">{{trans_dynamic('surname')}}*</label>
                                                <input type="text" name="surname" class="form-control" id="surname" placeholder="{{trans_dynamic('surname')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('surname')}}.
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="phone" class="form-label">{{trans_dynamic('phone')}}</label>
                                                <input type="text" name="phone" class="form-control" id="phone" placeholder="{{trans_dynamic('phone')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('phone')}}.
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="email" class="form-label">{{trans_dynamic('email')}}</label>
                                                <input type="email" name="email" class="form-control" id="email" placeholder="{{trans_dynamic('email')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('email')}}.
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="street" class="form-label">{{trans_dynamic('street')}}*</label>
                                                <input type="text" name="street" class="form-control" id="street" placeholder="{{trans_dynamic('street')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('street')}}.
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="plz" class="form-label">{{trans_dynamic('zip_code')}}*</label>
                                                <input type="text" name="zip_code" class="form-control" id="plz" placeholder="{{trans_dynamic('{{trans_dynamic('zip_code')}}')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('{{trans_dynamic('zip_code')}}')}}.
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="city" class="form-label">{{trans_dynamic('city')}}*</label>
                                                <input type="text" name="city" class="form-control" id="city" placeholder="{{trans_dynamic('city')}}">
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
                                                <input type="date" class="form-control" name="date_of_birth" id="birthdate" placeholder="{{trans_dynamic('date_of_birth')}}">
                                                <div class="invalid-feedback">
                                                    Please enter the {{trans_dynamic('date_of_birth')}}.
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
                                                            <option selected value="Germany">Deutschland</option>
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
                                                <input type="date" name="identity_expiry_date" class="form-control" id="id-expire-date" placeholder="Driver's License Acquired On">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="license-expiry-date" class="form-label">{{trans_dynamic('driver_card_expiry')}}</label>
                                                <input type="date" name="driver_licence_expiry_date" class="form-control" id="license-expiry-date" placeholder="Driver's License Expiry Date">
                                            </div>
                                            <div class="col-xl-12">
                                                <button type="submit" class="btn btn-primary w-100">{{trans_dynamic('create')}}</button>
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