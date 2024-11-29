@extends('layouts.layout')
@section('title', 'Yeni Rol Oluştur')
@section('content')
<div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
    <h4 class="fw-medium mb-0">{{ trans_dynamic('role_add') }}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">{{ trans_dynamic('roles') }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ trans_dynamic('role_add') }}</li>
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
                            {{ trans_dynamic('role_add') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('role.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">{{ trans_dynamic('name') }}:</label>
                                    <input type="text" name="role_name" class="form-control" placeholder="Rol" aria-label="Rol">
                                </div>
                                <div class="col-md-12 row mb-3">
                                    <label class="form-label">{{ trans_dynamic('permissions') }}:</label><br>
                                    @foreach($permissions as $permission)
                                    <div class="col-md-2 mb-2">
                                        <div class="form-check form-check-md d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" id="permission_{{ $permission->id }}" value="{{ $permission->id }}">
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">{{ trans_dynamic('create') }}</button>
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