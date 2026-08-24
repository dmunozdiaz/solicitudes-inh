{{--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4 & Angular 8
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
 --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{ Metronic::printAttrs('html') }}
    {{ Metronic::printClasses('html') }}>

<head>
    <meta charset="utf-8" />

    {{-- Title Section --}}
    <title>{{ config('app.name') }} | @yield('title', $page_title ?? '')</title>

    {{-- Meta Data --}}
    <meta name="description" content="@yield('page_description', $page_description ?? '')" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('media/logos/logoUAutonoma.png') }}" />

    {{-- Fonts --}}
    {{ Metronic::getGoogleFontsInclude() }}
    <link href="{{ asset('css/pages/login/login-1.css') }}" rel="stylesheet" type="text/css" />

    {{-- Global Theme Styles (used by all pages) --}}
    @foreach(config('layout.resources.css') as $style)
    <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($style)) : asset($style) }}" rel="stylesheet"
        type="text/css" />
    @endforeach

    {{-- Layout Themes (used by all pages) --}}
    @foreach (Metronic::initThemes() as $theme)
    <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($theme)) : asset($theme) }}" rel="stylesheet"
        type="text/css" />
    @endforeach

    {{-- Includable CSS --}}
    @yield('styles')
</head>

<body {{ Metronic::printAttrs('body') }} {{ Metronic::printClasses('body') }}>

    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white"
            id="kt_login">
            <div class="login-aside d-flex flex-column flex-row-auto"
                style="background: linear-gradient(to bottom, #02c8e2 0%, #02c8e2 15%, #8a56f6 60%, #8a56f6 100%);">
                <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                    <a href="#" class="text-center mb-10"><img src="{{asset('media/logos/logoUAutonoma.png')}}"
                            class="max-h-150px" alt=""></a>

                    <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg" style="color: #FFF;">
                        Servicio Nacional de la Mujer<br>y la Equidad de Género</h3>
                </div>

                <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center"
                    style="background-image: url({{asset('media/custom/emprendedoras.png')}}); background-size: contain;">
                </div>
            </div>

            <div
                class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
                <div class="d-flex flex-column-fluid flex-center">
                    <div class="login-form login-signin">
                        <div class="card card-custom">

                            <div class="d-flex flex-column-fluid flex-center">
                                <!--begin::Signin-->
                                <div class="login-form login-signin">
                                    @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                    @endif
                                    <!--begin::Form-->
                                    <form method="POST" action="{{ route('password.update') }}">
                                        @csrf

                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <input id="email" type="hidden"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ $email ?? old('email') }}" required autocomplete="email"
                                            autofocus>

                                        <!--begin::Title-->
                                        <div class="pb-13 pt-lg-0 pt-5">
                                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">
                                                Restablecer contrase&ntilde;a</h3>
                                            <span class="text-muted font-weight-bold font-size-h4">Ingrese una nueva
                                                contrase&ntilde;a y conf&iacute;rmela ingres&aacute;ndola por segunda
                                                vez.</span>
                                        </div>
                                        <!--begin::Title-->
                                        <!--begin::Form group-->
                                        <div class="form-group">
                                            <div class="input-group input-group-lg input-group-solid">
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="new-password"
                                                    placeholder="Nueva Contrase&ntilde;a">
                                                <div class="input-group-append">
                                                    <span class="input-group-text mostrar-pass">
                                                        <span class="svg-icon svg-icon-dark-50 svg-icon-2x">
                                                            <!--begin::Svg Icon | path:/svg/icons\General\Visible.svg--><svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <title>Mostar/Ocultar Contraseña</title>
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24" />
                                                                    <path
                                                                        d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z"
                                                                        fill="#000000" fill-rule="nonzero"
                                                                        opacity="0.3" />
                                                                    <path
                                                                        d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z"
                                                                        fill="#000000" opacity="0.3" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon--></span>
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
                                                <input id="password-confirm" type="password" class="form-control"
                                                    name="password_confirmation" required autocomplete="new-password"
                                                    placeholder="Repetir la Nueva Contrase&ntilde;a">
                                                <div class="input-group-append">
                                                    <span class="input-group-text mostrar-pass">
                                                        <span class="svg-icon svg-icon-dark-50 svg-icon-2x">
                                                            <!--begin::Svg Icon | path:/svg/icons\General\Visible.svg--><svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <title>Mostar/Ocultar Contraseña</title>
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24" />
                                                                    <path
                                                                        d="M3,12 C3,12 5.45454545,6 12,6 C16.9090909,6 21,12 21,12 C21,12 16.9090909,18 12,18 C5.45454545,18 3,12 3,12 Z"
                                                                        fill="#000000" fill-rule="nonzero"
                                                                        opacity="0.3" />
                                                                    <path
                                                                        d="M12,15 C10.3431458,15 9,13.6568542 9,12 C9,10.3431458 10.3431458,9 12,9 C13.6568542,9 15,10.3431458 15,12 C15,13.6568542 13.6568542,15 12,15 Z"
                                                                        fill="#000000" opacity="0.3" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon--></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Form group-->
                                        <!--begin::Action-->
                                        <div class="pb-lg-0 pb-5">
                                            <button id="btn_submit" type="submit"
                                                class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3 float-right"
                                                disabled="">Cambiar Contraseña</button>
                                        </div>
                                        <!--end::Action-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Signin-->

                            </div>
                        </div>

                        <input type="hidden" id='minnum' value="{{ config('app.pass_min_num') }}" />
                        <input type="hidden" id='maxlen' value="{{ config('app.pass_long') }}" />
                       

                        @section('scripts')

                        <script src="/js/password-validation.js" defer></script>
                        <script type="text/javascript">
                            var minlength = $("#maxlen").val();
                    var minNumber = $("#minnum").val();
                    
                    $(document).ready(function () {
                        var passwd = $('input[name ="password"]');
                        passwd.passwordValidation({
                            "minLength": minlength, //Minimum Length of password 
                            "minNumber": minNumber, //Minimum number of digits characters in password
                            "parent": $("#pass_validator")
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
                    </div>
                </div>

                <div class="d-flex justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0"></div>
            </div>
        </div>
    </div>

    {{-- Global Config (global config for global JS scripts) --}}
    <script>
        var KTAppSettings = {!! json_encode(config('layout.js'), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!};
    </script>

    <script src="{{ asset("js/login.js") }}"></script>

    {{-- Global Theme JS Bundle (used by all pages)  --}}
    @foreach(config('layout.resources.js') as $script)
    <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach

    {{-- Includable JS --}}
    @yield('scripts')

</body>

</html>