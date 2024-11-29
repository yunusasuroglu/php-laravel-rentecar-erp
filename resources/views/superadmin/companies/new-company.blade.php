@extends('layouts.layout')
@section('title', 'Yeni Şirket Oluştur')
@section('content')
<div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
    <h4 class="fw-medium mb-0">{{trans_dynamic('company_add')}}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('companies')}}" class="text-white-50">{{trans_dynamic('companies')}}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('company_add')}}</li>
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
                            {{trans_dynamic('company_add')}}
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('companies.add') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_name')}}:</label>
                                    <input type="text" name="name" class="form-control" placeholder="{{trans_dynamic('company_name')}}" aria-label="{{trans_dynamic('company_name')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_phone')}}:</label>
                                    <input type="text" name="phone" class="form-control" placeholder="{{trans_dynamic('company_phone')}}" aria-label="{{trans_dynamic('company_phone')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_email')}}:</label>
                                    <input type="email" name="email" class="form-control" placeholder="{{trans_dynamic('company_email')}}" aria-label="{{trans_dynamic('company_email')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_fax')}}:</label>
                                    <input type="text" name="fax" class="form-control" placeholder="{{trans_dynamic('company_fax')}}" aria-label="{{trans_dynamic('company_fax')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_hrb')}}:</label>
                                    <input type="text" name="hrb" class="form-control" placeholder="{{trans_dynamic('company_hrb')}}" aria-label="{{trans_dynamic('company_hrb')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_iban')}}:</label>
                                    <input type="text" name="iban" class="form-control" placeholder="{{trans_dynamic('company_iban')}}" aria-label="{{trans_dynamic('company_iban')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_bic')}}:</label>
                                    <input type="text" name="bic" class="form-control" placeholder="{{trans_dynamic('company_bic')}}" aria-label="{{trans_dynamic('company_bic')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_stnr')}}:</label>
                                    <input type="text" name="stnr" class="form-control" placeholder="{{trans_dynamic('company_stnr')}}" aria-label="{{trans_dynamic('company_stnr')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_ust_id_nr')}}:</label>
                                    <input type="text" name="ust_id_nr" class="form-control" placeholder="{{trans_dynamic('company_ust_id_nr')}}" aria-label="{{trans_dynamic('company_ust_id_nr')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_registry_court')}}:</label>
                                    <input type="text" name="registry_court" class="form-control" placeholder="{{trans_dynamic('company_registry_court')}}" aria-label="{{trans_dynamic('company_registry_court')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_general_manager')}}:</label>
                                    <input type="text" name="general_manager" class="form-control" placeholder="{{trans_dynamic('company_general_manager')}}" aria-label="{{trans_dynamic('company_general_manager')}}">
                                </div>
                                {{-- Adres Bilgileri Başlangıç --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{trans_dynamic('street')}}:</label>
                                    <input type="text" name="street" class="form-control" placeholder="{{trans_dynamic('street')}}" aria-label="{{trans_dynamic('street')}}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{trans_dynamic('zip_code')}}:</label>
                                    <input type="text" name="zip_code" class="form-control" placeholder="{{trans_dynamic('delete')}}" aria-label="{{trans_dynamic('delete')}}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{trans_dynamic('city')}}:</label>
                                    <input type="text" name="city" class="form-control" placeholder="{{trans_dynamic('city')}}" aria-label="{{trans_dynamic('city')}}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{trans_dynamic('country')}}:</label>
                                    <select class="form-select" name="country" id="country">
                                        <option value="Deutschland">Deutschland</option>
                                        <option value="Niederlande">Niederlande</option>
                                        <option value="Österreich">Österreich</option>
                                        <option value="Dänemark">Dänemark</option>
                                        <option value="Schweden">Schweden</option>
                                        <option value="Frankreich">Frankreich</option>
                                        <option value="Belgien">Belgien</option>
                                        <option value="Italien">Italien</option>
                                        <option value="Griechenland">Griechenland</option>
                                        <option value="Schweiz">Schweiz</option>
                                        <option value="Polen">Polen</option>
                                        <option value="Kroatien">Kroatien</option>
                                        <option value="Rumänien">Rumänien</option>
                                        <option value="Tschechien">Tschechien</option>
                                        <option value="Serbien">Serbien</option>
                                        <option value="Ungarn">Ungarn</option>
                                        <option value="Bulgarien">Bulgarien</option>
                                        <option value="Russland">Russland</option>
                                        <option value="Weißrussland">Weißrussland</option>
                                        <option value="Türkei">Türkei</option>
                                        <option value="Norwegen">Norwegen</option>
                                        <option value="England">England</option>
                                        <option value="Irland">Irland</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="Spanien">Spanien</option>
                                        <option value="Slowenien">Slowenien</option>
                                        <option value="Slowakei">Slowakei</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Luxemburg">Luxemburg</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Litauen">Litauen</option>
                                        <option value="Lettland">Lettland</option>
                                        <option value="Kasachstan">Kasachstan</option>
                                        <option value="Island">Island</option>
                                        <option value="Estland">Estland</option>
                                        <option value="Finnland">Finnland</option>
                                        <option value="Bosnien und Herzegowina">Bosnien und Herzegowina</option>
                                    </select>
                                </div>
                                 {{-- Adres Bilgileri Bitiş --}}
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">{{trans_dynamic('create')}}</button>
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