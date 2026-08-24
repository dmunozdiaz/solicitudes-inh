@extends('layout.app')

@section('styles')
    <link href="{{ asset("plugins/custom/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css">
  
@endsection

@php
    $page_title = "Buscador de usuarias(os)";
@endphp

@section('subheader_2')
<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
  <!--begin::Page title-->
  <div class="page-title d-flex flex-column me-3">
    <!--begin::Title-->
    <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Gestión de Usuarios</h1>
    <!--end::Title-->
    <!--begin::Breadcrumb-->

    <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
      <!--begin::Item-->
      <li class="breadcrumb-item text-gray-600">
        <a href="javascrip:;" class="text-gray-600 text-hover-primary">Inicio</a>
      </li>
      <!--end::Item-->
       <!--begin::Item-->
       <li class="breadcrumb-item text-gray-500">Administración</li>
       <!--end::Item-->
      <!--begin::Item-->
      <li class="breadcrumb-item text-gray-500">Gestión de Usuarios</li>
      <!--end::Item-->
    </ul>
    <!--end::Breadcrumb-->
  </div>
  <!--end::Page title-->
</div>
@endsection


@section('subheader_2')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="text-muted">Inicio</a>
        </li>

        <li class="breadcrumb-item">
            <a href="" class="text-muted">Administración</a>
        </li>

        <li class="breadcrumb-item">
            <a href="" class="text-muted">Mantenedor de usuarias(os) y permisos </a>
        </li>
    </ul>
@endsection

