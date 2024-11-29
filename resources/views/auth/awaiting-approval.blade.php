@extends('layouts.app')
@php
    $title = trans_dynamic('approve_page_title');
@endphp
@section('title', $title)
@section('content')

<div class="page error-bg" id="particles-js">
    <canvas class="error-basic-background" width="1503" height="1017" style="width: 100%; height: 100%;"></canvas>
    <!-- Start::error-page -->
    <div class="error-page  ">
        <div class="container">
            <!-- Start::row-1 -->
            @role('Şirket Admin')
            <div class="row align-items-center justify-content-center mx-2">
                <div class="col-xxl-7 col-xl-8 col-lg-9 rectangle error-authentication ">
                    <div class="text-center authentication-style rectangle1">
                        <div class="lh-1 mb-3  d-inline-table">
                            <span class="text-warning text-large fw-bold"><i class="bx bx-error-circle"></i></span>
                        </div>
                        <span class="d-block fs-15 mb-3">{{trans_dynamic('approve_company_title')}}</span>
                        <p class="text-muted fw-normal">
                            {{trans_dynamic('approve_company_message')}} {{ Auth::user()->email }} {{trans_dynamic('approve_company_message_2')}}
                        </p>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">{{trans_dynamic('approve_logout')}}</button>
                        </form>
                        
                    </div>
                </div>
            </div>
            @elserole('Personel')
            <div class="row align-items-center justify-content-center mx-2">
                <div class="col-xxl-7 col-xl-8 col-lg-9 rectangle error-authentication ">
                    <div class="text-center authentication-style rectangle1">
                        <div class="lh-1 mb-3  d-inline-table">
                            <span class="text-warning text-large fw-bold"><i class="bx bx-error-circle"></i></span>
                        </div>
                        <span class="d-block fs-15 mb-3">{{trans_dynamic('approve_person_title')}}</span>
                        <p class="text-muted fw-normal">
                            {{trans_dynamic('approve_person_message')}}
                        </p>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">{{trans_dynamic('approve_logout')}}</button>
                        </form>
                    </div>
                </div>
            </div>
            @endrole
            <!--End::row-1 -->
        </div>
    </div>
    <!-- End::error-page -->

</div>
@endsection