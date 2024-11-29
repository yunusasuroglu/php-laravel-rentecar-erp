@extends('layouts.layout')
@section('title', 'Mails')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
</style>
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">{{trans_dynamic('mails')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">{{auth()->user()->company->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('mails')}}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="main-content app-content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            {{trans_dynamic('punishment')}} {{trans_dynamic('mail')}} {{trans_dynamic('edit')}}
                        </div>
                    </div>
                    <form action="{{route('settings.update')}}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="form-text" class="form-label fs-14 text-dark">{{trans_dynamic('punishment')}} {{trans_dynamic('mail')}}:</label>
                                <textarea name="punishment_mail" class="form-control" id="punishment_mail" rows="10">  {{ $settingsData['punishment_mail'] }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="form-text" class="form-label fs-14 text-dark">{{trans_dynamic('add_contract')}} {{trans_dynamic('mail')}}:</label>
                                <textarea name="contract_add_mail" class="form-control" id="contract_add_mail" rows="10">  {{ $settingsData['contract_add_mail'] }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="form-text" class="form-label fs-14 text-dark">{{trans_dynamic('contract')}} {{trans_dynamic('handover')}} {{trans_dynamic('mail')}}:</label>
                                <textarea name="contract_handover_mail" class="form-control" id="contract_handover_mail" rows="10">  {{ $settingsData['contract_handover_mail'] }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="form-text" class="form-label fs-14 text-dark">{{trans_dynamic('contract')}} {{trans_dynamic('pickup')}} {{trans_dynamic('mail')}}:</label>
                                <textarea name="contract_pickup_mail" class="form-control" id="contract_pickup_mail" rows="10">  {{ $settingsData['contract_pickup_mail'] }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="form-text" class="form-label fs-14 text-dark">{{trans_dynamic('invoice')}} {{trans_dynamic('mail')}}:</label>
                                <textarea name="invoice_mail" class="form-control" id="invoice_mail" rows="10">  {{ $settingsData['invoice_mail'] }}</textarea>
                            </div>
                            <button class="btn btn-primary" type="submit">{{trans_dynamic('edit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection