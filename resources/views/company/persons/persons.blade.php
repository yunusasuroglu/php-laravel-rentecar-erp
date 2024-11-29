@extends('layouts.layout')
@section('title', 'Emplooye')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
</style>
<div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
    <h4 class="fw-medium mb-0">{{trans_dynamic('users')}}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-white-50">{{trans_dynamic('home')}}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('users')}}</li>
    </ol>
</div>
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">{{trans_dynamic('users')}}</div>
                        <div style="margin-left: auto;" class="card-title"> <a href="{{route('persons.new')}}" class="btn btn-primary">{{trans_dynamic('user_add')}}</a></div>
                    </div>
                    <div class="card-body">
                        <div id="file-export_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="dataTables_scroll">
                                <div class="dataTables_scrollBody " style="position: relative; overflow: auto; width: 100%;">
                                    <table id="responsiveDataTable" class="table table-bordered text-nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">{{trans_dynamic('name')}} & {{trans_dynamic('surname')}}</th>
                                                <th scope="col">{{trans_dynamic('phone')}}</th>
                                                <th scope="col">{{trans_dynamic('company')}}</th>
                                                <th scope="col">{{trans_dynamic('email')}}</th>
                                                <th scope="col">{{trans_dynamic('position')}}</th>
                                                <th scope="col">{{trans_dynamic('status')}}</th>
                                                <th scope="col">{{trans_dynamic('detail')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $counter = 0;
                                            @endphp
                                            
                                            @foreach ($person as $user)
                                            <tr class="{{ $counter % 2 == 0 ? 'odd' : 'even' }}">
                                                <td class="sorting_1">#{{ $counter }}</td>
                                                <td>{{ $user->name }} {{ $user->surname }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>
                                                    @if ($user->company)
                                                    {{ $user->company->name }}
                                                    @else
                                                    {{trans_dynamic('company')}} {{trans_dynamic('not_found')}}
                                                    @endif    
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td class="text-center">
                                                    @foreach ($user->roles as $role)
                                                    <span class="badge bg-outline-danger">{{ $role->name }}</span>
                                                    @endforeach
                                                </td>
                                                <td class="text-center">
                                                    @if ($user->status == 1)
                                                    <span class="badge bg-outline-success">{{trans_dynamic('active')}}</span>
                                                    @else
                                                    <form action="{{ route('employee.approve', $user->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary">{{trans_dynamic('approve')}}</button>
                                                    </form>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('persons.destroy', $user->id) }}" method="POST">
                                                        <a href="{{ route('persons.edit', $user->id) }}" class="btn btn-success">{{trans_dynamic('edit')}}</a>

                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" type="submit">{{trans_dynamic('delete')}}</button>
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
                            <div class="dataTables_paginate paging_simple_numbers" id="file-export_paginate">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection