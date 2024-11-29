@extends('layouts.layout')
@section('title', 'Kulanıcı Düzenle')
@section('content')
<div class="page-header-breadcrumb d-md-flex d-block align-items-center justify-content-between ">
    <h4 class="fw-medium mb-0">{{ trans_dynamic('user_edit') }}</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);" class="text-white-50">{{ trans_dynamic('users') }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{$user->name}}</li>
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
                            {{ trans_dynamic('user_edit') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ trans_dynamic('name') }}:</label>
                                    <input type="text" name="name" value="{{$user->name}}" class="form-control" placeholder="{{ trans_dynamic('name') }}" aria-label="{{ trans_dynamic('name') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ trans_dynamic('surname') }}:</label>
                                    <input type="text" name="surname" value="{{$user->surname}}" class="form-control" placeholder="{{ trans_dynamic('surname') }}" aria-label="{{ trans_dynamic('surname') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ trans_dynamic('phone') }}:</label>
                                    <input type="text" name="phone" value="{{$user->phone}}" class="form-control" placeholder="{{ trans_dynamic('phone') }}" aria-label="{{ trans_dynamic('phone') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ trans_dynamic('email') }}:</label>
                                    <input type="email" name="email" value="{{$user->email}}" class="form-control" placeholder="{{ trans_dynamic('email') }}" aria-label="{{ trans_dynamic('email') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="role">{{ trans_dynamic('user_type') }}:</label>
                                    <select name="role" id="role" class="form-select">
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ trans_dynamic('users') }} {{ trans_dynamic('company') }}:</label>
                                    <select name="company_id" id="inputCompany" class="form-select">
                                        @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ $user->company_id == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ trans_dynamic('country') }}:</label>
                                    <select class="form-select" name="country" id="country">
                                        <option value="Deutschland" {{ json_decode($user->address)->country == 'Deutschland' ? 'selected' : '' }}>Deutschland</option>
                                        <option value="Niederlande" {{ json_decode($user->address)->country == 'Niederlande' ? 'selected' : '' }}>Niederlande</option>
                                        <option value="Österreich" {{ json_decode($user->address)->country == 'Österreich' ? 'selected' : '' }}>Österreich</option>
                                        <option value="Dänemark" {{ json_decode($user->address)->country == 'Dänemark' ? 'selected' : '' }}>Dänemark</option>
                                        <option value="Schweden" {{ json_decode($user->address)->country == 'Schweden' ? 'selected' : '' }}>Schweden</option>
                                        <option value="Frankreich" {{ json_decode($user->address)->country == 'Frankreich' ? 'selected' : '' }}>Frankreich</option>
                                        <option value="Belgien" {{ json_decode($user->address)->country == 'Belgien' ? 'selected' : '' }}>Belgien</option>
                                        <option value="Italien" {{ json_decode($user->address)->country == 'Italien' ? 'selected' : '' }}>Italien</option>
                                        <option value="Griechenland" {{ json_decode($user->address)->country == 'Griechenland' ? 'selected' : '' }}>Griechenland</option>
                                        <option value="Schweiz" {{ json_decode($user->address)->country == 'Schweiz' ? 'selected' : '' }}>Schweiz</option>
                                        <option value="Polen" {{ json_decode($user->address)->country == 'Polen' ? 'selected' : '' }}>Polen</option>
                                        <option value="Kroatien" {{ json_decode($user->address)->country == 'Kroatien' ? 'selected' : '' }}>Kroatien</option>
                                        <option value="Rumänien" {{ json_decode($user->address)->country == 'Rumänien' ? 'selected' : '' }}>Rumänien</option>
                                        <option value="Tschechien" {{ json_decode($user->address)->country == 'Tschechien' ? 'selected' : '' }}>Tschechien</option>
                                        <option value="Serbien" {{ json_decode($user->address)->country == 'Serbien' ? 'selected' : '' }}>Serbien</option>
                                        <option value="Ungarn" {{ json_decode($user->address)->country == 'Ungarn' ? 'selected' : '' }}>Ungarn</option>
                                        <option value="Bulgarien" {{ json_decode($user->address)->country == 'Bulgarien' ? 'selected' : '' }}>Bulgarien</option>
                                        <option value="Russland" {{ json_decode($user->address)->country == 'Russland' ? 'selected' : '' }}>Russland</option>
                                        <option value="Weißrussland" {{ json_decode($user->address)->country == 'Weißrussland' ? 'selected' : '' }}>Weißrussland</option>
                                        <option value="Türkei" {{ json_decode($user->address)->country == 'Türkei' ? 'selected' : '' }}>Türkei</option>
                                        <option value="Norwegen" {{ json_decode($user->address)->country == 'Norwegen' ? 'selected' : '' }}>Norwegen</option>
                                        <option value="England" {{ json_decode($user->address)->country == 'England' ? 'selected' : '' }}>England</option>
                                        <option value="Irland" {{ json_decode($user->address)->country == 'Irland' ? 'selected' : '' }}>Irland</option>
                                        <option value="Ukraine" {{ json_decode($user->address)->country == 'Ukraine' ? 'selected' : '' }}>Ukraine</option>
                                        <option value="Spanien" {{ json_decode($user->address)->country == 'Spanien' ? 'selected' : '' }}>Spanien</option>
                                        <option value="Slowenien" {{ json_decode($user->address)->country == 'Slowenien' ? 'selected' : '' }}>Slowenien</option>
                                        <option value="Slowakei" {{ json_decode($user->address)->country == 'Slowakei' ? 'selected' : '' }}>Slowakei</option>
                                        <option value="Portugal" {{ json_decode($user->address)->country == 'Portugal' ? 'selected' : '' }}>Portugal</option>
                                        <option value="Luxemburg" {{ json_decode($user->address)->country == 'Luxemburg' ? 'selected' : '' }}>Luxemburg</option>
                                        <option value="Liechtenstein" {{ json_decode($user->address)->country == 'Liechtenstein' ? 'selected' : '' }}>Liechtenstein</option>
                                        <option value="Litauen" {{ json_decode($user->address)->country == 'Litauen' ? 'selected' : '' }}>Litauen</option>
                                        <option value="Lettland" {{ json_decode($user->address)->country == 'Lettland' ? 'selected' : '' }}>Lettland</option>
                                        <option value="Kasachstan" {{ json_decode($user->address)->country == 'Kasachstan' ? 'selected' : '' }}>Kasachstan</option>
                                        <option value="Island" {{ json_decode($user->address)->country == 'Island' ? 'selected' : '' }}>Island</option>
                                        <option value="Estland" {{ json_decode($user->address)->country == 'Estland' ? 'selected' : '' }}>Estland</option>
                                        <option value="Finnland" {{ json_decode($user->address)->country == 'Finnland' ? 'selected' : '' }}>Finnland</option>
                                        <option value="Bosnien und Herzegowina" {{ json_decode($user->address)->country == 'Bosnien und Herzegowina' ? 'selected' : '' }}>Bosnien und Herzegowina</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ trans_dynamic('city') }}:</label>
                                    <input type="text" name="city" value="{{ json_decode($user->address)->city  ?? '' }}" class="form-control" placeholder="{{ trans_dynamic('city') }}" aria-label="{{ trans_dynamic('city') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ trans_dynamic('street') }}:</label>
                                    <input type="text" name="street" value="{{ json_decode($user->address)->street  ?? '' }}" class="form-control" placeholder="{{ trans_dynamic('street') }}" aria-label="{{ trans_dynamic('street') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ trans_dynamic('zip_code') }}:</label>
                                    <input type="text" name="zip_code" value="{{ json_decode($user->address)->zip_code ?? '' }}" class="form-control" placeholder="{{ trans_dynamic('zip_code') }}" aria-label="{{ trans_dynamic('zip_code') }}">
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">{{ trans_dynamic('edit') }}</button>
                                </div>
                            </div>   
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-6 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            {{ trans_dynamic('user') }} {{ trans_dynamic('password') }} {{ trans_dynamic('edit') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.change-password',$user->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ trans_dynamic('password') }}:</label>
                                    <input type="password" name="new_password" class="form-control" placeholder="{{ trans_dynamic('password') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ trans_dynamic('password_confirm') }}:</label>
                                    <input type="password" name="new_password_confirmation" class="form-control" placeholder="{{ trans_dynamic('password_confirm') }}" required>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">{{ trans_dynamic('edit') }}</button>
                                </div>
                            </div>   
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection