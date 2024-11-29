@extends('layouts.layout')
@php
$title = trans_dynamic('employee_dashboard_page_title');
@endphp

@section('title', $title)
@section('content')
<div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
    <h4 class="fw-medium mb-0">{{ trans_dynamic('employee_dashboard_page_name') }}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">{{env('APP_NAME')}}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ trans_dynamic('employee_dashboard_page_name') }}</li>
    </ol>
</div>
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="row row-cols-xxl-5 row-cols-xl-3 row-cols-md-2">
                    <div class="col card-background flex-fill">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <p class="fw-medium text-muted mb-1">{{ trans_dynamic('employee_dashboard_card3_name') }}</p>
                                        <h3 class="mb-0">47</h3>
                                    </div>
                                    <div class="avatar avatar-md br-4 bg-info-transparent ms-auto">
                                        <i class="bx bx-receipt fs-20"></i>
                                    </div>
                                </div>
                                <div class="d-flex mt-2">
                                    <a href="javascript:void(0);" class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{ trans_dynamic('employee_dashboard_card3_more_info') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col card-background flex-fill">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <p class="fw-medium mb-1 text-muted">{{ trans_dynamic('employee_dashboard_card4_name') }}</p>
                                        <h3 class="mb-0">52</h3>
                                    </div>
                                    <div class="avatar avatar-md br-4 bg-danger-transparent ms-auto">
                                        <i class="bx bxs-truck fs-20"></i>
                                    </div>
                                </div>
                                <div class="d-flex mt-2">
                                    <span class="badge bg-success-transparent rounded-pill">+10% <i class="fe fe-arrow-up"></i></span>
                                    <a href="javascript:void(0);" class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{ trans_dynamic('employee_dashboard_card4_more_info') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col card-background flex-fill">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <p class="fw-medium text-muted mb-1">{{ trans_dynamic('employee_dashboard_card5_name') }}</p>
                                        <h3 class="mb-0">2100 €</h3>
                                    </div>
                                    <div class="avatar avatar-md br-4 bg-warning-transparent ms-auto">
                                        <i class="bi bi-currency-euro fs-20"></i>
                                    </div>
                                </div>
                                <div class="d-flex mt-2">
                                    <span class="badge bg-danger-transparent rounded-pill">+16% <i class="fe fe-arrow-down"></i></span>
                                    <a href="javascript:void(0);" class="text-muted fs-11 ms-auto text-decoration-underline mt-auto">{{ trans_dynamic('employee_dashboard_card5_more_info') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-1 -->
        <div class="row">
            <div class="col-xxl-4 col-xl-12">
                <div class="row">
                    <div class="col-xxl-12 col-xl-6 col-lg-6">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    {{ trans_dynamic('employee_dashboard_invoice') }}
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table text-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="row" class="fw-semibold ps-4">{{ trans_dynamic('employee_dashboard_invoice_date') }}</th>
                                                <th scope="row" class="fw-semibold">{{ trans_dynamic('employee_dashboard_invoice_price') }}</th>
                                                <th scope="row" class="fw-semibold">{{ trans_dynamic('employee_dashboard_invoice_detail') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="top-selling">
                                            <tr>
                                                <td  class=" ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-2">
                                                            <p class="mb-0 fw-semibold">04. January 2024</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold">2500 €</span>
                                                </td>
                                                <td>
                                                    <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                        <span class="ri-eye-line fs-14"></span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  class=" ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-2">
                                                            <p class="mb-0 fw-semibold">04. January 2024</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold">846 €</span>
                                                </td>
                                                <td>
                                                    <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                        <span class="ri-eye-line fs-14"></span>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=" ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-2">
                                                            <p class="mb-0 fw-semibold">04. January 2024</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold">1,024 €</span>
                                                </td>
                                                <td>
                                                    <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                        <span class="ri-eye-line fs-14"></span>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-8  col-xl-12">
                <div class="row">
                    <div class="col-xxl-12 col-xl-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    {{ trans_dynamic('employee_dashboard_shipments') }}
                                </div>
                                <div class="dropdown">
                                    <a aria-label="anchor" href="javascript:void(0);" class="btn btn-outline-light btn-icons btn-sm text-muted my-1" data-bs-toggle="dropdown">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu mb-0">
                                        <li class="border-bottom"><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                                        <li class="border-bottom"><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table text-nowrap table-hover rounded-3 overflow-hidden">
                                                <thead>
                                                    <tr>
                                                        <th scope="row" class="ps-4">{{ trans_dynamic('employee_dashboard_shipments_table_customer') }}</th>
                                                        <th scope="row">{{ trans_dynamic('employee_dashboard_shipments_table_status') }}</th>
                                                        <th scope="row">{{ trans_dynamic('employee_dashboard_shipments_table_price') }}</th>
                                                        <th scope="row">{{ trans_dynamic('employee_dashboard_shipments_table_type') }}</th>
                                                        <th scope="row">{{ trans_dynamic('employee_dashboard_shipments_table_detail') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class=" ps-4">
                                                                <a href="product-details.html">Münir Er</a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="mt-sm-1 d-block">
                                                                <span
                                                                class="badge bg-warning-transparent text-warning">Unterwegs</span>
                                                            </div>
                                                        </td>
                                                        <td>1200 €</td>
                                                        <td>Meine Bestellung</td>
                                                        <td>
                                                            <div class="g-2">
                                                                <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                    <span class="ri-pencil-line fs-14"></span>
                                                                </a>
                                                                <a aria-label="anchor" class="btn btn-danger-light btn-sm ms-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                    <span class="ri-delete-bin-7-line fs-14"></span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class=" ps-4">
                                                            <div class="d-flex align-items-center">
                                                                <a href="product-details.html">Adem Demir</a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="mt-sm-1 d-block">
                                                                <span
                                                                class="badge bg-warning-transparent text-warning">Unterwegs</span>
                                                            </div>
                                                        </td>
                                                        <td>200 €</td>
                                                        <td>Subunternehmer</td>
                                                        <td>
                                                            <div class="g-2">
                                                                <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                    <span class="ri-pencil-line fs-14"></span>
                                                                </a>
                                                                <a aria-label="anchor" class="btn btn-danger-light btn-sm ms-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                    <span class="ri-delete-bin-7-line fs-14"></span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class=" ps-4">
                                                                <a href="product-details.html">Mert Kaya</a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="mt-sm-1 d-block">
                                                                <span
                                                                class="badge bg-success-transparent text-success">Wurde geliefert</span>
                                                            </div>
                                                        </td>
                                                        <td>1200 €</td>
                                                        <td>Meine Bestellung</td>
                                                        <td>
                                                            <div class="g-2">
                                                                <a aria-label="anchor" class="btn  btn-primary-light btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                                    <span class="ri-pencil-line fs-14"></span>
                                                                </a>
                                                                <a aria-label="anchor" class="btn btn-danger-light btn-sm ms-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                                                    <span class="ri-delete-bin-7-line fs-14"></span>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-1 END -->
        <!-- End::row-1 -->
        
    </div>
</div>

@endsection
