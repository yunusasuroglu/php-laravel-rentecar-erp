@extends('layouts.layout')
@section('title', 'Edit Emplooye')
@section('content')
<div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
    <h4 class="fw-medium mb-0">{{trans_dynamic('edit')}} {{trans_dynamic('user')}}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">{{trans_dynamic('users')}}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('edit')}} {{trans_dynamic('user')}}</li>
    </ol>
</div>
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start:: row-6 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            {{$user->name}}{{$user->surname}}
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('persons.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('name')}}</label>
                                    <input type="text" name="name" value="{{$user->name}}" class="form-control" placeholder="{{trans_dynamic('name')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('surname')}}</label>
                                    <input type="text" name="surname" value="{{$user->surname}}" class="form-control" placeholder="{{trans_dynamic('surname')}}" aria-label="{{trans_dynamic('surname')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('phone')}}</label>
                                    <input type="text" name="phone" value="{{$user->phone}}" class="form-control" placeholder="{{trans_dynamic('phone')}}" aria-label="{{trans_dynamic('phone')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="row">
                                        <div class="col-xl-12 mb-3">
                                            <label class="form-label">{{trans_dynamic('email')}}</label>
                                            <input type="email" name="email" value="{{$user->email}}" class="form-control" placeholder="{{trans_dynamic('email')}}" aria-label="{{trans_dynamic('email')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="role">{{trans_dynamic('position')}}</label>
                                    <select name="role" id="role" class="form-select">
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('country')}}</label>
                                    <select class="form-select" name="country" id="CountrySelect">
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
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">{{trans_dynamic('city')}}</label>
                                    <input type="text" name="city" value="{{ json_decode($user->address)->city  ?? '' }}" class="form-control" placeholder="{{trans_dynamic('city')}}" aria-label="{{trans_dynamic('city')}}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">{{trans_dynamic('street')}}</label>
                                    <input type="text" name="street" value="{{ json_decode($user->address)->street  ?? '' }}" class="form-control" placeholder="{{trans_dynamic('street')}}" aria-label="{{trans_dynamic('street')}}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">{{trans_dynamic('zip_code')}}</label>
                                    <input type="text" name="zip_code" value="{{ json_decode($user->address)->zip_code  ?? '' }}" class="form-control" placeholder="{{trans_dynamic('zip_code')}}" aria-label="{{trans_dynamic('zip_code')}}">
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">{{trans_dynamic('edit')}}</button>
                                </div>
                            </div>   
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-6 -->
        <!-- End:: row-6 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            {{trans_dynamic('password')}} {{trans_dynamic('edit')}}
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('persons.edit-password', ['id' => $user->id]) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('password')}}</label>
                                    <input type="password" name="new_password" class="form-control" placeholder="{{trans_dynamic('password')}}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('password_confirm')}}</label>
                                    <input type="password" name="new_password_confirmation" class="form-control" placeholder="{{trans_dynamic('password_confirm')}}" required>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">{{trans_dynamic('edit')}}</button>
                                </div>
                            </div>   
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            {{trans_dynamic('signature')}} {{trans_dynamic('edit')}}
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('persons.edit-sign', ['id' => $user->id]) }}" method="POST">
                            @csrf
                            <div class="p-5 checkout-payment-success my-3">
                                <div class="mb-5">
                                    <h5 class="text-success fw-semibold">{{trans_dynamic('user')}} {{trans_dynamic('signature')}}</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="mb-1 fs-14" data-bs-toggle="modal" data-bs-target="#exampleModalFullscreen">
                                        <u>{{trans_dynamic('signature_text')}}</u>
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
                                    <p class="text-muted">{{trans_dynamic('signature_text_2')}}</p>
                                </div>
                                <input type="hidden" id="signature" name="signature">
                                <button type="submit" class="btn btn-success" onclick="saveSignatureToInput()">{{trans_dynamic('save_and_complete')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection