@extends('layout.app')

@section('styles')
    <link href="{{ asset("plugins/custom/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("css/pretty-checkbox.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("css/custom.css") }}" rel="stylesheet" type="text/css">
@endsection

@section('subheader_2')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="text-muted">Inicio</a>
        </li>

        <li class="breadcrumb-item">
            <a href="" class="text-muted">Gestión de Tareas</a>
        </li>

        <li class="breadcrumb-item">
            <a href="" class="text-muted">Reportes</a>
        </li>
    </ul>
@endsection

@section('content')

    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">
                    Reportes de Trámites
                    <span class="d-block text-muted pt-2 font-size-sm"></span>
                </h3>
            </div>
        </div>

        <div class="card-body">

            <form method="POST">
                <div class="form-group row fv-plugins-icon-container">
                    <label class="col-lg-3 col-sm-12 col-form-label text-right"><strong>Año:</strong></label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <select class="form-control" name="anio" id="anio">
                            <option value="">Todos</option>
                            @foreach ($allAnios as $anio)
                                <option value="{{ $anio['desc'] }}">{{ $anio['desc'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row fv-plugins-icon-container">
                    <label class="col-lg-3 col-sm-12 col-form-label text-right"><strong>Tipo de documento:</strong></label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <select class="form-control" name="tipotramite" id="tipotramite">
                            <option value="">Todos</option>
                            @foreach ($allPmTipoTramite as $tramite)
                                <option value="{{ $tramite.VALUE }}">{{ $tramite.VALUE }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row fv-plugins-icon-container">
                    <label class="col-lg-3 col-sm-12 col-form-label text-right"><strong>Procedencia:</strong></label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <select class="form-control" name="procedencia" id="procedencia">
                            <option value="">Todos</option>
                            @foreach ($allPmProcedencia as $procedencia)
                                <option value="{{ $procedencia['VALUE'] }}">{{ $procedencia['VALUE'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row fv-plugins-icon-container">
                    <label class="col-lg-3 col-sm-12 col-form-label text-right"><strong>Responsable:</strong></label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <select class="form-control" name="responsable" id="responsable">
                            <option value="">Todos</option>
                            @foreach ($allPmUsers as $user)
                                <option value="{{ $user['usr_uid'] }}">{{ $user['usr_firstname'] }} {{ user['usr_lastname'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row fv-plugins-icon-container">
                    <label class="col-lg-3 col-sm-12 col-form-label text-right"><strong>Estado:</strong></label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <select class="form-control" name="estado" id="estado">
                            <option value="">Todos</option>
                            @foreach ($allPmTask as $task)
                                <option value="{{ $task['TAS_UID'] }}">{{ $task['TAS_TITLE'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row fv-plugins-icon-container">
                    <label class="col-lg-3 col-sm-12">&nbsp;</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <button type="button" class="btn btn-primary" id="excel_generico">
                            <span>
                                <span>XLS Génerico</span>
                            </span>
                        </button>
                    </div>
                </div>
            
            </form>

        </div>
    </div>


@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset("plugins/custom/datatables/datatables.bundle.js" )}}"></script>
    <script type="text/javascript" src="{{ asset("js/tareas/bandejas.js") }}"></script>
@endsection