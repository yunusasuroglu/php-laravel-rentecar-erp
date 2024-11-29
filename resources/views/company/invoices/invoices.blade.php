@extends('layouts.layout')
@section('title', 'Invoices')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
</style>
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">{{trans_dynamic('invoices')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-white-50">{{trans_dynamic('home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('invoices')}}</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            {{trans_dynamic('all')}} {{trans_dynamic('invoices')}}
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="responsivemodal-DataTable" class="table table-bordered text-nowrap"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{trans_dynamic('date')}}</th>
                                <th>{{trans_dynamic('customer')}}</th>
                                <th>{{trans_dynamic('total')}}</th>
                                <th>{{trans_dynamic('status')}}</th>
                                <th>{{trans_dynamic('detail')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            @php
                            $customer = $invoice->customer;
                            @endphp
                            <tr>
                                <td>{{ $invoice->id }}</td>
                                <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
                                <td>{{ $customer['name'] }}</td>
                                <td>{{ number_format($invoice->totalprice, 2) }} €</td>
                                <td>
                                    @if ($invoice->status == 1)
                                    @if ($invoice->payment_status == 1)
                                    <span class="badge bg-success">{{trans_dynamic('completed')}}</span>
                                    @elseif($invoice->payment_status == 2)
                                    <span class="badge bg-warning">{{trans_dynamic('awaiting_approval')}}</span>
                                    @elseif($invoice->payment_status == 3)
                                    <span class="badge bg-danger">{{trans_dynamic('not_completed')}}</span>
                                    @endif
                                    @else
                                    <span class="badge bg-danger">{{trans_dynamic('cancelled')}}</span>
                                    @endif
                                    
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{route('invoices.show',$invoice->id)}}" class="btn btn-primary-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Detail"><i class="bi bi-eye"></i></a>
                                    @if($invoice->payment_status == 3)
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('invoiceForm{{$invoice->id}}').submit();" class="btn btn-danger-light btn-icon btn-sm" data-bs-title="{{trans_dynamic('pay')}}"><i class="bi bi-currency-euro"></i></a>
                                    <form action="{{route('invoices.payment',$invoice->id)}}" method="POST" id="invoiceForm{{$invoice->id}}" style="display: none;">
                                        @csrf
                                    </form>
                                    @elseif($invoice->payment_status == 2)
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('invoiceFormApproved{{$invoice->id}}').submit();" class="btn btn-warning-light btn-icon btn-sm" data-bs-title="{{trans_dynamic('approved')}}"><i class="bi bi-check"></i></a>
                                    <form action="{{route('invoices.approved',$invoice->id)}}" method="POST" id="invoiceFormApproved{{$invoice->id}}" style="display: none;">
                                        @csrf
                                    </form>
                                    @endif
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('invoiceFormCancelled{{$invoice->id}}').submit();" class="btn btn-danger-light btn-icon btn-sm" data-bs-title="{{trans_dynamic('cancelled')}}"><i class="bi bi-x"></i></a>
                                    <form action="{{route('invoices.cancelled',$invoice->id)}}" method="POST" id="invoiceFormCancelled{{$invoice->id}}" style="display: none;">
                                        @csrf
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
    <!-- End:: row-1 -->
</div>
</div>




@endsection