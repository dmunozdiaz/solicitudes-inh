{{-- Extends layout --}}
@extends('layout.app')

{{-- Content --}}
@section('content')

<div class="alert alert-custom alert-light-{{$type}} fade show mb-5" role="alert">
    <div class="alert-icon"><i class="{{$icon}}"></i></div>
    <div class="alert-text">{{$msg}}</div>
    <div class="alert-close">
        
    </div>
</div>



@endsection

@section('css')
    <link href="{{ asset('css/pages/error/error-3.css') }}" rel="stylesheet" type="text/css" />
@endsection