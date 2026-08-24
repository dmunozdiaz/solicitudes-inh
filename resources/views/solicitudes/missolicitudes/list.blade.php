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
            <a href="" class="text-muted">Mis solicitudes</a>
        </li>
    </ul>
@endsection

@section('content')

<div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">
                    Mis Solicitudes
                    <span class="d-block text-muted pt-2 font-size-sm"></span>
                </h3>
            </div>
        </div>

        <div class="card-body">

            <ul class="nav nav-tabs nav-tabs-line">

                @foreach ($tabs as $tab)
                    <li class="nav-item">
                        <a class="nav-link @if($tab['active'] == 1) active show @endif" href="#{{ $tab['tab-id'] }}" data-url="{{ $tab['url'] }}" data-toggle="tab" id="tab-{{ $tab['tab-id'] }}">                        
                            @if( isset($tab['icon']) )
                                <i class="la {{ $tab['icon'] }}"></i>
                                <span class="nav-text">{{ $tab['title'] }}</span>
                            @else
                                {{ $tab['title'] }}
                            @endif
                        </a>
                    </li>

                    @if($tab['active'] == 1)
                        <input type="hidden" value="{{ $tab['tab-id'] }}" id="idtabselect">
                        <input type="hidden" value="{{ $tab['url'] }}" id="urltabselect">
                    @endif
                @endforeach

            </ul>

            <div class="tab-content mt-5" id="myTabContent">
                @foreach ($tabs as $tab)
            
                    <div class="tab-pane fade @if($tab['active'] == 1) active show @endif" id="{{ $tab['tab-id'] }}" url="{{ $tab['url'] }}" section="{{ $tab['contentSection'] }}" role="tabpanel" aria-labelledby="kt_tab_pane_2">
                        <div class="accordion accordion-toggle-arrow" id="filtros-recibidas">
                            
                            <div class="row">
                                <div class="col-lg-12 text-left">

                                    <a href="#" class="btn btn-light-primary font-weight-bold" id="{{ $tab['tab-id'] }}-pm-typo3-new-case-btn" data-toggle="modal"
                                        data-target="#pm_formsolicitudes" data-backdrop="static" data-title="{{ $tab['title'] }}" data-subtitle="Nueva Solicitud"
                                        data-url="{{ $tab['newCaseUri'] }}" data-section=".tx-lz-pm-missolicitudes">
                                        <span>
                                        <i class="la la-plus"></i>
                                        <span>Nueva solicitud de documento</span>
                                        </span>
                                    </a>

                                </div>
                            </div>

                            <br>
                            
                            <div class="card">
                                <div class="card-header" style="border-radius: calc(0.85rem - 1px) calc(0.85rem - 1px) calc(0.85rem - 1px) calc(0.85rem - 1px);">
                                    <div class="card-title" data-toggle="collapse" data-target="#collapse-filtros-recibidas">
                                        Filtros
                                    </div>
                                </div>

                                <div id="collapse-filtros-recibidas" class="collapse" data-parent="#filtros-recibidas">

                                    <div class="card-body">

                                        <div class="form-group row fv-plugins-icon-container">

                                            <div class="col-md-3">
                                                <label><strong>Nº Solicitud:</strong></label>
                                                <input type="text" class="form-control" name="{{ $tab['tab-id'] }}_numero" id="{{ $tab['tab-id'] }}_numero">
                                            </div>

                                            <div class="col-md-3">
                                                <label><strong>Tipo de Documento:</strong></label>
                                                <select class="form-control custom-select" name="{{ $tab['tab-id'] }}_procedencia" id="{{ $tab['tab-id'] }}_procedencia">
                                                    <option value="">Todos</option>
                                                    @foreach ($allPmProcedencia as $procedencia)
                                                        <option value="{{ $procedencia->VALUE }}">{{ $procedencia->VALUE }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label><strong>F. Documento Desde:</strong></label>
                                                <input type="text" class="form-control" name="ejecutada_fdocumento_desde" id="ejecutada_fdocumento_desde">
                                            </div>

                                            <div class="col-md-3">
                                                <label><strong>F. Documento Hasta:</strong></label>
                                                <input type="text" class="form-control" name="ejecutada_fdocumento_hasta" id="ejecutada_fdocumento_hasta">
                                            </div>

                                        </div>

                                        <div class="form-group row fv-plugins-icon-container">

                                            <div class="col-md-3">
                                                <label><strong>Materia:</strong></label>
                                                <input type="text" class="form-control" name="{{ $tab['tab-id'] }}_referencia" id="{{ $tab['tab-id'] }}_referencia">
                                            </div>

                                            <div class="col-md-3">
                                                <label><strong>Vinculada a:</strong></label>
                                                <input type="text" class="form-control" name="{{ $tab['tab-id'] }}_propietario" id="{{ $tab['tab-id'] }}_propietario">
                                            </div>

                                            <div class="col-md-3">
                                                <label><strong>Remitente:</strong></label>
                                                <input type="text" class="form-control" name="{{ $tab['tab-id'] }}_propietario" id="{{ $tab['tab-id'] }}_propietario">
                                            </div>

                                            <div class="col-md-3">
                                                <label><strong>Destinatarios:</strong></label>
                                                <input type="text" class="form-control" name="{{ $tab['tab-id'] }}_propietario" id="{{ $tab['tab-id'] }}_propietario">
                                            </div>

                                        </div>

                                    </div>

                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-primary btn-primary--icon" id="filtar_{{ $tab['tab-id'] }}">
                                                    <span>
                                                        <i class="la la-search"></i>
                                                        <span>Filtrar</span>
                                                    </span>
                                                </button>

                                                &nbsp;&nbsp;

                                                <button class="btn btn-secondary btn-secondary--icon" id="limpiar_filtros">
                                                    <span>
                                                        <i class="la la-close"></i>
                                                        <span>Limpiar</span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                            
                                </div>
                            </div>
                        </div>
                            
                        <br><br>

                        <div class="card">
                            <div class="card-body">
                                <table class="table table-sm table-bordered table-hover" id="tabla_solicitudes">
                                    <thead class="thead-light">
                                        <tr class="text-center">
                                            <th>N°</th>
                                            <th>Tipo/Fecha Documento</th>
                                            <th>Materia</th>
                                            <th>Destinatarios</th>
                                            <th>Vinculada a</th>
                                            <th>Usuario Actual</th>
                                            <th>Última Modificación</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                </table>

                                <input type="hidden" value="{{ $tab['tab-id'] }}" id="idtabselect">
                                <input type="hidden" value="{{ $tab['url'] }}" id="urltabselect">
                            
                            </div>
                        </div>
                    </div>


                        <!--Inicio Modal Nueva Solicitud-->
                        <div class="modal fade" id="pm_solicitud" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="text-left">
                                            {{ $tab['title'] }} - Nueva Solicitud
                                        </h5>

                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>

                                    <div class="modal-body">

                                        <!--Iframe formulario PM-->
                                        
                                    </div>

                                    <div class="modal-footer text-center">
                                        <div class="row">
                                            <div class="col-lg-12 text-right">
                                                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"><i class="fa fa-times"></i>Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Fin Modal Nueva Solicitud-->

                        <!--Inicio Modal-->
                        <div class="modal fade" id="pm_formsolicitudes" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="text-left" id="titleModal">
                                            Tarea N° XXX - Estado
                                            <small>Nombre Proceso</small>
                                        </h5>

                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>

                                    <div class="modal-body" id="bandejaModalContent">
                                        
                                    </div>
                                    
                                    <div class="modal-footer text-center">
                                        <div class="row">
                                            <div class="col-lg-12 text-right">
                                                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"><i class="fa fa-times"></i>Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Fin Modal-->


               
                @endforeach
            </div>

        </div>
</div>

<input type="button" id="refresh-table" style="display:none">

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset("plugins/custom/datatables/datatables.bundle.js" )}}"></script>
    <script type="text/javascript" src="{{ asset("js/tareas/solicitudes.js") }}"></script>
@endsection