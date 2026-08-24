@extends('layout.exterior')





@section('content')

<form class="form fv-plugins-bootstrap fv-plugins-framework" novalidate="novalidate" id="kt_login_signin_form" method="post" action="{{ url("login") }}">
    @csrf
    <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
      <!--  <a href="#" class="text-center mb-10"><img src="{{asset('media/logos/logoUAutonoma.png')}}" class="max-h-150px" alt=""></a>-->
    </div>
    <div class="pb-13 pt-lg-0 pt-5">
        <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Solicitudes Municipalidad de Temuco</h3>
    </div>

    @include('defaults.flash-message')

    <div class="form-group fv-plugins-icon-container">
        <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="text" name="email" autocomplete="off" placeholder="Ingrese su Email" >
        <div class="fv-plugins-message-container"> @error('email')
            <span class="help-block text-danger">{{ $message }}</span>
            @enderror</div>
    </div>

    <div class="form-group fv-plugins-icon-container">
        <div class="d-flex justify-content-between mt-n5">
            <label class="font-size-h6 font-weight-bolder text-dark pt-5">Contraseña</label>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot">
                ¿Olvidó su contraseña?
            </a>
            @endif
        </div>

        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" placeholder="Ingrese su Contraseña" name="password" autocomplete="off">
        <div class="fv-plugins-message-container"> @error('password')
            <span class="help-block text-danger">{{ $message }}</span>
            @enderror</div>
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

    <div class="pb-lg-0 pb-5">
        <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Ingresar</button>
    </div>

    <div></div>

    <a class="btn-cu btn-l  btn-color-estandar" href="{{ url('auth/claveunica') }}" title="Este es el botón Iniciar sesión de ClaveÚnica">
        <span class="cl-claveunica"></span>
        <span class="texto">Iniciar sesión con clave unica</span>
    </a>
</form>
@endsection

