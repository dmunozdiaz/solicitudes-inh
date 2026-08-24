{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

{{-- Dashboard 1 --}}

<div class="row">
    <form id="login-fndr" action="{{ $url_post}}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="token" id="token" value="{{$token}}">
        <input type="hidden" name="login_fndr" id="login_fndr" value="login_app_fndr">
    </form>
</div>


@endsection

{{-- Scripts Section --}}
@section('scripts')
<script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/pages/login-fndr.js') }}" type="text/javascript"></script>

@endsection