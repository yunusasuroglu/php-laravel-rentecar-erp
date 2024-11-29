@extends('layouts.layout')
@section('title', 'Contract Detail')
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
    #fuelleve2 {
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
    <h4 class="fw-medium mb-0">{{trans_dynamic('contract')}} - {{trans_dynamic('extra_date')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('contracts')}}" class="text-white-50">{{trans_dynamic('contracts')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('contract')}} - {{trans_dynamic('extra_date')}}</li>
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
                            {{trans_dynamic('extra')}} {{trans_dynamic('day')}} {{trans_dynamic('add')}}
                        </div>
                    </div>
                    <form action="{{route('contracts.extradate.send')}}" method="POST">
                        @csrf
                        <input type="hidden" name="contract_id" value="{{$contract->id}}">
                        <div class="card-body">
                            <div class="form-floating mb-3">
                                <div class="form-group">
                                    <label class="form-label" for="">{{trans_dynamic('extra')}} {{trans_dynamic('day')}}:</label>
                                    <div class="input-group">
                                        <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                                        <input value="{{$contract->end_date}}" type="text" name="extra_date" class="form-control start_date_contract" id="datetime" data-date-format="Y-m-d">
                                    </div>
                                </div>
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