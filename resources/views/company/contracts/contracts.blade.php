@extends('layouts.layout')
@section('title', 'Contracts')
@section('content')
<link rel="stylesheet" href="{{asset('/')}}/assets/libs/gridjs/theme/mermaid.min.css">
<style>
    #responsiveDataTable_wrapper .row{
        margin-bottom: 20px;
    }
</style>
<div class="d-sm-flex d-block align-items-center justify-content-between page-header-breadcrumb">
    <h4 class="fw-medium mb-0">{{trans_dynamic('contracts')}}</h4>
    <div class="ms-sm-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">{{auth()->user()->company->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('contracts')}}</li>
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
                            {{trans_dynamic('contracts')}} ({{$contracts->count()}})
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="search-input" placeholder="{{trans_dynamic('search')}}...">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <select class="form-select" id="status-filter">
                                        <option value="">{{trans_dynamic('all')}} {{trans_dynamic('status')}}</option>
                                        <option value="Draft">{{trans_dynamic('draft')}}</option>
                                        <option value="Completed">{{trans_dynamic('completed')}}</option>
                                        <option value="Pickup">{{trans_dynamic('pickup')}}</option>
                                        <option value="Expired">{{trans_dynamic('expired')}}</option>
                                        <option value="Handovered">{{trans_dynamic('delivered')}}</option>
                                        <option value="Canceled">{{trans_dynamic('cancelled')}}</option>
                                        <option value="Not Signed">{{trans_dynamic('not_signed')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <table id="datatable-rnt" class="table mt-3 table-bordered text-nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">{{trans_dynamic('contract')}} {{trans_dynamic('date')}}</th>
                                    <th scope="col">{{trans_dynamic('car')}}</th>
                                    <th scope="col">{{trans_dynamic('customer')}}</th>
                                    <th scope="col">{{trans_dynamic('status')}}</th>
                                    <th scope="col">{{trans_dynamic('detail')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contracts as $contract)
                                @php
                                if (is_string($contract->car)) {
                                    $carData = json_decode($contract->car, true); // JSON string ise diziye çevir
                                } else {
                                    // Zaten bir dizi ise, doğrudan kullan
                                    $carData = $contract->car;
                                }
                                if (is_string($contract->customer)) {
                                    $customerData = json_decode($contract->customer, true); // JSON string ise diziye çevir
                                } else {
                                    // Zaten bir dizi ise, doğrudan kullan
                                    $customerData = $contract->customer;
                                }
                                
                                // end_date veya extra_date'i kullanarak tarih hesaplama
                                $endDate = \Carbon\Carbon::parse($contract->end_date);
                                $extraDate = $contract->extra_date ? \Carbon\Carbon::parse($contract->extra_date) : null;
                                
                                // Eğer extra_date varsa endDate yerine onu kullan
                                $effectiveEndDate = $extraDate ? $extraDate : $endDate;
                                
                                $now = \Carbon\Carbon::now(); // Şu anki tarih
                                $daysRemaining = $effectiveEndDate->diffInDays($now); // Kalan gün sayısını hesapladık
                                $isExpired = $effectiveEndDate->isPast(); // Sürenin dolup dolmadığını kontrol ettik
                                $almostExpired = $daysRemaining <= 1; // Sürenin dolmasına 1 gün kaldı mı kontrol ettik
                                @endphp
                                <tr @if ($isExpired) style="background-color: #000;" @endif>
                                    <td>
                                        {{$contract->id}}
                                    </td>
                                    <td>
                                        {{$contract->created_at->format('d/m/Y H:i')}}
                                        @if($contract->status == 6)
                                        (<span class="text-success">{{trans_dynamic('completed')}}</span>)
                                        @else
                                        (
                                        @if ($isExpired)
                                        <span class="text-danger">{{trans_dynamic('expired')}}</span>
                                        @elseif ($almostExpired)
                                        <span class="text-danger">{{trans_dynamic('expires_in_1_day')}}</span>
                                        @else
                                        <span class="text-success">{{trans_dynamic('continues')}}</span>
                                        @endif
                                        )
                                        @endif
                                    </td>
                                    <td>{{$carData['car']['brand']}} {{$carData['car']['model']}}</td>
                                    <td>{{$customerData['name']}} {{$customerData['surname']}}</td>
                                    <td>
                                        @if ($isExpired)
                                        <span class="badge bg-danger">{{trans_dynamic('expired')}}</span>
                                        @else
                                        @if ($contract->status == 1)
                                        <span class="badge bg-primary">{{trans_dynamic('delivered')}}</span>
                                        @elseif($contract->status == 4)
                                        <span class="badge bg-danger">{{trans_dynamic('cancelled')}}</span>
                                        @elseif($contract->status == 3)
                                        <span class="badge bg-dark-transparent">{{trans_dynamic('draft')}}</span>
                                        @elseif($contract->status == 2 && $contract->signature == null)
                                        <span class="badge bg-warning">{{trans_dynamic('not_signed')}}</span>
                                        @elseif($contract->status == 5)
                                        <span class="badge bg-danger">{{trans_dynamic('pickup')}}</span>
                                        @elseif($contract->status == 6)
                                        <span class="badge bg-success">{{trans_dynamic('completed')}}</span>
                                        @endif
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($isExpired)
                                        <a href="{{route('contracts.detail', $contract->id)}}" class="btn btn-primary-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Detail"><i class="bi bi-eye"></i></a>
                                        @elseif ($contract->status != 4 && $contract->status != 5 && $contract->status != 6 && $almostExpired)
                                        <a href="{{route('contracts.detail', $contract->id)}}" class="btn btn-primary-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Detail"><i class="bi bi-eye"></i></a>
                                        <a href="{{route('contracts.extradate', $contract->id)}}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('expires_in_1_day')}}"><i class="bi bi-calendar-plus"></i></a>
                                        @if ($contract->status == 3)
                                        <a href="{{route('contracts.deliver', $contract->id)}}" class="btn btn-success-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('handover')}}"><i class="ri ri-car-washing-fill"></i></a>
                                        @elseif($contract->status == 1)
                                        <a href="{{route('contracts.pickup', $contract->id)}}" class="btn btn-danger-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('pickup')}}"><i class="ri ri-car-line"></i></a>
                                        @elseif($contract->status == 5)
                                        <a href="{{route('contracts.invoice', $contract->id)}}" class="btn btn-success btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('invoice')}}"><i class="bx bx-archive"></i></a>
                                        @endif
                                        @if ($contract->status == 2 && $contract->signature == null)
                                        <a href="{{route('contracts.sign', $contract->id)}}" class="btn btn-warning-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('sign')}}"><i class="ri ri-pen-nib-line"></i></a>
                                        @endif
                                        @else
                                        <a href="{{route('contracts.detail', $contract->id)}}" class="btn btn-primary-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('detail')}}"><i class="bi bi-eye"></i></a>
                                        @if ($contract->status == 3)
                                        <a href="{{route('contracts.deliver', $contract->id)}}" class="btn btn-success-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('handover')}}"><i class="ri ri-car-washing-fill"></i></a>
                                        @elseif($contract->status == 1)
                                        <a href="{{ route('contracts.pdf', $contract->id) }}" class="btn btn-warning-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('download_pdf')}}"><i class="ri ri-file-pdf-line"></i></a>
                                        <a href="{{route('contracts.pickup', $contract->id)}}" class="btn btn-danger-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('pickup')}}"><i class="ri ri-car-line"></i></a>
                                        @elseif($contract->status == 5)
                                        <a href="{{route('contracts.invoice', $contract->id)}}" class="btn btn-success btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('invoice')}}"><i class="bx bx-archive"></i></a>
                                        @endif
                                        @if ($contract->status == 2 && $contract->signature == null)
                                        <a href="{{route('contracts.sign', $contract->id)}}" class="btn btn-warning-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{trans_dynamic('sign')}}"><i class="ri ri-pen-nib-line"></i></a>
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                        <ul class="pagination mt-3" style="text-align: end;">
                            <li href="javascript:void(0);" class="page-item disabled">
                                <a id="prev-page" class="page-link">{{trans_dynamic('previous')}}</a>
                            </li>
                            <li class="page-item active">
                                <a id="page-info" class="page-link" href="javascript:void(0);">1</a>
                            </li>
                            <li class="page-item">
                                <a id="next-page" class="page-link" href="javascript:void(0);">{{trans_dynamic('next')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-1 -->
    </div>
</div>

@endsection