{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

<div class=" container ">
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Cuentas Registradas <small>Fondos concursables</small></h3>
            </div>
        </div>
        <div class="card-body">
        <p>Estimado/a {{ Auth::user()->name }} {{ Auth::user()->lastname }}:<br>
            @if (count($cuentas) == 0)
                <div class="alert alert-custom alert-light-danger fade show mb-5" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">Usted no tiene ninguna cuenta de usuario del Sistema de Postulaci&oacute;n a Fondo
                        FNDR 6% asociada a su RUT. Si lo requiere puede crear una nueva cuenta en la
                        opci&oacute;n disponible en esta pantalla, o bien, ingresar al sistema con su cuenta GORE
                        6% FNDR, y vincular su cuenta existente a su RUT en el formulario disponible para
                        dicho prop&oacute;sito.</div>
                    <div class="alert-close">
                        
                    </div>
                </div>
            @else
                Para acceder al Sistema de Postulación a Fondo FNDR 6%, usted debe seleccionar alguna de las cuentas registradas a su RUT.</p>
                <!--begin: Datatable-->
                <table class="table table-bordered table-checkable dataTable no-footer" id="kt_datatable">
                    <thead>
                        <tr>
                            <th class="dt-left">ID</th>
                            <th>Correo</th>
                            <th>Rut</th>
                            <th>Nombre</th>
                            <th>Tipo Institución</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cuentas as $cuenta)
                        <tr>
                            <td class=" dt-left">
                                {{$loop->iteration}}
                            </td>
                            <td>{{$cuenta->email_cuenta}}</td>
                            <td>{{$cuenta->rut}}</td>
                            <td>{{$cuenta->nombre}}</td>
                            <td>{{$cuenta->tipinstitucion}}</td>
                            <td><a href="login-fndr/{{$cuenta->id}}">Ingresar</a></td>
                        </tr>
                    
                    @endforeach
                    </tbody>
                </table>
                <!--end: Datatable-->
            @endif
                   
            <br>
            <p>Si usted desea postular proyectos para una nueva institución (sin fines de lucro o pública) puede registrar una nueva cuenta.</p>
            <div class="col text-center">
                <a href="crear-cuenta" class="btn btn-primary ">Registrar una nueva cuenta</a>
            </div>
        </div>
    </div>
    <!--end::Card-->
</div>

@endsection

{{-- Scripts Section --}}
@section('scripts')

<script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>

@endsection