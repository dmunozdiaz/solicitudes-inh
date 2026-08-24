@extends('layout.app')

@section('styles')
    <link href="{{ asset("plugins/custom/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("css/pretty-checkbox.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custom.css?v=') }}<?php echo(rand()); ?>" rel="stylesheet" type="text/css">
@endsection

@section('subheader_2')

<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
  <!--begin::Page title-->
  <div class="page-title d-flex flex-column me-3">
    <!--begin::Title-->
    <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Reporte General</h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->

    <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
      <!--begin::Item-->
      <li class="breadcrumb-item text-gray-600">
        <a href="javascrip:;" class="text-gray-600 text-hover-primary">Inicio</a>
      </li>
      <li class="breadcrumb-item text-gray-600">
        <a href="javascrip:;" class="text-gray-600 text-hover-primary">Reportes</a>
      </li>
      <!--end::Item-->
      <!--begin::Item-->
      <li class="breadcrumb-item text-gray-500">Reporte General</li>
      <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
  </div>
  <!--end::Page title-->
</div>


@endsection

@section('content')
<div class="content flex-row-fluid" id="kt_content">
  <!--begin::Row-->
  <div class="row gy-5 g-xl-10 pt-5">
    <!--begin::Col-->
    <div class="col-xl-12 mb-12 mb-xl-12">
     
      <!--begin::Engage widget 3-->
      <div class="card shadow-sm card-flush mb-12">
        <!--begin::Header-->
        <div class="card-header">
          <h3 class="card-title">Reporte de Solicitudes Ciudadanas</h3>
          <div class="card-toolbar"></div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body d-flex flex-column pt-0 pb-0">
          <!--begin::Tabs-->
          <ul class="nav row mb-10">
           
          
          </ul>
          <!--end::Tabs-->
          <!--begin::Tab content-->
          <div class="tab-content">
            
            
           
            <!--Inicio supervisor-->
          
            <div class="tab-pane fade active show" id="kt_general_tab_supervisor">
              <!--begin::Texto ayuda-->
              <div class="card bg-body mb-10">
                <!--begin::Body-->
                <div class="card-body">
                  <div class="fs-5 text-gray-600">
                    <!--begin::Text-->
                    <p>En esta sección podrá descargar reportes en formato XLSX de todas las solicitudes que ha recibido el Municipio, donde se incluirá la información de cada solicitud y el estado en el que se encuentra.
                      <br>
                      Para generar un reporte, seleccione los parámetros que requiera, y posteriormente haga clic en el botón “Generar Reporte”. También podrá descargar en forma inmediata alguno de los últimos reportes generados, desplegando la sección “Últimos reportes generados”, en la parte inferior de esta pantalla.
                    </p>
                    <!--end::Text-->
                  </div>
                </div>
                <!--end::Body-->
              </div>
              <!--end::Texto ayuda-->
              <!--begin::Filtros Supervisor-->
              <!--begin::Accordion-->
              <div class="accordion mb-10" id="filtros-supervisor">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="filtros-supervisor_header_1">
                    <button class="accordion-button fs-4 fw-bold " type="button" data-bs-toggle="collapse" data-bs-target="#filtros-supervisor_body_1" aria-expanded="false" aria-controls="filtros-supervisor_body_1">
                        Parámetros
                    </button>
                  </h2>
                  <div id="filtros-supervisor_body_1" class="accordion-collapse collapse show" aria-labelledby="filtros-supervisor_header_1" data-bs-parent="#filtros-supervisor">
                    <div class="accordion-body">
                      <div class="card-body">
                        <div class="form-group row fv-plugins-icon-container">
                            <div class="col-md-6">
                              <label ><strong>Dirección:</strong></label>
                              <select class="form-control custom-select" name="direccion" id="direccion">
                                <option value="">Todas</option>
                                @foreach ($direcciones as $direccion)
                                <option value="{{ $direccion->direccion }}">{{ $direccion->direccion }}</option>
                                @endforeach
                              </select>
                              <div class="fv-plugins-message-container" id="direccion_alert"></div>
                            </div>
                            <div class="col-md-6">
                              <label ><strong>Área/Depto.:</strong></label>
                              <select class="form-control custom-select" name="area" id="area">
                                <option value="">Todas</option>
                                @foreach ($areas as $area)
                                <option value="{{ $area->area }}">{{ $area->area }}</option>
                                @endforeach
                              </select>
                              <div class="fv-plugins-message-container" id="area_alert"></div>
                            </div>
                            
                          </div>

                        <div class="form-group row fv-plugins-icon-container">
                         
                          <div class="col-md-4">
                            <label><strong>Tipo Solicitud:</strong></label>
                            <select class="form-control custom-select" name="proceso" id="proceso">
                              <option value="">Todas</option>
                              @foreach ($allPmProcess as $process)
                              <option value="{{ $process->prj_uid }}">{{ $process->prj_name }}</option>
                              @endforeach
                            </select>
                            <div class="fv-plugins-message-container" id="proceso_alert"></div>
                          </div>
                          <div class="col-md-4">
                            <label ><strong>Año:</strong></label>
                            <select class="form-control" id="anio" name="anio">
                              <option value="">Todos</option>
                             @for ($i = 2022; $i <= date('Y'); $i++)
                             <option value="{{ $i }}">{{ $i }}</option>
                             @endfor
                              
                             
                            </select>  
                            <div class="fv-plugins-message-container" id="anio_alert"></div>
                          </div>
                          <div class="col-md-4" id="div_estado">
                            <label><strong>Estado:</strong></label>
                            <select class="form-control" id="estado" name="estado">
                              <option value="">Seleccione un Estado</option>
                              <option value="1">Ingresada</option>
                              <option value="2">En proceso</option>
                              <option value="3">Finalizada</option>
                            </select>  
                            <div class="fv-plugins-message-container" id="estado_alert"></div>
                          </div>
                         
                        </div> 
                        
                        
                       
                      </div>
                        <!--begin::Footer-->
                        <div class="card-footer">
                          <div class="row">
                            <div class="col-md-12">
                              <button type="button" class="btn btn-primary btn-primary--icon" id="generar_reporte">
                                <span>
                                    <i class="icon-xl la la-file-excel"></i>
                                  <span>Generar Reporte</span>
                                </span>
                              </button>
                              &nbsp;&nbsp;
                              <button class="btn btn-secondary btn-secondary--icon" id="limpiar">
                                <span>
                                  <i class="la la-close"></i>
                                  <span>Limpiar</span>
                                </span>
                              </button>
                            </div>
                          </div>
                        </div>
                        <!--end::Footer-->
                    </div>
                  </div>
                </div>
              </div>
              <!--end::Accordion-->
              <!--end::Filtros Supervisor-->
              <!--begin::Tables Widget 1-->
              <div class="card bg-body">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                  <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Últimos reportes generados</span>
                  </h3>
                  <div class="card-toolbar">
                  </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                  <!--begin::Table container-->
                  <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-striped table-hover border rounded gy-5 gs-7" id="tabla_reporte">
                      <thead>
                        <tr class="fw-bold fs-6 text-gray-800 text-center">
                          <th>Nº</th>
                          <th>Dirección</th>
                          <th>Área/Depto.</th>
                          <th>Tipo Solicitud</th>
                          <th>Año</th>
                          <th>Estado</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                    </table>
                    <!--end::Table-->
                  </div>
                  <!--end::Table container-->
                </div>
                <!--end::Body-->
              </div>
              <!--endW::Tables Widget 1-->
            </div>
            
            <!--Fin supervisor-->
          </div>
          <!--end::Tab content-->
         

            
        </div>
        <!--end::Body-->
        <!--begin::Footer-->
        <div class="card-footer pt-0">
            
        </div>
        <!--begin::Footer-->    
        </div>
        <!--end::Engage widget 3-->

       
    </div>
    <!--end::Col-->
</div>
</div>
   

    <!--Inicio Modal-->
   
    <div id="pm_form" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="min-height: 590px;">
                <div class="modal-header py-5">
                    <h5 class="modal-title"  id="titleModal"> Tarea N° XXX - Estado 
                    </h5>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                      <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                      <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                          <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                        </svg>
                      </span>
                      <!--end::Svg Icon-->
                    </div>
                </div>
                <div class="modal-body" id="bandejaModalContent">
                   
                </div>
                <!--begin::Actions-->
                <div class="form-group mb-8 text-center">
                    
                    <input type="button" id="tomar_solicitud" class="btn btn-primary" value="Tomar Solicitud" style="display: none;">
                    <input type="hidden" value="" id="appuid" name="appuid"> 
                    <input type="hidden" value="" id="urliframe" name="urliframe">   
                    
                </div>
                <!--end::Actions-->
            </div>
        </div>
    </div>


   
    <!--Fin Modal-->

    <input type="button" id="refresh-table" style="display:none">
    <input type="button" id="refresh-table-ejecutadas" style="display:none">
    <input type="button" id="refresh-table-supervisor" style="display:none">
    <input type="button" id="refresh-table-portomar" style="display:none">

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset("plugins/custom/datatables/datatables.bundle.js" )}}"></script>
    <script type="text/javascript" src="{{ asset("js/reportes/reporte-general.js?v=") }}<?php echo(rand()); ?>"></script>
@endsection