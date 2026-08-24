@extends('layout.exterior')

@section('content')

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form id="frm-forgot-password" method="POST" action="{{ route('password.update.custom') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <input type="hidden" name="email" value="{{ $request->email }}">


        <!--begin::Title-->
        <div class="pb-13 pt-lg-0 pt-5">
            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Restablecer
                contrase&ntilde;a</h3>
            <span class="text-muted font-weight-bold font-size-h4">Ingrese una nueva
                contrase&ntilde;a y conf&iacute;rmela ingres&aacute;ndola por segunda
                vez.</span>
        </div>

        <div id="error-catpcha" class="alert alert-danger hiden">

            Debe ingresar el Catpcha.
        </div>

        <!--begin::Title-->
        <!--begin::Form group-->
        <div class="form-group">
            <div class="input-group input-group-lg input-group-solid">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password" placeholder="Nueva Contrase&ntilde;a"
                    :value="old('email', $request->email)">
                <div class="input-group-append">
                    <span class="input-group-text mostrar-pass">
                        <span class="svg-icon svg-icon-dark-50 svg-icon-2x">
                            <!--begin::Svg Icon | path:/svg/icons\General\Visible.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                height="24px" viewBox="0 0 24 24" version="1.1">
                                <title>Mostar/Ocultar Contraseña</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z"
                                        fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                    <path
                                        d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
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
        <!--end::Form group-->
        <!--begin::Form group-->
        <div class="form-group">
            <div class="input-group input-group-lg input-group-solid">
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"
                    required autocomplete="new-password" placeholder="Repetir la Nueva Contrase&ntilde;a">
                <div class="input-group-append">
                    <span class="input-group-text mostrar-pass">
                        <span class="svg-icon svg-icon-dark-50 svg-icon-2x">
                            <!--begin::Svg Icon | path:/svg/icons\General\Visible.svg--><svg
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                height="24px" viewBox="0 0 24 24" version="1.1">
                                <title>Mostar/Ocultar Contraseña</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path
                                        d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z"
                                        fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                    <path
                                        d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z"
                                        fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
            <label class="col-md-4 control-label"></label>
            <div class="col-md-12">
                <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}" data-callback="enableBtn"></div>
                @if ($errors->has('g-recaptcha-response'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <!--end::Form group-->
        <!--begin::Action-->
        <div class="pb-lg-0 pb-5">
            <button id="btn_submit" type="submit"
                class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3 float-right" disabled="">Cambiar
                Contraseña</button>
        </div>
        <!--end::Action-->
    </form>

    <input type="hidden" id='minnum' value="{{ config('app.pass_min_num') }}" />
    <input type="hidden" id='maxlen' value="{{ config('app.pass_long') }}" />
@endsection

@section('scripts')

    <script>
        function enableBtn() {
            document.getElementById("btn_submit").disabled = false;
        }
    </script>

    <script src="/js/password-validation.js" defer></script>
    <script src="{{ asset('js/login/reset-password.js') }}"></script>
@endsection
