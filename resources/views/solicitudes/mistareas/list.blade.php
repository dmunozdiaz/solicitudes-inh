@extends('layout.app')

@section('styles')
    <link href="{{ asset("plugins/custom/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("css/pretty-checkbox.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custom.css?v=') }}<?php echo(rand()); ?>" rel="stylesheet" type="text/css">
@endsection

@section('subheader_2')
@if ($supervisor == true)
<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
  <!--begin::Page title-->
  <div class="page-title d-flex flex-column me-3">
    <!--begin::Title-->
    <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Supervisión</h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->

    <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
      <!--begin::Item-->
      <li class="breadcrumb-item text-gray-600">
        <a href="javascrip:;" class="text-gray-600 text-hover-primary">Inicio</a>
      </li>
      <!--end::Item-->
      <!--begin::Item-->
      <li class="breadcrumb-item text-gray-500">Supervisión</li>
      <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
  </div>
  <!--end::Page title-->
</div>
@else
<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
  <!--begin::Page title-->
  <div class="page-title d-flex flex-column me-3">
    <!--begin::Title-->
    <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Mis Tareas</h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->

    <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
      <!--begin::Item-->
      <li class="breadcrumb-item text-gray-600">
        <a href="javascrip:;" class="text-gray-600 text-hover-primary">Inicio</a>
      </li>
      <!--end::Item-->
      <!--begin::Item-->
      <li class="breadcrumb-item text-gray-500">Mis Tareas</li>
      <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
  </div>
  <!--end::Page title-->
</div>
@endif

@endsection

@section('content')
<div class="content flex-row-fluid" id="kt_content">
  <!--begin::Row-->
  <div class="row gy-5 g-xl-10 pt-5">
    <!--begin::Col-->
    <div class="col-xl-12 mb-12 mb-xl-12">
      @if ($supervisor == true)  
      @else
      <!--begin::Texto ayuda-->
      <div class="card shadow-sm card-flush mb-12">
        <!--begin::Body-->
        <div class="card-body d-flex flex-column">
          <div class="fs-5 text-gray-600">
            <!--begin::Text-->
            <p> En esta sección encontrará todas las solicitudes que ha recibido el Municipio. En la 1ra sección denominada “Solicitudes Recibidas” se encuentran las solicitudes que acaban de llegar y/o que no tienen un funcionario asignado, por lo que usted podrá tomar una tarea para responder de inmediato o realizarla más tarde. En la 2da sección denominada “Solicitudes Asignadas” encontrará las solicitudes que usted tiene asignadas, y que sólo usted puede revisar y responder. En la 3ra sección denominada “Solicitudes Ejecutadas”, usted podrá revisar todas las solicitudes en las que ha participado. 
            </p>
            <!--end::Text-->
          </div>
        </div>
        <!--end::Body-->
      </div>
      @endif
      <!--end::Texto ayuda-->
      <!--begin::Engage widget 3-->
      <div class="card shadow-sm card-flush mb-12">
        <!--begin::Header-->
        @if ($supervisor == true)  @else
        
        <div class="card-header">
          <h3 class="card-title"> Mis Tareas</h3>
          <div class="card-toolbar"></div>
        </div>
        
        @endif

       
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body d-flex flex-column pt-0 pb-0">
          <!--begin::Tabs-->
          <ul class="nav row mb-10">
            @if ($portomar == true)
            <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
              <a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-outline-default btn-active-primary d-flex flex-grow-1 flex-center py-5 h-1250px h-lg-100px active" data-bs-toggle="tab" href="#kt_general_tab_portomar">
                <!--begin::Icon-->
                <div class="tab-number-icon w-40px h-40px me-5">
                  <span class="tab-number">1</span>
                </div>
                <!--end::Icon-->
                <span class="fs-6 fw-bold">Solicitudes Recibidas</span>
              </a>
            </li>
            @endif

            @if ($porhacer == true)
            <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
              <a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-outline-default btn-active-primary d-flex flex-grow-1 flex-center py-5 h-1250px h-lg-100px " data-bs-toggle="tab" href="#kt_general_tab_recibidas">
                <!--begin::Icon-->
                <div class="tab-number-icon w-40px h-40px me-5">
                  <span class="tab-number">2</span>
                </div>
                <!--end::Icon-->
                <span class="fs-6 fw-bold">Solicitudes Asignadas</span>
              </a>
            </li>
            @endif
           
            @if ($ejecutadas == true)
            <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
              <a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-outline-default btn-active-primary d-flex flex-grow-1 flex-center py-5 h-1250px h-lg-100px " data-bs-toggle="tab" href="#kt_general_tab_ejecutadas">
                <!--begin::Icon-->
                <div class="tab-number-icon w-40px h-40px me-5">
                  <span class="tab-number">3</span>
                </div>
                <!--end::Icon-->
                <span class="fs-6 fw-bold">Solicitudes Ejecutadas</span>
              </a>
            </li>
            @endif
            @if ($supervisor == true)
           <!-- <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
              <a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-outline-default btn-active-primary d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-150px active" data-bs-toggle="tab" href="#kt_general_tab_supervisor">
                
                <span class="svg-icon svg-icon-3x mb-5 mx-0">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/>
                    <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/>
                  </svg>
                </span>
               
                <span class="fs-6 fw-bold">Supervisor
                <br /></span>
              </a>
            </li>-->
            @endif
          </ul>
          <!--end::Tabs-->
          <!--begin::Tab content-->
          <div class="tab-content">
            <!--Inicio por tomar-->
            @if ($portomar == true)
            <div class="tab-pane fade {{ $portomaractivo }}" id="kt_general_tab_portomar">
              <!--begin::Texto ayuda-->
              <div class="card bg-body mb-10">
                <!--begin::Body-->
                <div class="card-body">
                  <div class="fs-5 text-gray-600">
                    <!--begin::Text-->
                    <p>Aquí podrá revisar las solicitudes recibidas sin realizar acciones, o bien tomar la solicitud, pudiendo procesarla de inmediato o posteriormente desde la sección “Solicitudes Asignadas”. Para acceder a la solicitud, haga clic en el ícono que se encuentra en la columna “Acciones” correspondiente a la solicitud requerida. Para buscar una solicitud específica, puede utilizar los filtros de búsqueda disponibles. </p>
                    <!--end::Text-->
                  </div>
                </div>
                <!--end::Body-->
              </div>
              <!--end::Texto ayuda-->
              <!--begin::Filtros Por Tomar-->
              <!--begin::Accordion-->
              <div class="accordion mb-10" id="filtros-portomar">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="filtros-portomar_header_1">
                    <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filtros-portomar_body_1" aria-expanded="false" aria-controls="filtros-portomar_body_1">
                        Filtros
                    </button>
                  </h2>
                  <div id="filtros-portomar_body_1" class="accordion-collapse collapse" aria-labelledby="filtros-portomar_header_1" data-bs-parent="#filtros-portomar">
                    <div class="accordion-body">
                      <div class="card">
                        <!--begin::Body-->
                        <div class="card-body">
                          <div class="form-group mb-8 row fv-plugins-icon-container">
                            <div class="col-md-4">
                              <label><strong>Buscar por Nº:</strong></label>
                              <input type="text" class="form-control" name="portomar_numero" id="portomar_numero">
                            </div>
                            <div class="col-md-4">
                              <label><strong>Tipo Solicitud:</strong></label>
                              <select class="form-control custom-select" name="portomar_proceso" id="portomar_proceso">
                                <option value="">Todas</option>
                                @foreach ($allPmProcess as $process)
                                <option value="{{ $process->prj_uid }}">{{ $process->prj_name }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-4">
                              <label><strong>Estado:</strong></label>
                              <select class="form-control" id="portomar_estado" name="portomar_estado">
                                <option value="">Seleccione un Estado</option>
                                <option value="1">Ingresada</option>
                                <option value="2">En proceso</option>
                                <option value="3">Finalizada</option>
                              </select>  
                             
                            </div>
                          </div> 
                          
                          <div class="form-group mb-8 row fv-plugins-icon-container">
                            <div class="col-md-4">
                              <label><strong>Fecha Ingreso Tarea Desde:</strong></label>
                              <input type="date" class="form-control" name="portomar_desde" id="portomar_desde">
                            </div>
                            <div class="col-md-4">
                              <label><strong>Fecha Ingreso Tarea Hasta:</strong></label>
                              <input type="date" class="form-control" name="portomar_hasta" id="portomar_hasta">
                            </div>
                            <div class="col-md-4">
                              <label><strong>Última modificación:</strong></label>
                              <input type="date" class="form-control" name="portomar_ultimamodificacion" id="portomar_ultimamodificacion">
                            </div>
                          </div>

                          <div class="form-group mb-8 row fv-plugins-icon-container">
                            <div class="col-md-4">
                              <label><strong>RUT Solicitante:</strong></label>
                              <input type="text" class="form-control" name="portomar_rutsolicitante" id="portomar_rutsolicitante">
                            </div>
                            <div class="col-md-4">
                              <label><strong>Nombre Solicitante:</strong></label>
                              <input type="text" class="form-control" name="portomar_nombresolicitante" id="portomar_nombresolicitante">
                            </div>
                            
                          </div>
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="card-footer">
                          <div class="row">
                            <div class="col-md-12">
                              <button type="button" class="btn btn-primary btn-primary--icon" id="filtrar_portomar">
                                <span>
                                  <i class="la la-search"></i>
                                  <span>Filtrar</span>
                                </span>
                              </button>
                              &nbsp;&nbsp;
                              <button class="btn btn-secondary btn-secondary--icon" id="limpiar_filtros_portomar">
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
              </div>
              <!--end::Accordion-->
              <!--end::Filtros Por Tomar-->
              <!--begin::Tables Widget 3-->
              <div class="card bg-body">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                  <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Últimas solicitudes recibidas</span>
                    <span class="text-muted mt-1 fw-bold fs-7"></span>
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
                    <table class="table table-striped table-hover border rounded gy-5 gs-7" id="tabla_portomar">
                      <thead>
                        <tr class="fw-bold fs-6 text-gray-800 text-center">
                          <th>N°</th>
                          <th>Tipo de Solicitud</th>
                          <th>Fecha de Ingreso</th>
                          <th>Datos Solicitante</th>
                          <th>Última modificación</th>
                          <th>Fecha de expiración</th>
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
              <!--end::Tables Widget 3-->
            </div>
            @endif
            <!--Fin por tomar-->

            <!--Inicio Por Hacer-->
            @if ($porhacer == true)
            <div class="tab-pane fade {{ $porhaceractivo }}" id="kt_general_tab_recibidas">
              <!--begin::Texto ayuda-->
              <div class="card bg-body mb-10">
                <!--begin::Body-->
                <div class="card-body">
                  <div class="fs-5 text-gray-600">
                    <!--begin::Text-->
                    <p>Aquí podrá revisar sus solicitudes asignadas para responder al ciudadano, o ponerla en proceso hasta que pueda ser respondida. Para acceder a la solicitud, haga clic en el ícono que se encuentra en la columna “Acciones” correspondiente a la solicitud requerida. Para buscar una solicitud específica, puede utilizar los filtros de búsqueda disponibles.</p>
                    <!--end::Text-->
                  </div>
                </div>
                <!--end::Body-->
              </div>
              <!--end::Texto ayuda-->
              <!--begin::Filtros Por Hacer-->
              <!--begin::Accordion-->
              <div class="accordion mb-10" id="filtros-recibidas">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="filtros-recibidas_header_1">
                    <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filtros-recibidas_body_1" aria-expanded="false" aria-controls="filtros-recibidas_body_1">
                        Filtros
                    </button>
                  </h2>
                  <div id="filtros-recibidas_body_1" class="accordion-collapse collapse" aria-labelledby="filtros-recibidas_header_1" data-bs-parent="#filtros-recibidas">
                    <div class="accordion-body">
                      <div class="card-body">
                        <div class="form-group mb-8 row fv-plugins-icon-container">
                          <div class="col-md-4">
                            <label><strong>Buscar por Nº:</strong></label>
                            <input type="text" class="form-control" name="porhacer_numero" id="porhacer_numero">
                          </div>
                          <div class="col-md-4">
                            <label><strong>Tipo Solicitud:</strong></label>
                            <select class="form-control custom-select" name="porhacer_proceso" id="porhacer_proceso">
                              <option value="">Todas</option>
                              @foreach ($allPmProcess as $process)
                              <option value="{{ $process->prj_uid }}">{{ $process->prj_name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-md-4">
                            <label><strong>Estado:</strong></label>
                            <select class="form-control" id="porhacer_estado" name="porhacer_estado">
                              <option value="">Seleccione un Estado</option>
                              <option value="1">Ingresada</option>
                              <option value="2">En proceso</option>
                              <option value="3">Finalizada</option>
                            </select>  
                           
                          </div>
                        </div> 
                        
                        <div class="form-group mb-8 row fv-plugins-icon-container">
                          <div class="col-md-6">
                            <label><strong>Fecha Ingreso Tarea Desde:</strong></label>
                            <input type="date" class="form-control" name="porhacer_desde" id="porhacer_desde">
                          </div>
                          <div class="col-md-6">
                            <label><strong>Fecha Ingreso Tarea Hasta:</strong></label>
                            <input type="date" class="form-control" name="porhacer_hasta" id="porhacer_hasta">
                          </div>
                         
                        </div>

                        <div class="form-group mb-8 row fv-plugins-icon-container">
                          <div class="col-md-6">
                            <label><strong>RUT Solicitante:</strong></label>
                            <input type="text" class="form-control" name="porhacer_rutsolicitante" id="porhacer_rutsolicitante">
                          </div>
                          <div class="col-md-6">
                            <label><strong>Nombre Solicitante:</strong></label>
                            <input type="text" class="form-control" name="porhacer_nombresolicitante" id="porhacer_nombresolicitante">
                          </div>
                          
                        </div>
                      </div>
                       <!--begin::Footer-->
                       <div class="card-footer">
                        <div class="row">
                          <div class="col-md-12">
                            <button type="button" class="btn btn-primary btn-primary--icon" id="filtrar_porhacer">
                              <span>
                                <i class="la la-search"></i>
                                <span>Filtrar</span>
                              </span>
                            </button>
                            &nbsp;&nbsp;
                            <button class="btn btn-secondary btn-secondary--icon" id="limpiar_filtros_porhacer">
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
              <!--end::Filtros Por Hacer-->
              <!--begin::Tables Widget 2-->
              <div class="card bg-body">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                  <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1"> Últimas solicitudes asignadas</span>
                    <span class="text-muted mt-1 fw-bold fs-7"></span>
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
                    <table class="table table-striped table-hover border rounded gy-5 gs-7" id="tabla_recibidas">
                      <thead>
                        <tr class="fw-bold fs-6 text-gray-800 text-center">
                          <th>N°</th>
                          <th>Tipo de Solicitud</th>
                          <th>Fecha</th>
                          <th>Datos Solicitante</th>
                          <th>Fecha Asignación</th>
                          <th>Fecha de expiración</th>
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
              <!--end::Tables Widget 2-->
            </div>
            @endif
            <!--Fin Por Hacer-->
            
            <!--Inicio Ejecutadas-->
            @if ($ejecutadas == true)
            <div class="tab-pane fade {{ $ejecutadasactivo }}" id="kt_general_tab_ejecutadas">
              <!--begin::Texto ayuda-->
              <div class="card bg-body mb-10">
                <!--begin::Body-->
                <div class="card-body">
                  <div class="fs-5 text-gray-600">
                    <!--begin::Text-->
                    <p>Aquí podrá revisar todas las solicitudes donde usted ha participado, ya sea que estén en proceso asignadas a otro usuario o finalizadas, sin poder realizar acciones. Para acceder al detalle de una solicitud, haga clic en el ícono que se encuentra en la columna “Acciones” correspondiente a la solicitud requerida. Para buscar una solicitud específica, puede utilizar los filtros de búsqueda disponibles.</p>
                    <!--end::Text-->
                  </div>
                </div>
                <!--end::Body-->
              </div>
              <!--end::Texto ayuda-->
              <!--begin::Filtros Ejecutadas-->
              <!--begin::Accordion-->
              <div class="accordion mb-10" id="filtros-ejecutadas">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="filtros-ejecutadas_header_1">
                    <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filtros-ejecutadas_body_1" aria-expanded="false" aria-controls="filtros-ejecutadas_body_1">
                        Filtros
                    </button>
                  </h2>
                  <div id="filtros-ejecutadas_body_1" class="accordion-collapse collapse" aria-labelledby="filtros-ejecutadas_header_1" data-bs-parent="#filtros-ejecutadas">
                    <div class="accordion-body">
                      <div class="card-body">
                        <div class="form-group mb-8 row fv-plugins-icon-container">
                          <div class="col-md-4">
                            <label><strong>Buscar por Nº:</strong></label>
                            <input type="text" class="form-control" name="ejecutada_numero" id="ejecutada_numero">
                          </div>
                          <div class="col-md-4">
                            <label><strong>Tipo Solicitud:</strong></label>
                            <select class="form-control custom-select" name="ejecutada_proceso" id="ejecutada_proceso">
                              <option value="">Todas</option>
                              @foreach ($allPmProcess as $process)
                              <option value="{{ $process->prj_uid }}">{{ $process->prj_name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-md-4">
                            <label><strong>Estado:</strong></label>
                            <select class="form-control" id="ejecutada_estado" name="ejecutada_estado">
                              <option value="">Seleccione un Estado</option>
                              <option value="1">Ingresada</option>
                              <option value="2">En proceso</option>
                              <option value="3">Finalizada</option>
                            </select>  
                           
                          </div>
                        </div> 
                        
                        <div class="form-group mb-8 row fv-plugins-icon-container">
                          <div class="col-md-6">
                            <label><strong>Fecha Ingreso Tarea Desde:</strong></label>
                            <input type="date" class="form-control" name="ejecutada_desde" id="ejecutada_desde">
                          </div>
                          <div class="col-md-6">
                            <label><strong>Fecha Ingreso Tarea Hasta:</strong></label>
                            <input type="date" class="form-control" name="ejecutada_hasta" id="ejecutada_hasta">
                          </div>
                         
                        </div>

                        <div class="form-group mb-8 row fv-plugins-icon-container">
                          <div class="col-md-6">
                            <label><strong>RUT Solicitante:</strong></label>
                            <input type="text" class="form-control" name="ejecutada_rutsolicitante" id="ejecutada_rutsolicitante">
                          </div>
                          <div class="col-md-6">
                            <label><strong>Nombre Solicitante:</strong></label>
                            <input type="text" class="form-control" name="ejecutada_nombresolicitante" id="ejecutada_nombresolicitante">
                          </div>
                          
                        </div>
                      </div>
                        <!--begin::Footer-->
                        <div class="card-footer">
                          <div class="row">
                            <div class="col-md-12">
                              <button type="button" class="btn btn-primary btn-primary--icon" id="filtrar_ejecutadas">
                                <span>
                                  <i class="la la-search"></i>
                                  <span>Filtrar</span>
                                </span>
                              </button>
                              &nbsp;&nbsp;
                              <button class="btn btn-secondary btn-secondary--icon" id="limpiar_filtros_ejecutadas">
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
              <!--end::Filtros Ejecutadas-->
              <!--begin::Tables Widget 5-->
              <div class="card bg-body">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                  <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Histórico de solicitudes ejecutadas</span>
                    <span class="text-muted mt-1 fw-bold fs-7"></span>
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
                    <table class="table table-striped table-hover border rounded gy-5 gs-7" id="tabla_ejecutadas">
                      <thead>
                        <tr class="fw-bold fs-6 text-gray-800 text-center">
                          <th>N°</th>
                          <th style="width:250px;">Tipo de Solicitud</th>
                          <th>Datos Solicitante</th>
                          <th>Usuario Actual</th>
                          <th>Última Modificacion</th>
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
              <!--end::Tables Widget 5-->
            </div>
            @endif
            <!-- Fin ejecutadas-->
            <!--Inicio supervisor-->
            @if ($supervisor == true)
            <div class="tab-pane fade {{ $supervisoractivo }}" id="kt_general_tab_supervisor">
              <!--begin::Texto ayuda-->
              <div class="card bg-body mb-10">
                <!--begin::Body-->
                <div class="card-body">
                  <div class="fs-5 text-gray-600">
                    <!--begin::Text-->
                    <p>En esta sección encontrará todas las solicitudes que ha recibido el Municipio, donde podrá revisar la información de cada solicitud, hacer seguimiento al estado en que se encuentra cada una y la información de respuesta proporcionada, si ya fue respondida.
                     <br> Para acceder al detalle de una solicitud, haga clic en el ícono que se encuentra en la columna “Acciones” correspondiente a la solicitud requerida. Para buscar una solicitud específica, puede utilizar los filtros de búsqueda disponibles.
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
                    <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filtros-supervisor_body_1" aria-expanded="false" aria-controls="filtros-supervisor_body_1">
                        Filtros
                    </button>
                  </h2>
                  <div id="filtros-supervisor_body_1" class="accordion-collapse collapse" aria-labelledby="filtros-supervisor_header_1" data-bs-parent="#filtros-supervisor">
                    <div class="accordion-body">
                      <div class="card-body">
                        <div class="form-group mb-8 row fv-plugins-icon-container">
                          <div class="col-md-4">
                            <label><strong>Buscar por Nº:</strong></label>
                            <input type="text" class="form-control" name="supervisor_numero" id="supervisor_numero">
                          </div>
                          <div class="col-md-4">
                            <label><strong>Tipo Solicitud:</strong></label>
                            <select class="form-control custom-select" name="supervisor_proceso" id="supervisor_proceso">
                              <option value="">Todas</option>
                              @foreach ($allPmProcessSupervisor as $process)
                              <option value="{{ $process->idsolicitud }}">{{ $process->nombresolicitud }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-md-4">
                            <label><strong>Estado:</strong></label>
                            <select class="form-control" id="supervisor_estado" name="supervisor_estado">
                              <option value="">Seleccione un Estado</option>
                              <option value="1">Ingresada</option>
                              <option value="2">En proceso</option>
                              <option value="3">Finalizada</option>
                            </select>  
                           
                          </div>
                        </div> 
                        
                        <div class="form-group mb-8 row fv-plugins-icon-container">
                          <div class="col-md-6">
                            <label><strong>Fecha Ingreso Tarea Desde:</strong></label>
                            <input type="date" class="form-control" name="supervisor_desde" id="supervisor_desde">
                          </div>
                          <div class="col-md-6">
                            <label><strong>Fecha Ingreso Tarea Hasta:</strong></label>
                            <input type="date" class="form-control" name="supervisor_hasta" id="supervisor_hasta">
                          </div>
                         
                        </div>

                        <div class="form-group row fv-plugins-icon-container">
                          <div class="col-md-6">
                            <label><strong>RUT Solicitante:</strong></label>
                            <input type="text" class="form-control" name="supervisor_rutsolicitante" id="supervisor_rutsolicitante">
                          </div>
                          <div class="col-md-6">
                            <label><strong>Nombre Solicitante:</strong></label>
                            <input type="text" class="form-control" name="supervisor_nombresolicitante" id="supervisor_nombresolicitante">
                          </div>
                          
                        </div>
                      </div>
                        <!--begin::Footer-->
                        <div class="card-footer">
                          <div class="row">
                            <div class="col-md-12">
                              <button type="button" class="btn btn-primary btn-primary--icon" id="filtrar_supervisor">
                                <span>
                                  <i class="la la-search"></i>
                                  <span>Filtrar</span>
                                </span>
                              </button>
                              &nbsp;&nbsp;
                              <button class="btn btn-secondary btn-secondary--icon" id="limpiar_filtros_supervisor">
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
                    <span class="card-label fw-bolder fs-3 mb-1">Solicitudes registradas en el sistema</span>
                    <span class="text-muted mt-1 fw-bold fs-7"></span>
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
                    <table class="table table-striped table-hover border rounded gy-5 gs-7" id="tabla_supervisor">
                      <thead>
                        <tr class="fw-bold fs-6 text-gray-800 text-center">
                          <th>N°</th>
                          <th style="width:250px;" >Tipo de Solicitud</th>
                          <th>Datos Solicitante</th>
                          <th>Usuario Actual</th>
                          <th>Última Modificacion</th>
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
            @endif
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
                      <input type="hidden" value="0" id="cerrarModal">
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
    <script type="text/javascript" src="{{ asset("js/solicitudes/bandejas.js?v=") }}<?php echo(rand()); ?>"></script>
@endsection