@extends('layouts.layout')

@section('title', 'Profile Edit')
@section('content')
<!-- Page Header -->
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">{{trans_dynamic('edit')}} {{trans_dynamic('profile')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans_dynamic('edit')}} {{trans_dynamic('profile')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$user->name}}</li>
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
                    <div class="col-xl-2 col-lg-3">
                        <nav class="nav nav-tabs flex-column nav-style-5" role="tablist">
                            <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page" href="#personal-info" aria-selected="true"><i class="bx bx-cog me-2 fs-18 align-middle"></i>{{trans_dynamic('profile')}} {{trans_dynamic('info')}}</a>
                            <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page" href="#personal-add" aria-selected="true"><i class="bx bx-home me-2 fs-18 align-middle"></i>{{trans_dynamic('profile')}} {{trans_dynamic('address')}}</a>
                            <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page" href="#personal-sec" aria-selected="true"><i class="bx bx-lock me-2 fs-18 align-middle"></i>{{trans_dynamic('profile')}} {{trans_dynamic('security')}}</a>
                            @if(is_null($user->signature))
                                <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page" href="#personal-sign" aria-selected="true">
                                    <i class="bx bx-pen me-2 fs-18 align-middle"></i>Signature
                                </a>
                            @endif
                        </nav>
                    </div>
                    <div class="col-xl-10 col-lg-9">
                        <div class="tab-content mail-setting-tab mt-4 mt-lg-0">
                            <div class="tab-pane text-muted active show" id="personal-info" role="tabpanel">
                                <div class="p-3">
                                    <h6 class="fw-semibold mb-3">
                                        {{trans_dynamic('profile')}} {{trans_dynamic('info')}}
                                    </h6>
                                    <div class="mb-4 d-sm-flex align-items-center">
                                        <div class="mb-0 me-sm-5 d-sm-flex align-items-center">
                                            <form action="{{ route('profile.image.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
                                                @csrf
                                                @method('PUT')
                                            
                                                <span class="avatar avatar-xxl">
                                                    <img src="{{ asset($user->profile_image) }}" alt="" id="profile-img">
                                                    <label for="profile-change" class="badge rounded-pill bg-primary avatar-badge" style="cursor: pointer;">
                                                        <i class="fe fe-camera"></i>
                                                    </label>
                                                    <input type="file" name="photo" class="position-absolute w-100 h-100 opacity-0" id="profile-change" accept="image/*">
                                                </span>
                                            </form>
                                            <div class="ms-sm-3">
                                                <h5 class="text-dark mb-1">{{$user->name}} {{$user->surname}}</h5>
                                                <p class="text-muted mb-0">
                                                    <span class=" me-2">{{trans_dynamic('phone')}}:</span><span>{{$user->phone}}</span>
                                                </p>
                                                <p class="text-muted mb-0">
                                                    <span class="">{{trans_dynamic('email')}}:</span><span> {{$user->email}}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <button type="button" id="submit-btn" class="btn btn-success" style="display: none;">Save Profile Picture</button>
                                        <script>
                                            document.getElementById('profile-change').addEventListener('change', function() {
                                                if (this.files && this.files[0]) {
                                                    var reader = new FileReader();
                                        
                                                    reader.onload = function(e) {
                                                        document.getElementById('profile-img').setAttribute('src', e.target.result);
                                                        document.getElementById('submit-btn').style.display = 'block'; // Butonu görünür yap
                                                    }
                                        
                                                    reader.readAsDataURL(this.files[0]);
                                                }
                                            });
                                        
                                            // Butona tıklanınca formu gönder
                                            document.getElementById('submit-btn').addEventListener('click', function() {
                                                document.getElementById('profile-form').submit();
                                            });
                                        </script>
                                    </div>
                                    <form action="{{route('profile.update')}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row gy-4 mb-4">
                                            <div class="col-xl-6">
                                                <label for="first-name" class="form-label">{{trans_dynamic('name')}}:</label>
                                                <input type="text" name="name" class="form-control" id="first-name" value="{{$user->name}}" placeholder="{{trans_dynamic('name')}}">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="surname" class="form-label">{{trans_dynamic('surname')}}:</label>
                                                <input type="text" name="surname" class="form-control" id="surname" value="{{$user->surname}}" placeholder="{{trans_dynamic('surname')}}">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="phone" class="form-label">{{trans_dynamic('phone')}}</label>
                                                <input type="text" name="phone" class="form-control" id="phone" value="{{$user->phone}}" placeholder="{{trans_dynamic('phone')}}">
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="email-address" class="form-label">{{trans_dynamic('email')}}:</label>
                                                <input type="text" name="email" class="form-control" value="{{$user->email}}" id="email-address" placeholder="{{trans_dynamic('email')}}">
                                            </div>
                                            <div class="col-xl-12">
                                                <button type="submit" class="btn btn-primary">{{trans_dynamic('edit')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane text-muted" id="personal-add" role="tabpanel">
                                <div class="p-3">
                                    <h6 class="fw-semibold mb-3">
                                        {{trans_dynamic('profile')}} {{trans_dynamic('address')}}
                                    </h6>
                                    <form action="{{route('profile.address.update')}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row gy-4 mb-4">
                                            <div class="col-xl-3">
                                                <label for="address-street" class="form-label">{{trans_dynamic('street')}}:</label>
                                                <input type="text" name="street" value="{{ json_decode($user->address)->street  ?? '' }}" class="form-control" id="address-street" placeholder="{{trans_dynamic('street')}}">
                                            </div>
                                            <div class="col-xl-3">
                                                <label for="address-zip-code" class="form-label">{{trans_dynamic('zip_code')}}:</label>
                                                <input type="text" name="zip_code" value="{{ json_decode($user->address)->zip_code  ?? '' }}" class="form-control" id="address-zip-code" placeholder="{{trans_dynamic('zip_code')}}">
                                            </div>
                                            <div class="col-xl-3">
                                                <label for="address-city" class="form-label">{{trans_dynamic('city')}}:</label>
                                                <input type="text" value="{{ json_decode($user->address)->city  ?? '' }}" name="city" class="form-control" id="address-city" placeholder="{{trans_dynamic('city')}}">
                                            </div>
                                            <div class="col-xl-3">
                                                <label for="address-country" class="form-label">{{trans_dynamic('country')}}</label>
                                                <select class="form-select" name="country" id="country">
                                                    <option value="Deutschland" {{ json_decode($user->address)->country == 'Deutschland' ? 'selected' : '' }}>Deutschland</option>
                                                    <option value="Niederlande" {{ json_decode($user->address)->country == 'Niederlande' ? 'selected' : '' }}>Niederlande</option>
                                                    <option value="Österreich" {{ json_decode($user->address)->country == 'Österreich' ? 'selected' : '' }}>Österreich</option>
                                                    <option value="Dänemark" {{ json_decode($user->address)->country == 'Dänemark' ? 'selected' : '' }}>Dänemark</option>
                                                    <option value="Schweden" {{ json_decode($user->address)->country == 'Schweden' ? 'selected' : '' }}>Schweden</option>
                                                    <option value="Frankreich" {{ json_decode($user->address)->country == 'Frankreich' ? 'selected' : '' }}>Frankreich</option>
                                                    <option value="Belgien" {{ json_decode($user->address)->country == 'Belgien' ? 'selected' : '' }}>Belgien</option>
                                                    <option value="Italien" {{ json_decode($user->address)->country == 'Italien' ? 'selected' : '' }}>Italien</option>
                                                    <option value="Griechenland" {{ json_decode($user->address)->country == 'Griechenland' ? 'selected' : '' }}>Griechenland</option>
                                                    <option value="Schweiz" {{ json_decode($user->address)->country == 'Schweiz' ? 'selected' : '' }}>Schweiz</option>
                                                    <option value="Polen" {{ json_decode($user->address)->country == 'Polen' ? 'selected' : '' }}>Polen</option>
                                                    <option value="Kroatien" {{ json_decode($user->address)->country == 'Kroatien' ? 'selected' : '' }}>Kroatien</option>
                                                    <option value="Rumänien" {{ json_decode($user->address)->country == 'Rumänien' ? 'selected' : '' }}>Rumänien</option>
                                                    <option value="Tschechien" {{ json_decode($user->address)->country == 'Tschechien' ? 'selected' : '' }}>Tschechien</option>
                                                    <option value="Serbien" {{ json_decode($user->address)->country == 'Serbien' ? 'selected' : '' }}>Serbien</option>
                                                    <option value="Ungarn" {{ json_decode($user->address)->country == 'Ungarn' ? 'selected' : '' }}>Ungarn</option>
                                                    <option value="Bulgarien" {{ json_decode($user->address)->country == 'Bulgarien' ? 'selected' : '' }}>Bulgarien</option>
                                                    <option value="Russland" {{ json_decode($user->address)->country == 'Russland' ? 'selected' : '' }}>Russland</option>
                                                    <option value="Weißrussland" {{ json_decode($user->address)->country == 'Weißrussland' ? 'selected' : '' }}>Weißrussland</option>
                                                    <option value="Türkei" {{ json_decode($user->address)->country == 'Türkei' ? 'selected' : '' }}>Türkei</option>
                                                    <option value="Norwegen" {{ json_decode($user->address)->country == 'Norwegen' ? 'selected' : '' }}>Norwegen</option>
                                                    <option value="England" {{ json_decode($user->address)->country == 'England' ? 'selected' : '' }}>England</option>
                                                    <option value="Irland" {{ json_decode($user->address)->country == 'Irland' ? 'selected' : '' }}>Irland</option>
                                                    <option value="Ukraine" {{ json_decode($user->address)->country == 'Ukraine' ? 'selected' : '' }}>Ukraine</option>
                                                    <option value="Spanien" {{ json_decode($user->address)->country == 'Spanien' ? 'selected' : '' }}>Spanien</option>
                                                    <option value="Slowenien" {{ json_decode($user->address)->country == 'Slowenien' ? 'selected' : '' }}>Slowenien</option>
                                                    <option value="Slowakei" {{ json_decode($user->address)->country == 'Slowakei' ? 'selected' : '' }}>Slowakei</option>
                                                    <option value="Portugal" {{ json_decode($user->address)->country == 'Portugal' ? 'selected' : '' }}>Portugal</option>
                                                    <option value="Luxemburg" {{ json_decode($user->address)->country == 'Luxemburg' ? 'selected' : '' }}>Luxemburg</option>
                                                    <option value="Liechtenstein" {{ json_decode($user->address)->country == 'Liechtenstein' ? 'selected' : '' }}>Liechtenstein</option>
                                                    <option value="Litauen" {{ json_decode($user->address)->country == 'Litauen' ? 'selected' : '' }}>Litauen</option>
                                                    <option value="Lettland" {{ json_decode($user->address)->country == 'Lettland' ? 'selected' : '' }}>Lettland</option>
                                                    <option value="Kasachstan" {{ json_decode($user->address)->country == 'Kasachstan' ? 'selected' : '' }}>Kasachstan</option>
                                                    <option value="Island" {{ json_decode($user->address)->country == 'Island' ? 'selected' : '' }}>Island</option>
                                                    <option value="Estland" {{ json_decode($user->address)->country == 'Estland' ? 'selected' : '' }}>Estland</option>
                                                    <option value="Finnland" {{ json_decode($user->address)->country == 'Finnland' ? 'selected' : '' }}>Finnland</option>
                                                    <option value="Bosnien und Herzegowina" {{ json_decode($user->address)->country == 'Bosnien und Herzegowina' ? 'selected' : '' }}>Bosnien und Herzegowina</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-12">
                                                <button type="submit" class="btn btn-primary">{{trans_dynamic('edit')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane text-muted" id="personal-sec" role="tabpanel">
                                <div class="p-3">
                                    <h6 class="fw-semibold mb-3">
                                        {{trans_dynamic('profile')}} {{trans_dynamic('security')}}
                                    </h6>
                                    <form action="{{route('profile.password.update')}}" method="POST">
                                        @csrf
                                        <div class="row gy-4 mb-4">
                                            <div class="col-xl-4">
                                                <label for="current-password" class="form-label">{{trans_dynamic('password_current')}}:</label>
                                                <input type="password" name="current_password" class="form-control" id="current-password" placeholder="{{trans_dynamic('password_current')}}">
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="new-password" class="form-label">{{trans_dynamic('password')}}:</label>
                                                <input type="password" name="new_password" class="form-control" id="new-password" placeholder="{{trans_dynamic('password')}}">
                                            </div>
                                            <div class="col-xl-4">
                                                <label for="new-password-confirm" class="form-label">{{trans_dynamic('password_confirm')}}:</label>
                                                <input type="password" name="new_password_confirmation" class="form-control" id="new-password-confirm" placeholder="{{trans_dynamic('password_confirm')}}">
                                            </div>
                                            <div class="col-xl-12">
                                                <button type="submit" class="btn btn-primary">{{trans_dynamic('edit')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane text-muted" id="personal-sign" role="tabpanel">
                                <div class="p-3">
                                    <h6 class="fw-semibold mb-3">
                                        {{trans_dynamic('profile')}} {{trans_dynamic('signature')}}
                                    </h6>
                                    <form action="{{route('profile.sign.update')}}" method="POST">
                                        @csrf
                                        <div class="p-5 checkout-payment-success my-3">
                                            <div class="mb-5">
                                                <h5 class="text-success fw-semibold">{{trans_dynamic('user')}} {{trans_dynamic('signature')}}</h5>
                                            </div>
                                            <div class="mb-4">
                                                <p class="mb-1 fs-14" data-bs-toggle="modal" data-bs-target="#exampleModalFullscreen">
                                                    <u>{{trans_dynamic('signature_please_message1')}}</u>
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
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{trans_dynamic('close')}}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted">{{trans_dynamic('signature_please_message2')}}</p>
                                            </div>
                                            <input type="hidden" id="signature" name="signature">
                                            <button type="submit" class="btn btn-success" onclick="saveSignatureToInput()">{{trans_dynamic('save_and_close')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
</div>
<!-- End::app-content -->
@endsection