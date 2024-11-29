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


        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xl-9">
                <div class="card custom-card">
                    <div class="card-header d-md-flex d-block">
                        <div class="h5 mb-0 d-sm-flex d-bllock align-items-center">
                            <div>
                                <img src="../assets/images/brand-logos/toggle-logo.png" alt="">
                            </div>
                            <div class="ms-sm-2 ms-0 mt-sm-0 mt-2">
                                <div class="h6 fw-semibold mb-0">{{trans_dynamic('shopping_invoice')}} : <span class="text-primary">#{{$invoice->id}}</span></div>
                            </div>
                        </div>
                        <div class="ms-auto mt-md-0 mt-2">
                            <form action="{{ route('invoices.resend', $invoice->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary me-1">{{trans_dynamic('resend_invoice')}}<i class="bx bx-envelope ms-1 align-middle d-inline-flex"></i></button>
                            </form>
                        </div>
                        <div class="">
                            <a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-primary me-1">{{trans_dynamic('download_pdf')}} {{trans_dynamic('invoice')}}<i class="bx bx-download ms-1 align-middle d-inline-flex"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                        <p class="text-muted mb-2">
                                            {{trans_dynamic('billing_from')}} :
                                        </p>
                                        <p class="fw-bold mb-1">
                                            {{ $company->name ?? 'Şirket Adı Bilinmiyor' }}
                                        </p>
                                        <p class="mb-1 text-muted">
                                            {{ $company->address_line_1 ?? 'Adres Bilinmiyor' }}
                                        </p>
                                        <p class="mb-1 text-muted">
                                            {{ $company->city }}, {{ $company->state }}, {{ $company->country }}, {{ $company->postal_code }}
                                        </p>
                                        <p class="mb-1 text-muted">
                                            {{ $company->email ?? 'E-posta Bilinmiyor' }}
                                        </p>
                                        <p class="mb-1 text-muted">
                                            {{ $company->phone ?? 'Telefon Bilinmiyor' }}
                                        </p>
                                        <p class="text-muted">{{trans_dynamic('billing_text')}} <a href="javascript:void(0);" class="text-primary fw-semibold"><u>GSTIN</u></a> {{trans_dynamic('details')}}.</p>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 ms-auto mt-sm-0 mt-3">
                                        <p class="text-muted mb-2">
                                            {{trans_dynamic('billing_to')}} :
                                        </p>
                                        <p class="fw-bold mb-1">
                                            {{$invoiceJson['customer']['name'] ?? ''}}
                                        </p>
                                        <p class="text-muted mb-1">
                                            {{$invoiceJson['customer']['zip_code'] ?? ''}} {{$invoiceJson['customer']['city'] ?? ''}}
                                        </p>
                                        <p class="text-muted mb-1">
                                            {{$invoiceJson['customer']['email'] ?? ''}}
                                        </p>
                                    </div>
                                </div>
                                {{-- {{$invoice->author_company}} --}}
                            </div>
                            <div class="col-xl-3">
                                <p class="fw-semibold text-muted mb-1">{{trans_dynamic('invoice')}} ID :</p>
                                <p class="fs-15 mb-1">#{{$invoice->id}}</p>
                            </div>
                            <div class="col-xl-3">
                                <p class="fw-semibold text-muted mb-1">{{trans_dynamic('date_issued')}} :</p>
                                <p class="fs-15 mb-1">{{$invoice->updated_at->format('d/m/y')}}</p>
                              </div>
                            <div class="col-xl-3">
                                <p class="fw-semibold text-muted mb-1">{{trans_dynamic('due_date')}} :</p>
                                <p class="fs-15 mb-1">{{$invoice->created_at->format('d/m/y')}}</p>
                            </div>
                            <div class="col-xl-3">
                                <p class="fw-semibold text-muted mb-1">{{trans_dynamic('due_amount')}} :</p>
                                <p class="fs-16 mb-1 fw-semibold">{{$invoice->totalprice}} €</p>
                            </div>
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table class="table nowrap text-nowrap border mt-4">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{trans_dynamic('product')}}</th>
                                                <th scope="col">{{trans_dynamic('description')}}</th>
                                                <th scope="col">{{trans_dynamic('price')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($items as $item)
                                                <tr>
                                                    <td>
                                                        <div class="fw-semibold">
                                                            {{ $item['name'] ?? {{trans_dynamic('item')}} {{trans_dynamic('name')}} }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-muted">
                                                            {{ $item['description'] ?? {{trans_dynamic('description')}} }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $item['total_amount'] ?? 0 }} €
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div>
                                    <label for="invoice-note" class="form-label">{{trans_dynamic('note')}}:</label>
                                    <textarea disabled class="form-control form-control-light" id="invoice-note" rows="3">
                                        {{$invoice->note}}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            {{trans_dynamic('mode_of_payment')}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <p class="fs-14 fw-semibold">
                                    {{$invoice->payment_option}}
                                </p>
                                <p>
                                    <span class="fw-semibold text-muted fs-12">{{trans_dynamic('total')}} {{trans_dynamic('amount')}} :</span> <span class="text-success fw-semibold fs-14">{{$invoice->totalprice}}</span>
                                </p>
                                <p>
                                    @if($invoice->payment_status == 3)
                                    <span class="fw-semibold text-muted fs-12">{{trans_dynamic('invoice')}} {{trans_dynamic('status')}} : <span class="badge bg-danger-transparent">{{trans_dynamic('not_paid')}}</span></span>
                                    @elseif($invoice->payment_status == 2)
                                    <span class="fw-semibold text-muted fs-12">{{trans_dynamic('invoice')}} {{trans_dynamic('status')}} : <span class="badge bg-warning-transparent">{{trans_dynamic('await')}}</span></span>
                                    @elseif($invoice->payment_status == 1)
                                    <span class="fw-semibold text-muted fs-12">{{trans_dynamic('invoice')}} {{trans_dynamic('status')}} : <span class="badge bg-success-transparent">{{trans_dynamic('completed')}}</span></span>
                                    @endif
                                </p>
                                <div class="alert alert-success" role="alert">
                                    {{trans_dynamic('payment_text')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-1 -->

    </div>
</div>
@endsection