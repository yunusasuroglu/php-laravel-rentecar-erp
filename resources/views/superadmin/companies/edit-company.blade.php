@extends('layouts.layout')
@section('title', 'Şirket Güncelle')
@section('content')
<div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
    <h4 class="fw-medium mb-0">{{trans_dynamic('company_edit')}}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('companies')}}" class="text-white-50">{{trans_dynamic('companies')}}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{trans_dynamic('company_edit')}}</li>
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
                            {{trans_dynamic('company_edit')}}
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('companies.update', $company->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_name')}}:</label>
                                    <input type="text" name="name" value="{{$company->name}}" class="form-control" placeholder="{{trans_dynamic('company_name')}}" aria-label="{{trans_dynamic('company_name')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_phone')}}:</label>
                                    <input type="text" name="phone" class="form-control" value="{{$company->phone}}" placeholder="{{trans_dynamic('company_phone')}}" aria-label="{{trans_dynamic('company_phone')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_email')}}:</label>
                                    <input type="email" name="email" value="{{$company->email}}" class="form-control" placeholder="{{trans_dynamic('company_email')}}" aria-label="email">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_fax')}}:</label>
                                    <input type="text" name="fax" value="{{$company->fax}}" class="form-control" placeholder="{{trans_dynamic('company_fax')}}" aria-label="{{trans_dynamic('company_fax')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_hrb')}}:</label>
                                    <input type="text" name="hrb" value="{{$company->hrb}}" class="form-control" placeholder="{{trans_dynamic('company_hrb')}}" aria-label="{{trans_dynamic('company_hrb')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_iban')}}:</label>
                                    <input type="text" name="iban" value="{{$company->iban}}" class="form-control" placeholder="{{trans_dynamic('company_iban')}}" aria-label="{{trans_dynamic('company_iban')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_bic')}}:</label>
                                    <input type="text" name="bic" value="{{$company->bic}}" class="form-control" placeholder="{{trans_dynamic('company_bic')}}" aria-label="{{trans_dynamic('company_bic')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_stnr')}}:</label>
                                    <input type="text" name="stnr" value="{{$company->stnr}}" class="form-control" placeholder="{{trans_dynamic('company_stnr')}}" aria-label="{{trans_dynamic('company_stnr')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_ust_id_nr')}}:</label>
                                    <input type="text" name="ust_id_nr" value="{{$company->ust_id_nr}}" class="form-control" placeholder="{{trans_dynamic('company_ust_id_nr')}}" aria-label="{{trans_dynamic('company_ust_id_nr')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_registry_court')}}:</label>
                                    <input type="text" name="registry_court" value="{{$company->registry_court}}" class="form-control" placeholder="{{trans_dynamic('company_registry_court')}}" aria-label="{{trans_dynamic('company_registry_court')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_general_manager')}}:</label>
                                    <input type="text" name="general_manager" value="{{$company->general_manager}}" class="form-control" placeholder="{{trans_dynamic('company_general_manager')}}" aria-label="{{trans_dynamic('company_general_manager')}}">
                                </div>
                                {{-- Adres Bilgileri Başlangıç --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_street')}}:</label>
                                    <input type="text" name="street" value="{{ json_decode($company->address)->street  ?? '' }}" class="form-control" placeholder="{{trans_dynamic('company_street')}}" aria-label="{{trans_dynamic('company_street')}}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_zip_code')}}:</label>
                                    <input type="text" name="zip_code" value="{{ json_decode($company->address)->zip_code  ?? '' }}" class="form-control" placeholder="{{trans_dynamic('company_zip_code')}}" aria-label="{{trans_dynamic('company_zip_code')}}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_city')}}:</label>
                                    <input type="text" name="city" value="{{ json_decode($company->address)->city  ?? '' }}" class="form-control" placeholder="{{trans_dynamic('company_city')}}" aria-label="{{trans_dynamic('company_city')}}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_country')}}:</label>
                                    <input type="text" name="country" value="{{ json_decode($company->address)->country  ?? '' }}" class="form-control" placeholder="{{trans_dynamic('company_country')}}" aria-label="{{trans_dynamic('company_country')}}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">{{trans_dynamic('company_country')}}:</label>
                                    <select class="form-select" name="country" id="country">
                                        <option value="Deutschland" {{ json_decode($company->address)->country == 'Deutschland' ? 'selected' : '' }}>Deutschland</option>
                                        <option value="Niederlande" {{ json_decode($company->address)->country == 'Niederlande' ? 'selected' : '' }}>Niederlande</option>
                                        <option value="Österreich" {{ json_decode($company->address)->country == 'Österreich' ? 'selected' : '' }}>Österreich</option>
                                        <option value="Dänemark" {{ json_decode($company->address)->country == 'Dänemark' ? 'selected' : '' }}>Dänemark</option>
                                        <option value="Schweden" {{ json_decode($company->address)->country == 'Schweden' ? 'selected' : '' }}>Schweden</option>
                                        <option value="Frankreich" {{ json_decode($company->address)->country == 'Frankreich' ? 'selected' : '' }}>Frankreich</option>
                                        <option value="Belgien" {{ json_decode($company->address)->country == 'Belgien' ? 'selected' : '' }}>Belgien</option>
                                        <option value="Italien" {{ json_decode($company->address)->country == 'Italien' ? 'selected' : '' }}>Italien</option>
                                        <option value="Griechenland" {{ json_decode($company->address)->country == 'Griechenland' ? 'selected' : '' }}>Griechenland</option>
                                        <option value="Schweiz" {{ json_decode($company->address)->country == 'Schweiz' ? 'selected' : '' }}>Schweiz</option>
                                        <option value="Polen" {{ json_decode($company->address)->country == 'Polen' ? 'selected' : '' }}>Polen</option>
                                        <option value="Kroatien" {{ json_decode($company->address)->country == 'Kroatien' ? 'selected' : '' }}>Kroatien</option>
                                        <option value="Rumänien" {{ json_decode($company->address)->country == 'Rumänien' ? 'selected' : '' }}>Rumänien</option>
                                        <option value="Tschechien" {{ json_decode($company->address)->country == 'Tschechien' ? 'selected' : '' }}>Tschechien</option>
                                        <option value="Serbien" {{ json_decode($company->address)->country == 'Serbien' ? 'selected' : '' }}>Serbien</option>
                                        <option value="Ungarn" {{ json_decode($company->address)->country == 'Ungarn' ? 'selected' : '' }}>Ungarn</option>
                                        <option value="Bulgarien" {{ json_decode($company->address)->country == 'Bulgarien' ? 'selected' : '' }}>Bulgarien</option>
                                        <option value="Russland" {{ json_decode($company->address)->country == 'Russland' ? 'selected' : '' }}>Russland</option>
                                        <option value="Weißrussland" {{ json_decode($company->address)->country == 'Weißrussland' ? 'selected' : '' }}>Weißrussland</option>
                                        <option value="Türkei" {{ json_decode($company->address)->country == 'Türkei' ? 'selected' : '' }}>Türkei</option>
                                        <option value="Norwegen" {{ json_decode($company->address)->country == 'Norwegen' ? 'selected' : '' }}>Norwegen</option>
                                        <option value="England" {{ json_decode($company->address)->country == 'England' ? 'selected' : '' }}>England</option>
                                        <option value="Irland" {{ json_decode($company->address)->country == 'Irland' ? 'selected' : '' }}>Irland</option>
                                        <option value="Ukraine" {{ json_decode($company->address)->country == 'Ukraine' ? 'selected' : '' }}>Ukraine</option>
                                        <option value="Spanien" {{ json_decode($company->address)->country == 'Spanien' ? 'selected' : '' }}>Spanien</option>
                                        <option value="Slowenien" {{ json_decode($company->address)->country == 'Slowenien' ? 'selected' : '' }}>Slowenien</option>
                                        <option value="Slowakei" {{ json_decode($company->address)->country == 'Slowakei' ? 'selected' : '' }}>Slowakei</option>
                                        <option value="Portugal" {{ json_decode($company->address)->country == 'Portugal' ? 'selected' : '' }}>Portugal</option>
                                        <option value="Luxemburg" {{ json_decode($company->address)->country == 'Luxemburg' ? 'selected' : '' }}>Luxemburg</option>
                                        <option value="Liechtenstein" {{ json_decode($company->address)->country == 'Liechtenstein' ? 'selected' : '' }}>Liechtenstein</option>
                                        <option value="Litauen" {{ json_decode($company->address)->country == 'Litauen' ? 'selected' : '' }}>Litauen</option>
                                        <option value="Lettland" {{ json_decode($company->address)->country == 'Lettland' ? 'selected' : '' }}>Lettland</option>
                                        <option value="Kasachstan" {{ json_decode($company->address)->country == 'Kasachstan' ? 'selected' : '' }}>Kasachstan</option>
                                        <option value="Island" {{ json_decode($company->address)->country == 'Island' ? 'selected' : '' }}>Island</option>
                                        <option value="Estland" {{ json_decode($company->address)->country == 'Estland' ? 'selected' : '' }}>Estland</option>
                                        <option value="Finnland" {{ json_decode($company->address)->country == 'Finnland' ? 'selected' : '' }}>Finnland</option>
                                        <option value="Bosnien und Herzegowina" {{ json_decode($company->address)->country == 'Bosnien und Herzegowina' ? 'selected' : '' }}>Bosnien und Herzegowina</option>
                                    </select>
                                </div>
                                {{-- Adres Bilgileri Bitiş --}}
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">{{trans_dynamic('edit')}}</button>
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