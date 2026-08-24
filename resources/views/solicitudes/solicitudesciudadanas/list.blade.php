@extends('layout.app_ciudadanorealizar')

@section('styles')
    <link href="{{ asset("plugins/custom/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("css/pretty-checkbox.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("plugins/custom/uppy/uppy.bundle.css") }}" rel="stylesheet" type="text/css">
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
<div class="content flex-row-fluid" id="kt_content">
  <!--begin::Table-->
  <div class="card shadow-sm card-flush mt-6 mt-xl-9">
    <!--begin::Card header-->
    <div class="card-header mt-5">
      <!--begin::Card title-->
      <div class="card-title flex-column">
        <h3 class="fw-bolder mb-1">Solicitudes disponibles por Dirección</h3>
        <div class="fs-6 w-lg-700px text-gray-400">Seleccione la solicitud que mejor se ajuste a su requerimiento y presione el botón "Realizar Solicitud".  Puede utilizar el buscador de la derecha, indicando algún concepto o palabra clave de la solicitud a realizar.</div>
      </div>
      <!--end::Card title-->
      <!--begin::Card toolbar-->
      <div class="card-toolbar my-1">
        <!--begin::Search-->
        <div class="d-flex align-items-center position-relative my-1">
          <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
          <span class="svg-icon svg-icon-3 position-absolute ms-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
              <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
            </svg>
          </span>
          <!--end::Svg Icon-->
          <input type="text" id="kt_filter_search" class="form-control form-control-solid form-select-sm w-450px ps-9" placeholder="Buscar Solicitud" />
        </div>
        <!--end::Search-->
      </div>
      <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0">
      <!--begin::Table container-->
      <div class="table-responsive">
        <!--begin::Table-->
        <table id="solicitud_ciudadana_table" class="table table-striped table-hover table-row-bordered table-row-dashed gy-4 align-middle fw-bolder">
          <!--begin::Head-->
          <thead class="fs-6 text-gray-400 text-uppercase">
            <tr>
              <th class="min-w-20px">Nº</th>
              <th >Solicitud Ciudadana</th>
              <th >Dirección</th>
              <th >Descripción</th>
              <th class="min-w-100px">Opciones</th>
            </tr>
          </thead>
          <!--end::Head-->
          <!--begin::Body-->
          <tbody class="fs-7 fw-normal">
            @foreach ($solicitudes as $solicitud)
            <tr>
              <td class="">{{$solicitud->numidetificador}}</td>
              <td class="">{{$solicitud->nombresolicitud}}</td>
              
              <td class="">{{$solicitud->direccion}}</td>
              <td class="">{{$solicitud->descripcion}}</td>
              <td class="">
                @if ($solicitud->idsolicitud ==0 )
                <a href="#" class="btn btn-light bnt-active-light-primary btn-sm">Pronto!!</a>
                @else
                  <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_new_target" data-idsolicitud="{{$solicitud->id}}"  data-subtitle="{{$solicitud->nombresolicitud}}" class="btn btn-primary btn-sm">Realizar Solicitud</a>
                @endif
                
              </td>
            <!--end::Qty-->
            </tr>
            @endforeach
          </tbody>
          <!--end::Body-->
        </table>
        <!--end::Table-->
      </div>
      <!--end::Table container-->
    </div>
    <!--end::Card body-->
  </div>
  <!--end::Card-->
  <div class="modal fade" id="kt_modal_new_target" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
      <!--begin::Modal content-->
      <div class="modal-content rounded" id="kt_block_ui_4_target">
          <!--begin::Modal header-->
          <div class="modal-header pb-0 border-0 justify-content-end">
              <!--begin::Close-->
              <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                  <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                  <span class="svg-icon svg-icon-1">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                          <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                      </svg>
                  </span>
                  <!--end::Svg Icon-->
              </div>
              <!--end::Close-->
          </div>
          <!--begin::Modal header-->
          <!--begin::Modal body-->
          <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
              <!--begin:Form-->
              <form id="kt_modal_new_target_form" class="form" action="#">
                  <!--begin::Heading-->
                  <div class="mb-13 text-center">
                      <!--begin::Title-->
                      <h1 class="mb-3">Solicitud Ciudadana</h1>
                      <!--end::Title-->
                      <!--begin::Description-->
                      <div class="text-muted fw-bold fs-5" id="modal-subtitle"></div>
                      <!--end::Description-->
                  </div>
                  <!--end::Heading-->
                   <!--begin::Input group-->
                   <div class="d-flex flex-column mb-8 fv-row">
                      <!--begin::Label-->
                      <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                          <span >Solicitante:</span>
                         
                      </label>
                      <!--end::Label-->
                      <span class="fw-bolder fs-6 text-gray-800">@isset(Auth::user()->name) {{Auth::user()->name}} {{Auth::user()->lastname}} @endisset  </span> 
                  </div>
                  <!--end::Input group-->
                   <!--begin::Input group-->
                   <div class="d-flex flex-column mb-8 fv-row">
                      <!--begin::Label-->
                      <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                          <span >RUT:</span>
                         
                      </label>
                      <!--end::Label-->
                      <span class="fw-bolder fs-6 text-gray-800">@isset(Auth::user()->rut) {{Auth::user()->rut}} - {{Auth::user()->dv}} @endisset  </span> 
                  </div>
                  <!--end::Input group-->
                  <!--begin::Input group-->
                  <div class="d-flex flex-column mb-8 fv-row">
                      <!--begin::Label-->
                      <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                          <span class="required">Email:</span>
                          <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Registre su correo electrónico, el que será utilizado para notificarle el estado de su solicitud, y/o para contactarlo en caso de requerirlo."></i>
                      </label>
                      <!--end::Label-->
                      <input class="form-control" type="text" value="@isset(Auth::user()->name) {{Auth::user()->email}} @endisset" id="email" name="email" />
                      <div class="fv-plugins-message-container" id="email_alert"></div>
                      
                  </div>
                  <!--end::Input group-->
                   <!--begin::Input group-->
                   <div class="d-flex flex-column mb-8 fv-row">
                      <!--begin::Label-->
                      <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                          <span class="required" >Teléfono:</span>
                          <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Registre su número telefónico (9 dígitos), el que podrá ser utilizado para contactarlo en caso de requerirlo."></i>
                      </label>
                      <!--end::Label-->
                      <input class="form-control" type="text" value="@isset(Auth::user()->name) {{Auth::user()->telefono}} @endisset" id="telefono" name="telefono" />
                      <div class="fv-plugins-message-container" id="telefono_alert"></div>
                  </div>
                  <!--end::Input group-->
              
                  <!--begin::Input group-->
                  <div class="d-flex flex-column mb-8">
                      <label class="fs-6 fw-bold mb-2 "> <span class="required">Descripción del requerimiento:</span> <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Describa en detalle su solicitud o consulta que desea realizar. Indique todos los antecedentes que considere necesarios."></i> </label>
                      <textarea class="form-control form-control-solid" rows="3" name="descripcion" id="descripcion" placeholder="Descripción"></textarea>
                      <div class="fv-plugins-message-container" id="descripcion_alert"></div>
                  </div>
                  <!--end::Input group-->
                  <div class="form-group mb-8 row">
                      <label class="col-lg-3 col-form-label text-lg-right">Archivos:</label>
                      <div class="col-lg-6">
                          <div class="uppy" id="kt_uppy_5">
                              <div class="uppy-wrapper"></div>
                              <div class="uppy-list"></div>
                              <div class="uppy-status"></div>
                              <div class="uppy-informer uppy-informer-min"></div>
                          </div>
                          <span class="form-text text-muted">El tamaño máximo de archivo es de 5 MB y el número máximo de archivos es de 5.</span>
                      </div>
                  </div>
                
                  <!--begin::Actions-->
                  <div class="form-group text-center">
                      <input type="button" id="kt_modal_new_target_cancel" class="btn btn-light me-3" value="Cancelar">
                      <input type="button" id="kt_enviar_solicitud" class="btn btn-primary" value="Enviar Solicitud">
                         
                     <input type="hidden" id="idsolicitud" value="">
                  </div>
                  <!--end::Actions-->
              </form>
              <!--end:Form-->
          </div>
          <!--end::Modal body-->
      </div>
      <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
  </div>
</div>




@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset("plugins/custom/uppy/uppy.bundle.js?v=" )}}<?php echo(rand()); ?>"></script>
    <script type="text/javascript" src="{{ asset("plugins/custom/uppy/locale.js?v=" )}}<?php echo(rand()); ?>" ></script>
    <script type="text/javascript" src="{{ asset('js/solicitudes/solicitudes-tablas.js?v=') }}<?php echo(rand()); ?>"></script>
    <script type="text/javascript" src="{{ asset("js/solicitudes/solicitud-ciudadana.js?v=") }}<?php echo(rand()); ?>"></script>

    
    @if (Session::has('status1'))
      <script type="text/javascript">
        Swal.fire({
          title: "Estimado Ciudadano:",
          html: '<p style="text-align: justify">Paulatinamente se incorporan nuevos Departamentos Municipales a esta nueva modalidad de atención. <br>Muchas Gracias. <p>',
          icon: "success",
          buttonsStyling: false,
          confirmButtonText: "Confirmar",
          customClass: {
          confirmButton: "btn btn-primary"
          }
        });
      </script>
      @endif 
      
@endsection