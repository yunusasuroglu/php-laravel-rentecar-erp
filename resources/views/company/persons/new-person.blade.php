@extends('layouts.layout')

@section('title', 'Emplooye Add')
@section('content')
<div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
    <h4 class="fw-medium mb-0">{{trans_dynamic('user_add')}}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('persons.new')}}" class="text-white-50">{{trans_dynamic('users')}}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('user_add')}}</li>
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
                            {{trans_dynamic('user_add')}}
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('persons.add') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('name')}}:</label>
                                    <input type="text" name="name" class="form-control" placeholder="{{trans_dynamic('name')}}" aria-label="{{trans_dynamic('name')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('surname')}}:</label>
                                    <input type="text" name="surname" class="form-control" placeholder="{{trans_dynamic('surname')}}" aria-label="{{trans_dynamic('surname')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('phone')}}:</label>
                                    <input type="text" name="phone" class="form-control" placeholder="{{trans_dynamic('phone')}}" aria-label="{{trans_dynamic('phone')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="row">
                                        <div class="col-xl-12 mb-3">
                                            <label class="form-label">{{trans_dynamic('email')}}:</label>
                                            <input type="email" name="email" class="form-control" placeholder="{{trans_dynamic('email')}}" aria-label="{{trans_dynamic('email')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('position')}}:</label>
                                    <select name="role" id="inputCountry" class="form-select">
                                        <option selected="">{{trans_dynamic('not_selected')}}</option>
                                        @foreach($rol as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('country')}}:</label>
                                    <select class="form-select" name="country" id="countrySelect">
                                        <option value="Deutschland">Deutschland</option>
                                        <option value="Niederlande">Niederlande</option>
                                        <option value="Österreich">Österreich</option>
                                        <option value="Dänemark">Dänemark</option>
                                        <option value="Schweden">Schweden</option>
                                        <option value="Frankreich">Frankreich</option>
                                        <option value="Belgien">Belgien</option>
                                        <option value="Italien">Italien</option>
                                        <option value="Griechenland">Griechenland</option>
                                        <option value="Schweiz">Schweiz</option>
                                        <option value="Polen">Polen</option>
                                        <option value="Kroatien">Kroatien</option>
                                        <option value="Rumänien">Rumänien</option>
                                        <option value="Tschechien">Tschechien</option>
                                        <option value="Serbien">Serbien</option>
                                        <option value="Ungarn">Ungarn</option>
                                        <option value="Bulgarien">Bulgarien</option>
                                        <option value="Russland">Russland</option>
                                        <option value="Weißrussland">Weißrussland</option>
                                        <option value="Türkei">Türkei</option>
                                        <option value="Norwegen">Norwegen</option>
                                        <option value="England">England</option>
                                        <option value="Irland">Irland</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="Spanien">Spanien</option>
                                        <option value="Slowenien">Slowenien</option>
                                        <option value="Slowakei">Slowakei</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Luxemburg">Luxemburg</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Litauen">Litauen</option>
                                        <option value="Lettland">Lettland</option>
                                        <option value="Kasachstan">Kasachstan</option>
                                        <option value="Island">Island</option>
                                        <option value="Estland">Estland</option>
                                        <option value="Finnland">Finnland</option>
                                        <option value="Bosnien und Herzegowina">Bosnien und Herzegowina</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">{{trans_dynamic('city')}}:</label>
                                    <input type="text" name="city" class="form-control" placeholder="{{trans_dynamic('city')}}" aria-label="{{trans_dynamic('city')}}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">{{trans_dynamic('street')}}:</label>
                                    <input type="text" name="street" class="form-control" placeholder="{{trans_dynamic('street')}}" aria-label="{{trans_dynamic('street')}}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">{{trans_dynamic('zip_code')}}:</label>
                                    <input type="text" name="zip_code" class="form-control" placeholder="{{trans_dynamic('zip_code')}}" aria-label="{{trans_dynamic('users')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('password')}}:</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control" id="signin-password" placeholder="{{trans_dynamic('password')}}" aria-label="{{trans_dynamic('password')}}">
                                        <button class="btn btn-light bg-transparent" type="button" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('password_confirm')}}</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" id="signin-password" class="form-control" placeholder="{{trans_dynamic('password_confirm')}}" required>
                                        <button class="btn btn-light bg-transparent" type="button" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                                    </div>
                                </div>
                                <div class=" checkout-payment-success">
                                    <div class="mb-4">
                                        <p class="mb-1 fs-14" data-bs-toggle="modal" data-bs-target="#exampleModalFullscreen">
                                            <a class="btn btn-success">{{trans_dynamic('signature_text')}}</a>
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
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="saveSignatureToInput()">{{trans_dynamic('close')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="signature" name="signature">
                                    <button type="submit" class="btn w-100 btn-primary">{{trans_dynamic('create')}}</button>
                                </div>
                                <div class="col-md-12">
                                    
                                </div>
                            </div>   
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-6 -->
        
    </div>
</div>
@endsection