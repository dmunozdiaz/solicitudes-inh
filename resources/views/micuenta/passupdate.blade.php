@extends('layout.app')

@section('styles')

<style>
    .mostrar-pass{
        cursor: pointer;
    }
</style>

@endsection

@section('content')

{!! NoCaptcha::renderJs() !!}

<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class=" container ">
            <!--begin::Profile Change Password-->
            <div class="d-flex flex-row">
                <!--begin::Aside-->
                @include('micuenta.menu')
                <!--end::Aside-->

                <!--begin::Content-->
                <div class="flex-row-fluid ml-lg-8">
                    <!--begin::Card-->
                    <div class="card card-custom">
                        <!--begin::Header-->
                        <div class="card-header py-3">
                            <div class="card-title align-items-start flex-column">
                                <h3 class="card-label font-weight-bolder text-dark">Cambiar Contraseña</h3>
                                <span class="text-muted font-weight-bold font-size-sm mt-1">Su contraseña actual ha caducado. Establezca una nueva contraseña para continuar.</span>
                            </div>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <!--end::Header-->

                        <!--begin::Form-->
                        <form id="form-cambiar" method="POST" action="{{ route('forcepasschange') }}">
                            @csrf
                            <div class="card-body">
                                @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                                @endif
                                <!--                                <div class="form-group row">
                                                                    <label class="col-xl-3 col-lg-3 col-form-label text-alert">Contrase&ntilde;a Actual</label>
                                                                    <div class="col-lg-9 col-xl-6">
                                
                                                                        <div class="input-group input-group-lg input-group-solid">
                                                                            <input id="curr-password" type="password" class="form-control @error('password') is-invalid @enderror form-control-lg form-control-solid mb-2" name="curr-password" autocomplete="new-password">
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text mostrar-pass">
                                                                                    <span class="svg-icon svg-icon-dark-50 svg-icon-2x">begin::Svg Icon | path:/svg/icons\General\Visible.svg<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                                        <title>Mostar/Ocultar Contraseña</title>
                                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                        <rect x="0" y="0" width="24" height="24"/>
                                                                                        <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                                                        <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="#000000" opacity="0.3"/>
                                                                                        </g>
                                                                                        </svg>end::Svg Icon</span>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                
                                                                        @error('curr-password')
                                                                        <span class="help-block text-danger">{{ $message }}</span>
                                                                        @enderror  
                                                                    </div>
                                                                </div>-->
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-alert">Nueva Contrase&ntilde;a</label>
                                    <div class="col-lg-9 col-xl-6">

                                        <div class="input-group input-group-lg input-group-solid">
                                            <input id="password" type="password" class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror" name="password">
                                                <div class="input-group-append">
                                                    <span class="input-group-text mostrar-pass">
                                                        <span class="svg-icon svg-icon-dark-50 svg-icon-2x"><!--begin::Svg Icon | path:/svg/icons\General\Visible.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <title>Mostar/Ocultar Contraseña</title>
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"/>
                                                                    <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                                    <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="#000000" opacity="0.3"/>
                                                                </g>
                                                            </svg><!--end::Svg Icon--></span>
                                                    </span>
                                                </div>
                                        </div>

                                        @error('password')
                                        <span class="help-block text-danger">{{ $message }}</span>
                                        @enderror  
                                        <div id="pass_validator" class="container">
                                            <br />
                                            <p>La contraseña debe contener:</p>
                                            <div class="container">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-alert">Confirmar Contrase&ntilde;a</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <div class="input-group input-group-lg input-group-solid">
                                            <input id="password-confirm"  type="password" class="form-control form-control-lg form-control-solid" name="password_confirmation">
                                                <div class="input-group-append">
                                                    <span class="input-group-text mostrar-pass">
                                                        <span class="svg-icon svg-icon-dark-50 svg-icon-2x"><!--begin::Svg Icon | path:/svg/icons\General\Visible.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <title>Mostar/Ocultar Contraseña</title>
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"/>
                                                                    <path d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                                    <path d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z" fill="#000000" opacity="0.3"/>
                                                                </g>
                                                            </svg><!--end::Svg Icon--></span>
                                                    </span>
                                                </div>
                                        </div>
                                        @error('password_confirmation')
                                        <span class="help-block text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <!--<button type="reset" class="btn btn-primary mr-2">Submit</button>-->
                                <button id="btn_submit" type="button" class="btn btn-success mr-2" disabled>Cambiar Contraseña</button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>

                </div>
                <!--end::Content-->
            </div>
            <!--end::Profile Change Password-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<input type="hidden" id='minnum' value="{{ config('app.pass_min_num') }}"/>
<input type="hidden" id='maxlen' value="{{ config('app.pass_long') }}"/>
@endsection

{{-- Scripts Section --}}
@section('scripts')
<script src = "/js/password-validation.js" defer ></script>
<script type="text/javascript">

var minlength = $("#maxlen").val();
var minNumber = $("#minnum").val();

$("#btn_submit").on('click', function () {
    $("#form-cambiar").submit();
});

$(document).ready(function () {
    var passwd = $('input[name ="password"]');
    passwd.passwordValidation({
        "minLength": minlength, //Minimum Length of password 
        "minNumber": minNumber, //Minimum number of digits characters in password
        "parent": $("#pass_validator"),
        "submit": $("#btn_submit")
    });



    $('.mostrar-pass').click(function () {

        var input = $(this).closest('.input-group').find('input');
        var icon = $(this).find('.svg-icon');

        if (input.attr('type') == 'password') {
            input.attr('type', 'text');
            icon.removeClass('svg-icon-dark-50');
            icon.addClass('svg-icon-dark');
        } else {
            input.attr('type', 'password');
            icon.addClass('svg-icon-dark-50');
            icon.removeClass('svg-icon-dark');
        }
    });
});

</script>

@endsection