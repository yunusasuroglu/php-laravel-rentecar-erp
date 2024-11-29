@extends('layouts.layout')
@section('title', 'Roller')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
    <h4 class="fw-medium mb-0">{{ trans_dynamic('roles') }}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">{{ trans_dynamic('users') }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ trans_dynamic('roles') }}</li>
    </ol>
</div>
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">{{ trans_dynamic('roles') }}</div>
                        <div style="margin-left: auto;" class="card-title"> <a href="{{route('role.create')}}" class="btn btn-primary">{{ trans_dynamic('role_add') }}</a></div>
                    </div>
                    <div class="card-body">
                        <div id="file-export_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="dataTables_scroll">
                                <div class="dataTables_scrollHead" style="overflow: hidden; position: relative; border: 0px; width: 100%;">
                                    <div class="dataTables_scrollHeadInner" style="box-sizing: content-box; width: 719px; padding-right: 0px;">
                                        <table class="table table-bordered text-nowrap dataTable no-footer" style="width: 719px; margin-left: 0px;">
                                            <thead>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="dataTables_scrollBody " style="position: relative; overflow: auto; width: 100%;">
                                    <table id="file-export" class="table table-bordered text-nowrap dataTable no-footer" style="width: 100%;" aria-describedby="file-export_info">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="sorting sorting_asc" tabindex="0" aria-controls="file-export" rowspan="1" colspan="1" style="width: 94.9375px;" aria-sort="id" aria-label="Name: activate to sort column descending">ID</th>
                                                <th scope="col" class="sorting" tabindex="0" aria-controls="file-export" rowspan="1" colspan="1" style="width: 169.663px;" aria-label="{{ trans_dynamic('name') }}: activate to sort column ascending">{{ trans_dynamic('name') }}</th>
                                                <th scope="col" class="sorting" tabindex="0" aria-controls="file-export" rowspan="1" colspan="1" style="width: 56.6px;" aria-label="İzin: activate to sort column ascending">{{ trans_dynamic('permissions') }}</th>
                                                <th scope="col" class="sorting" tabindex="0" aria-controls="file-export" rowspan="1" colspan="1" style="width: 56.6px;" aria-label="Detay: activate to sort column ascending">{{ trans_dynamic('detail') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $counter = 0;
                                            @endphp
                                            
                                            @foreach ($roles as $role)
                                            <tr class="{{ $counter % 2 == 0 ? 'odd' : 'even' }}">
                                                <td class="sorting_1">#{{ $role->id }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    @foreach($role->permissions as $permission)
                                                        <span class="badge bg-outline-dark">{{ $permission->name }}</span>,
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-success">{{ trans_dynamic('edit') }}</a>

                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" type="submit">{{ trans_dynamic('delete') }}</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @php
                                            $counter++;
                                            @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="dataTables_paginate paging_simple_numbers" id="file-export_paginate"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection