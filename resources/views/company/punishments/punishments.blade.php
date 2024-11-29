@extends('layouts.layout')
@section('title', 'Punishments')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
</style>
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">{{trans_dynamic('punishments')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">{{auth()->user()->company->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('punishments')}}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="main-content app-content">
    <div class="container-fluid">
        
        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            {{trans_dynamic('punishments')}}
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatable-basic" class="table mt-3 table-bordered text-nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">{{trans_dynamic('creator')}}</th>
                                    <th scope="col">{{trans_dynamic('car')}}</th>
                                    <th scope="col">{{trans_dynamic('driver')}}</th>
                                    <th scope="col">{{trans_dynamic('punishment')}}</th>
                                    <th scope="col">{{trans_dynamic('recipient_institution')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($punishments as $punishment)
                                <tr>
                                    <td>#{{$punishment->id}}</td>
                                    <td>{{$punishment->created_at}}</td>
                                    <td>{{$punishment->car}}</td>
                                    <td>{{$punishment->driver}}</td>
                                    <td>{{$punishment->punishment}}</td>
                                    <td>{{$punishment->corporate_email}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-1 -->
    </div>
</div>

@endsection