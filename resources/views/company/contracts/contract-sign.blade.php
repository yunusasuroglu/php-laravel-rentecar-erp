@extends('layouts.layout')
@section('title', 'New Contract')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
    #fuellevel {
        font-size: 14pt;
        text-align: right;
        font-weight: bold;
        float: left;
        width: 20%;
    }
    #car-container {
        position: relative;
        display: inline-block;
    }
    #car {
        display: block;
    }
    .damage-marker {
        position: absolute;
        color: red;
        font-size: 24px;
        font-weight: bold;
        transform: translate(-50%, -50%);
        pointer-events: none; /* Prevent the mark from capturing click events */
    }
    .marker-number {
        font-size: 14px;
        vertical-align: super;
    }
    .delete-button {
        margin-top: 10px;
        display: none; /* Initially hidden */
    }
    .example-damage img {
        width: 50px;
        height: 50px;
    }
    .example-damage .fw-semibold {
        margin-left: 20px !important;
    }
</style>
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">{{trans_dynamic('sign')}} {{trans_dynamic('contract')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('contracts')}}" class="text-white-50">{{trans_dynamic('contracts')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('sign')}} {{trans_dynamic('contract')}}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- End::app-content -->

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        
        
        <div class="container">
            <!-- Start::row-1 -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body p-0 product-checkout">
                            <nav class="nav nav-tabs flex-column nav-style-5" role="tablist">
                                <div class="row p-3">
                                    <div class="col-3">
                                        <a class="nav-link disabled" id="order-tab" data-bs-toggle="tab" data-bs-target="#order-tab-pane" type="button" role="tab" aria-controls="order-tab" aria-selected="true">
                                            <i class="ri-truck-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('general_information')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#cardetails" type="button" role="tab" aria-controls="confirmed-tab" aria-selected="false">
                                            <i class="bx bx-car me-2 align-middle d-inline-block"></i>{{trans_dynamic('car')}} {{trans_dynamic('detail')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link disabled" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirm-tab-pane" type="button" role="tab" aria-controls="confirmed-tab" aria-selected="false">
                                            <i class="ri-user-3-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('id_and_driver_card')}}
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a class="nav-link active" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivery-tab-pane" type="button" role="tab" aria-controls="delivered-tab" aria-selected="false">
                                            <i class="ri-checkbox-circle-line me-2 align-middle d-inline-block"></i>{{trans_dynamic('signature')}} & {{trans_dynamic('confirmation')}}
                                        </a> 
                                    </div>
                                </div>
                            </nav>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active border-0 p-0" id="delivery-tab-pane" role="tabpanel"varia-labelledby="delivery-tab-pane" tabindex="0">
                                    <form action="{{ route('contracts.sign.upp', $contract->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="p-5 checkout-payment-success my-3">
                                            <div class="mb-5">
                                                <h5 class="text-success fw-semibold">{{trans_dynamic('signature')}} & {{trans_dynamic('confirmation')}}</h5>
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
            <!--End::row-1 -->
        </div>
        
    </div>
</div>
<!-- End::app-content -->

@endsection