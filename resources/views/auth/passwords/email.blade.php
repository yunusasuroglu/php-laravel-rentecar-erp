@extends('layouts.app')
@php
    $title = trans_dynamic('password_reset_email_page_title');
@endphp
@section('title', $title)
@section('content')
<div class="page error-bg" id="particles-js">
    <!-- Start::error-page -->
    <div class="error-page  ">
        <div class="container">
            <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
                <div class="col-xxl-8 col-xl-9 col-lg-5 col-md-6 col-sm-8 col-12">
                    <div class="my-5 d-flex justify-content-center">
                        <a href="{{route('login')}}">
                            <img style="width: 100%;" src="{{asset('/')}}assets/images/systems-logo/logo-dark.png" alt="logo" class="desktop-logo">
                            <img src="{{asset('/')}}assets/images/systems-logo/logo-dark.png" alt="logo" class="desktop-dark">
                        </a>
                    </div>
                    <div class="card custom-card  rectangle2">
                        <div class="card-body p-sm-5 p-3  rectangle3">
                            <p class="h5 fw-semibold mb-2 text-center">{{trans_dynamic('password_reset_email_title')}}</p>
                            <p class="mb-4 text-muted op-7 fw-normal text-center">{{trans_dynamic('password_reset_email_sub_title')}}</p>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="row gy-3">
                                    <div class="col-xl-12">
                                        <label for="reset-password" class="form-label text-default">{{trans_dynamic('password_reset_email_form_email')}}</label>
                                        <div class="input-group">
                                            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="reset-password" placeholder="{{trans_dynamic('password_reset_email_form_placeholder_email')}}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-12 mb-2">
                                        <div class="col-xl-12 d-grid mt-4">
                                            <button class="btn btn-lg btn-primary">{{trans_dynamic('password_reset_email_form_reset')}}</button>
                                            <label class="mt-3">
                                                {{trans_dynamic('password_reset_email_do_you_know_your_password')}}<a href="{{route('login')}}" class="text-primary ms-2">{{trans_dynamic('password_reset_email_do_you_know_your_password_login')}}</a>
                                            </label>
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
    <!-- End::error-page -->
</div>
@endsection
