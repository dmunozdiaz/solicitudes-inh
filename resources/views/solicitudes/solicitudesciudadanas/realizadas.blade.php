@extends('layout.app_ciudadanorealizadas')

@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/pretty-checkbox.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css">
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
          <h3 class="fw-bolder mb-1">Solicitudes realizadas</h3>
          <div class="fs-6 w-lg-700px text-gray-400">Seleccione la solicitud que desea revisar y presione el botón "Ver detalle".  Puede utilizar el buscador de la derecha, indicando algún concepto o palabra clave del tipo de solicitud realizada.</div>
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
                <th class="min-w-50px">Nº de Ticket</th>
                <th >Fecha Solicitud</th>
                <th >Tipo Solicitud</th>
                <th >Área/Depto.</th>
                <th >Estado</th>
                <th class="min-w-100px">Opciones</th>
              </tr>
            </thead>
            <!--end::Head-->
            <!--begin::Body-->
            <tbody class="fs-7 fw-normal">
              @foreach ($solicitudes as $solicitud)
              <tr>
                <td class="">{{ $solicitud->app_number }}</td>
                <td class="">{{ $solicitud->created_at->format('d-m-Y H:i') }}</td>
                <td class="">
                  {{ App\Models\TipSolicitudes::where('id', '=', $solicitud->tiposolicitud_id)->first()->nombresolicitud }}
                </td>
                <td class="">
                  {{ App\Models\TipSolicitudes::where('id', '=', $solicitud->tiposolicitud_id)->first()->area }}\
                  {{ App\Models\TipSolicitudes::where('id', '=', $solicitud->tiposolicitud_id)->first()->direccion }}
                </td>
                <td class="">
                  @if ( $solicitud->estado == 1)
                  <span class="badge badge-light-danger fw-bolder fs-8 px-2 py-1 ms-2"> Ingresada </span>
                  @elseif ($solicitud->estado == 3)
                  <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">En proceso</span>
                  @else
                  <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Respondida</span>
                  @endif
                </td>
                <td class="">
                  <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#pm_form" data-idsolicitud="{{ $solicitud->id }}" data-title="{{ App\Models\TipSolicitudes::where('id', '=', $solicitud->tiposolicitud_id)->first()->nombresolicitud }}" class="btn btn-primary btn-sm" title="Ver detalles">Ver Detalle</a>
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
    <!--Inicio Modal-->
    <div id="pm_form" class="modal fade" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content" style="min-height: 590px;">
          <div class="modal-header py-5">
              <h5 class="modal-title"  id="titleModal">
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
        </div>
      </div>
    </div>
    <!--Fin Modal-->
  </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/solicitudes/solicitudes-tablas.js?v=') }}<?php echo(rand()); ?>"></script>
    <script type="text/javascript" src="{{ asset('js/solicitudes/solicitudes-realizadas.js?v=') }}<?php echo(rand()); ?>"></script>
@endsection
