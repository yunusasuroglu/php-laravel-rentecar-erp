@extends('layouts.app')
@section('title', 'login')
@section('content')
<div class="row mx-0 authentication bg-white">
    <div class="col-xxl-6 col-xl-7 col-lg-12">
        <div class="row mx-0 justify-content-center align-items-center h-100">
            <div class="col-xxl-6 col-xl-7 col-lg-7 col-md-7 col-sm-8 col-12">
                <p class="h5 fw-semibold mb-2">{{trans_dynamic('login')}}</p>
                <p class="mb-3 text-muted op-7 fw-normal">{{trans_dynamic('welcome_back')}}</p>
                <div class="row gy-3">
                    <div class="row gy-3 mt-3">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="col-xl-12">
                                <label for="signup-firstname" class="form-label text-default">{{trans_dynamic('email')}}:</label>
                                <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="signin-username" placeholder="{{trans_dynamic('email')}}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-xl-12 mt-2">
                                <label for="signup-lastname" class="form-label text-default">{{trans_dynamic('password')}}:</label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="signin-password" placeholder="{{trans_dynamic('password')}}">
                                    <button class="btn btn-light bg-transparent" type="button" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-12 d-grid mt-4">
                                <button class="btn btn-lg btn-primary">{{trans_dynamic('login')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-6 col-xl-5 col-lg-5 d-xl-block d-none px-0">
        <div class="authentication-cover">
            <a href="{{route('login')}}">
                <img src="{{asset('/')}}assets/images/systems-logo/logo-dark.png" class="authentication1" alt="logo">
                <img src="{{asset('/')}}assets/images/systems-logo/logo-dark.png" class="authentication2" alt="logo">
            </a>
            <div class="">
                <div class="row justify-content-center g-0">
                    <div class="col-xl-9">
                        <a href="{{route('login')}}"> <img src="{{asset('/')}}assets/images/systems-logo/logo-dark.png" alt="logo" class="authentication-brand img-fluid w-50 cover-dark-logo op-9"></a> 
                        <div class="text-fixed-white text-start d-flex align-items-center">
                            <div>
                                <h3 class="fw-semibold op-8 mb-3  text-fixed-white">{{trans_dynamic('login')}}</h3>
                                <p class="mb-5 fw-normal fs-14 op-6">
                                    <b>Safari Rentsoft</b>
                                    {{trans_dynamic('login_text_1')}} <br>
                                    
                                    <b>Safari Rentsoft</b>, {{trans_dynamic('login_text_2')}} <br>
                                    
                                    {{trans_dynamic('login_text_3')}}</p>
                            </div>
                        </div>
                        <div class="authentication-footer text-end">
                            <span class="text-muted"> Copyright © <span id="year"></span> <a
                            href="javascript:void(0);" class="text-white fw-semibold">Safari RENTSOFT</a>
                            </a> • All rights reserved.
                            </span>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<form id="resetDatabaseForm" action="{{ route('reset.database') }}" method="POST">
    @csrf
    <button type="button" onclick="confirmReset()" class="btn btn-danger">
        Veritabanını Sıfırla
    </button>
</form>

<script>
    function confirmReset() {
        if (confirm("Tüm veritabanı silinecek. Emin misiniz?")) {
            document.getElementById('resetDatabaseForm').submit();
        }
    }
</script>
</div>
@endsection
