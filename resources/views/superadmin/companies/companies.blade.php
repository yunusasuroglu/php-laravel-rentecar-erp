@extends('layouts.layout')
@section('title', 'Şirketler')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
    <h4 class="fw-medium mb-0">{{trans_dynamic('companies')}}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">{{trans_dynamic('home')}}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('companies')}}</li>
    </ol>
</div>
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">{{trans_dynamic('companies')}}</div>
                        <div style="margin-left: auto;" class="card-title"> <a href="{{route('companies.new')}}" class="btn btn-primary">{{trans_dynamic('company_add')}}</a></div>
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
                                                <th scope="col" class="sorting" tabindex="0" aria-controls="file-export" rowspan="1" colspan="1" style="width: 169.663px;" aria-label="İsim Soyisim: activate to sort column ascending">{{trans_dynamic('company_name')}}</th>
                                                <th scope="col" class="sorting" tabindex="0" aria-controls="file-export" rowspan="1" colspan="1" style="width: 73.2875px;" aria-label="E-Posta: activate to sort column ascending">{{trans_dynamic('company_email')}}</th>
                                                <th scope="col" class="sorting" tabindex="0" aria-controls="file-export" rowspan="1" colspan="1" style="width: 26.1875px;" aria-label="Kullanıcı Türü: activate to sort column ascending">{{trans_dynamic('company_phone')}}</th>
                                                <th scope="col" class="sorting" tabindex="0" aria-controls="file-export" rowspan="1" colspan="1" style="width: 26.1875px;" aria-label="Kullanıcı Durumu: activate to sort column ascending">{{trans_dynamic('created_at')}}</th>
                                                <th scope="col" class="sorting" tabindex="0" aria-controls="file-export" rowspan="1" colspan="1" style="width: 169.663px;" aria-label="Şirket: activate to sort column ascending">{{trans_dynamic('status')}}</th>
                                                <th scope="col" class="sorting" tabindex="0" aria-controls="file-export" rowspan="1" colspan="1" style="width: 56.6px;" aria-label="Detay: activate to sort column ascending">{{trans_dynamic('detail')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $counter = 0;
                                            @endphp
                                            
                                            @foreach ($companies as $company)
                                            @php
                                            $address = json_decode($company->address, true);
                                            @endphp
                                            <tr class="{{ $counter % 2 == 0 ? 'odd' : 'even' }}">
                                                <td class="sorting_1">{{ $counter }}</td>
                                                <td>{{ $company->name }}</td>
                                                <td>{{ $company->tax_number }}</td>
                                                <td>{{ $company->email }}</td>
                                                <td>{{ $company->phone }}</td>
                                                <td>{{ $company->created_at->format('d/m/Y')}}</td>
                                                <td>
                                                    @if ($company->status == 1)
                                                    <span class="badge bg-outline-success">{{trans_dynamic('active')}}</span>
                                                    @else
                                                    <form action="{{ route('company.approve', $company->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary">{{trans_dynamic('approved')}}</button>
                                                    </form>
                                                    @endif    
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST">
                                                        <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-success">{{trans_dynamic('edit')}}</a>

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