@section('content')
    <!--begin::Card-->
    <div class="card card-custom" >
        <!--begin::Header-->
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">
                    Mantenedor de usuarias(os) y permisos
                    <span class="d-block text-muted pt-2 font-size-sm">Mantenedor de usuarias(os) del sistema y permisos asignados</span>
                </h3>
            </div>

            <div class="card-toolbar">
                @if(Auth::user()->hasAnyRole(["admin"]))
                    <button type="button" class="btn btn-primary font-weight-bolder" onclick="$('#modal_registro_usuario').modal('show');$('#form_registro_usuario')[0].reset();"><i class="fa fa-plus"></i>Agregar Usuaria(o)</button>

                   
                @else
                    
                @endif
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body" >
            <div class="form-group row">
                <div class="col-lg-4 text-right mb-lg-0 mb-6">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text line-height-0 py-0"><i class="flaticon-search"></i></span>
                        </div>

                        <input type="text" class="form-control" id="text_filtro" name="text_filtro"  >
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" onclick="getUsuarios();">Buscar</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 text-right mb-lg-0 mb-6"></div>

                <div class="col-lg-4 text-right mb-lg-0 mb-6"></div>
            </div>


            <div class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-hover table-checkable dataTable dtr-inline" id="tabla_usuarios">
                            <thead class="text-center">
                            <tr>

                                <td>ID</td>
                                <td>RUT</td>
                                <td>Nombre</td>
                                <td>Correo electrónico</td>
                                <td>Perfil</td>
                                <td>Estado</td>
                                <td>Acciones</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <!--end: Datatable-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Card-->

   
    <div class="modal fade" id="modal_registro_usuario" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalRegistrousuario" style="padding-right: 17px;" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text-center" id="ModalRegistrousuario" style="width: 100%;">
                        Agregar Usuario(a)

                    </h3>

                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                </div>

                <form class="form fv-plugins-bootstrap fv-plugins-framework" id="form_registro_usuario" novalidate="novalidate">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group row fv-plugins-icon-container">
                                <div class="col-lg-4 mb-lg-0 mb-6">
                                    <label>Rut <sup class="text-danger">*</sup>:</label>
                                    <input type="text" class="form-control datatable-input" placeholder="Ingrese Rut" data-col-index="0" name="add-rut" id="add-rut" oninput="formatRut(this);">
                                    <div class="fv-plugins-message-container" id="add-rut_alert"></div>
                                </div>
                                <div class="col-lg-4 mb-lg-0 mb-6">
                                    <label>Nombre <sup class="text-danger">*</sup>:</label>
                                    <input type="text" class="form-control datatable-input" placeholder="Ingrese Nombre" data-col-index="0" name="add-nombre" id="add-nombre">
                                    <div class="fv-plugins-message-container" id="add-nombre_alert"></div>
                                </div>
                                <div class="col-lg-4 mb-lg-0 mb-6">
                                    <label>Apellidos <sup class="text-danger">*</sup>:</label>
                                    <input type="text" class="form-control datatable-input" placeholder="Ingrese los Apellidos" data-col-index="0" name="add-appaterno" id="add-appaterno">
                                    <div class="fv-plugins-message-container" id="add-appaterno_alert"></div>
                                </div>





                            </div>

                            <div class="form-group row fv-plugins-icon-container">
                                
                                <div class="col-lg-4 mb-lg-0 mb-6">
                                    <label>Correo Electrónico <sup class="text-danger">*</sup>:</label>
                                    <input type="text" class="form-control datatable-input" placeholder="Ingrese Correo Electrónico" data-col-index="0" name="add-email" id="add-email">
                                    <div class="fv-plugins-message-container" id="add-email_alert"></div>
                                </div>


                                <div class="col-lg-4  mb-lg-0 mb-6">
                                    <label>Perfil <sup class="text-danger">*</sup>:</label>
                                    <select class="form-control datatable-input select2" name="add-perfil" id="add-perfil" multiple="multiple">
                                        
                                        @foreach(\App\Models\Role::all() as $rol)
                                            <option value="{{ $rol->id }}">{{ $rol->description }}</option>
                                        @endforeach
                                    </select>
                                    <div class="fv-plugins-message-container" id="add-perfil_alert"></div>
                                </div>

                                <div id="div-direccion" class="col-lg-4  mb-lg-0 mb-6 d-none" >
                                    <label>Dirección: <sup class="text-danger">*</sup></label>
                                    <select class="form-control datatable-input select2" name="add-direccion" id="add-direccion" multiple="multiple">
                                        
                                        @foreach(\App\Models\Direccion::all() as $rol)
                                            <option value="{{ $rol->id }}">{{ $rol->direccion }}</option>
                                        @endforeach
                                    </select>
                                    <div class="fv-plugins-message-container" id="add-direccion_alert"></div>
                                </div>

                                

                            </div>


                            <div class="form-group row fv-plugins-icon-container">
                                
                                <div id="div-encargado" class="col-lg-4  mb-lg-0 mb-6 d-none">
                                    <label>Encargados de Recepción<sup class="text-danger">*</sup>:</label>
                                    <select class="form-control datatable-input select2" name="add-grupopm" id="add-grupopm" multiple="multiple">
                                       
                                       
                                    </select>
                                    <div class="fv-plugins-message-container" id="add-grupopm_alert"></div>
                                </div>


                                <div id="div-tipsolicitud" class="col-lg-6  mb-lg-0 mb-6 d-none">
                                    <label>Solicitudes a Supervisar<sup class="text-danger">*</sup>:</label>
                                    <select class="form-control selectpicker select2" name="add-tiposolicitud" id="add-tiposolicitud" multiple="multiple">
                                        
                                       
                                        
                                    </select>
                                    <div class="fv-plugins-message-container" id="add-tiposolicitud_alert"></div>
                                </div>

                                <div id="div-direccionfuncionario" class="col-lg-4  mb-lg-0 mb-6 d-none">
                                    <label>Solicitudes asignables para procesar<sup class="text-danger">*</sup>:</label>
                                    <select class="form-control datatable-input select2" name="add-direccionfuncionario" id="add-direccionfuncionario" multiple="multiple">
                                       
                                       
                                    </select>
                                    <div class="fv-plugins-message-container" id="add-direccionfuncionario_alert"></div>
                                </div>

                                

                            </div>

                           

                        </div>
                    </div>

                    <div class="modal-footer" style="display: block;">
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <button type="button" class="btn btn-primary font-weight-bold" onclick="registrarUsuario();">Agregar</button>
                                &nbsp;&nbsp;
                                <button type="button" class="btn btn-light-primary font-weight-bold" data-bs-dismiss="modal" onclick="$('#descripcion_genero').attr('disabled', 'disabled'); $('#form_registro_usuario')[0].reset();">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_editar_usuario" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalRegistrousuario" style="padding-right: 17px;" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="text-center" id="ModalRegistrousuario" style="width: 100%;">
                        Editar Usuario(a)

                    </h3>

                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                </div>

                <form class="form fv-plugins-bootstrap fv-plugins-framework" id="form_editar_usuarios" novalidate="novalidate">
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group row fv-plugins-icon-container">
                                <div class="col-lg-4 mb-lg-0 mb-6">
                                    <label>Rut :</label>
                                    <input type="hidden" id="id_usuario" name="id_usuario" value="">
                                    <input type="text" class="form-control datatable-input" disabled data-col-index="0" name="edit-rut" id="edit-rut" >
                                    <div class="fv-plugins-message-container" id="edit-rut_alert"></div>
                                </div>

                                <div class="col-lg-4 mb-lg-0 mb-6">
                                    <label>Nombre <sup class="text-danger">*</sup>:</label>
                                    <input type="text" class="form-control datatable-input" placeholder="Ingrese Nombre" data-col-index="0" name="edit-nombre" id="edit-nombre">
                                    <div class="fv-plugins-message-container" id="edit-nombre_alert"></div>
                                </div>

                                <div class="col-lg-4 mb-lg-0 mb-6">
                                    <label>Apellidos *:</label>
                                    <input type="text" class="form-control datatable-input" placeholder="Ingrese Apellidos" data-col-index="0" name="edit-appaterno" id="edit-appaterno">
                                    <div class="fv-plugins-message-container" id="edit-appaterno_alert"></div>
                                </div>
                            </div>

                            <div class="form-group row fv-plugins-icon-container">
                               

                                <div class="col-lg-4 mb-lg-0 mb-6">
                                    <label>Correo Electrónico <sup class="text-danger">*</sup>:</label>
                                    <input type="text" class="form-control datatable-input" placeholder="Ingrese Correo Electrónico" data-col-index="0" name="edit-email" id="edit-email">
                                    <div class="fv-plugins-message-container" id="edit-email_alert"></div>
                                </div>


                                <div class="col-lg-4  mb-lg-0 mb-6">
                                    <label>Perfil <sup class="text-danger">*</sup>:</label>
                                    <select class="form-control datatable-input select2" name="edit-perfil" id="edit-perfil" multiple="multiple">
                                       
                                        @foreach(\App\Models\Role::all() as $rol)
                                            <option value="{{ $rol->id }}">{{ $rol->description }}</option>
                                        @endforeach
                                    </select>

                                    <div class="fv-plugins-message-container" id="edit-perfil_alert"></div>
                                </div>

                                <div id="div-editdireccion" class="col-lg-4  mb-lg-0 mb-6 d-none">
                                    <label>Dirección: <sup class="text-danger">*</sup></label>
                                    <select class="form-control datatable-input select2" name="edit-direccion" id="edit-direccion" multiple="multiple">
                                        
                                        @foreach(\App\Models\Direccion::all() as $rol)
                                            <option value="{{ $rol->id }}">{{ $rol->direccion }}</option>
                                        @endforeach
                                    </select>
                                    <div class="fv-plugins-message-container" id="edit-direccion_alert"></div>
                                </div>

                            </div>

                            <div  class="form-group row fv-plugins-icon-container ">
                                <div id="div-editencargado" class="col-lg-4 d-none mb-lg-0 mb-6">
                                    <label>Encargados de Recepción <sup class="text-danger">*</sup>:</label>
                                    <select class="form-control datatable-input select2" name="edit-grupopm" id="edit-grupopm" multiple="multiple">
                                        
                                       
                                    </select>
                                    <div class="fv-plugins-message-container" id="edit-grupopm_alert"></div>
                                </div>
                               


                                <div id="div-edittipsolicitud" class="col-lg-6  mb-lg-0 mb-6 d-none">
                                    <label>Solicitudes a Supervisar <sup class="text-danger">*</sup>:</label>
                                    <select class="form-control selectpicker select2" name="edit-tiposolicitud" id="edit-tiposolicitud" multiple="multiple">
                                        
                                        
                                        
                                    </select>
                                    <div class="fv-plugins-message-container" id="edit-tiposolicitud_alert"></div>
                                </div>

                                <div id="div-editdireccionfuncionario" class="col-lg-4  mb-lg-0 mb-6 d-none">
                                    <label>Solicitudes asignables para procesar <sup class="text-danger">*</sup>:</label>
                                    <select class="form-control datatable-input select2" name="edit-direccionfuncionario" id="edit-direccionfuncionario" multiple="multiple">
                                       
                                        
                                    </select>
                                    <div class="fv-plugins-message-container" id="edit-direccionfuncionario_alert"></div>
                                </div>
                                

                            </div>
                           
                           
                        </div>
                    </div>

                    <div class="modal-footer" style="display: block;">
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <button type="button" class="btn btn-light-primary font-weight-bold" data-bs-dismiss="modal" >Cerrar</button>
                                &nbsp;&nbsp;
                                <button type="button" class="btn btn-primary font-weight-bold" onclick="actualizacionUsuario();">Modificar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <input type="hidden" id='minnum' value="{{ config('app.pass_min_num') }}"/>
<input type="hidden" id='maxlen' value="{{ config('app.pass_long') }}"/>

@endsection

@section('scripts')
    
   



     <script type="text/javascript" src="{{ asset('js/administracion/usuarios/view.js?v=') }}<?php echo(rand()); ?>"></script>
   

   
@endsection
