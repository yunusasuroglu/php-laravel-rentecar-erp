@extends('layouts.layout')
@section('title', 'Car Groups')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
</style>
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">{{trans_dynamic('car_groups')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('cars')}}" class="text-white-50">{{trans_dynamic('cars')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('car_groups')}}</li>
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
                            {{trans_dynamic('car_groups')}}
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatable-basic" class="table table-bordered text-nowrap mt-2" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">{{trans_dynamic('name')}}</th>
                                    <th style="text-align:center !important;" scope="col">{{trans_dynamic('detail')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carGroups as $group)
                                <tr>
                                    <td>{{$group->name}}</td>
                                    <td style="text-align: center;">
                                        <form action="{{route('cars.group.delete',$group->id)}}" method="POST">
                                            @csrf
                                            <a href="{{route('cars.group.edit',$group->id)}}" class="btn btn-success-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('edit')}}"><i class="bi bi-pencil"></i></a>
                                            <button type="submit" class="btn btn-danger-light btn-icon btn-sm" data-bs-title="{{trans_dynamic('delete')}}"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
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