@extends('layouts.app')
@section('title', 'Register')
@section('content')
@php
    if (!Auth::check()) {
        header('Location: ' . route('login'));
        exit();
    } else {
        header('Location: ' . route('e'));
        exit();
    }
@endphp
@endsection
