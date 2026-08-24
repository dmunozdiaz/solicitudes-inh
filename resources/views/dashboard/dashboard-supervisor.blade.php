@extends('layout.app')

@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/pretty-checkbox.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custom.css?v=') }}<?php echo rand(); ?>" rel="stylesheet" type="text/css">
@endsection

@section('subheader_2')
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Dashboard</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->

            <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a href="javascrip:;" class="text-gray-600 text-hover-primary">Inicio</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">Dashboard</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
       <!--begin::Actions-->
       <div class="d-flex align-items-center py-2 py-md-1">
        <!--begin::Wrapper-->
        <div class="me-3" style=" width: 300px;">
            <!--begin::Input group-->
            <div class="mb-1">
                <!--begin::Label-->
                <label class="form-label fw-bold">Direcciones:</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div>
                    <select id="direccion" class="form-select" data-control="select2" name="direccion" data-placeholder="Seleccione Dirección...">
                        <option value="" >Selecciones</option>
                        @foreach ($direcciones as $direccion )
                        <option  @if ($loop->first) selected @endif value="{{$direccion->id}}">{{$direccion->direccion}}</option>
                        @endforeach
                        
                    </select>
                </div>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <!--end::Wrapper-->
        <!--begin::Wrapper-->
        <div class="me-3" style=" width: 400px;">
            <!--begin::Input group-->
            <div class="mb-1">
                <!--begin::Label-->
                <label class="form-label fw-bold">Tipo de Solicitud:</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div>
                    <select id="tposolicitud" class="form-select" data-control="select2" name="tposolicitud" data-placeholder="Seleccione Tipo de Solicitud..." data-allow-clear="true">
                        <option></option>
                        @foreach ($tiposolicitudes as $tiposolicitud )
                        <option value="{{$tiposolicitud->id}}">{{$tiposolicitud->nombresolicitud}}</option>
                        @endforeach
                    </select>
                </div>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Actions-->
    </div>
@endsection

@section('content')
<!--begin::Post-->
<div class="content flex-row-fluid" id="kt_content">
    <!--begin::Row-->
    <div class="row gy-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-sm-6 col-xl-2 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100" style="background: linear-gradient(180deg, rgba(255,255,255,0) 10%, rgba(80,205,137,0.1) 100%);">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-column">         
                    <!--begin::Icon--> 
                    <div class="m-0">
                       <!--begin::Svg Icon | path: assets/media/icons/duotune/abstract/abs018.svg-->
                        <span class="svg-icon svg-icon-primary svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M10.6 10.7C13.3 8 16.9 6.3 20.9 6C21.5 6 21.9 5.5 21.9 4.9V3C21.9 2.4 21.4 2 20.9 2C15.8 2.3 11.2 4.4 7.79999 7.8C4.39999 11.2 2.2 15.8 2 20.9C2 21.5 2.4 21.9 3 21.9H4.89999C5.49999 21.9 6 21.5 6 20.9C6.2 17 7.90001 13.4 10.6 10.7Z" fill="black"/>
                            <path opacity="0.3" d="M14.8 14.9C16.4 13.3 18.5 12.2 20.9 12C21.5 11.9 21.9 11.5 21.9 10.9V9C21.9 8.4 21.4 8 20.8 8C17.4 8.3 14.3 9.8 12 12.1C9.7 14.4 8.19999 17.5 7.89999 20.9C7.89999 21.5 8.29999 22 8.89999 22H10.8C11.4 22 11.8 21.6 11.9 21C12.2 18.6 13.2 16.5 14.8 14.9ZM16.2 16.3C17.4 15.1 19 14.3 20.7 14C21.3 13.9 21.8 14.4 21.8 15V17C21.8 17.5 21.4 18 20.9 18.1C20.1 18.3 19.5 18.6 19 19.2C18.5 19.8 18.1 20.4 17.9 21.1C17.8 21.6 17.4 22 16.8 22H14.8C14.2 22 13.7 21.5 13.8 20.9C14.2 19.1 15 17.5 16.2 16.3Z" fill="black"/>
                            </svg></span>
                            <!--end::Svg Icon-->
                    </div>                           
                    <!--end::Icon-->
                    <!--begin::Section--> 
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->           
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="tiempopromedio"></span> 
                        <!--end::Number--> 
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">Tiempo promedio de 1ra respuesta</span>  													
                        </div>       
                        <!--end::Follower--> 
                    </div>  
                    <!--end::Section-->          
                                             
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-sm-6 col-xl-2 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100" style="background: linear-gradient(180deg, rgba(255,255,255,0) 10%, rgba(80,205,137,0.1) 100%);">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                    <!--begin::Icon--> 
                    <div class="m-0">
                       <!--begin::Svg Icon | path: assets/media/icons/duotune/abstract/abs046.svg-->
<span class="svg-icon svg-icon-primary svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <path d="M8 22C7.4 22 7 21.6 7 21V9C7 8.4 7.4 8 8 8C8.6 8 9 8.4 9 9V21C9 21.6 8.6 22 8 22Z" fill="black"/>
    <path opacity="0.3" d="M4 15C3.4 15 3 14.6 3 14V6C3 5.4 3.4 5 4 5C4.6 5 5 5.4 5 6V14C5 14.6 4.6 15 4 15ZM13 19V3C13 2.4 12.6 2 12 2C11.4 2 11 2.4 11 3V19C11 19.6 11.4 20 12 20C12.6 20 13 19.6 13 19ZM17 16V5C17 4.4 16.6 4 16 4C15.4 4 15 4.4 15 5V16C15 16.6 15.4 17 16 17C16.6 17 17 16.6 17 16ZM21 18V10C21 9.4 20.6 9 20 9C19.4 9 19 9.4 19 10V18C19 18.6 19.4 19 20 19C20.6 19 21 18.6 21 18Z" fill="black"/>
    </svg></span>
    <!--end::Svg Icon-->
                    </div>                           
                    <!--end::Icon-->
                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->           
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="tiempomaximorespuesta"></span> 
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">Tiempo máximo de 1ra respuesta</span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                                              
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-sm-6 col-xl-2 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100" style="background: linear-gradient(180deg, rgba(255,255,255,0) 10%, rgba(80,205,137,0.1) 100%);">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                    <!--begin::Icon-->
                    <div class="m-0">
                        <!--begin::Svg Icon | path: assets/media/icons/duotune/abstract/abs029.svg-->
<span class="svg-icon svg-icon-primary svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <path d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z" fill="black"/>
    <path opacity="0.3" d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z" fill="black"/>
    </svg></span>
    <!--end::Svg Icon-->
                    </div>
                    <!--end::Icon-->
                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="tiempopromedioenproceso"></span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">Tiempo promedio en proceso</span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                   
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-sm-6 col-xl-2 mb-5 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100" style="background: linear-gradient(180deg, rgba(255,255,255,0) 10%, rgba(80,205,137,0.1) 100%);">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                    <!--begin::Icon-->
                    <div class="m-0">
                        <!--begin::Svg Icon | path: assets/media/icons/duotune/abstract/abs019.svg-->
<span class="svg-icon svg-icon-primary svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <path d="M18.0002 22H6.00019C5.20019 22 4.8002 21.1 5.2002 20.4L12.0002 12L18.8002 20.4C19.3002 21.1 18.8002 22 18.0002 22Z" fill="black"/>
    <path opacity="0.3" d="M18.8002 3.6L12.0002 12L5.20019 3.6C4.70019 3 5.20018 2 6.00018 2H18.0002C18.8002 2 19.3002 2.9 18.8002 3.6Z" fill="black"/>
    </svg></span>
    <!--end::Svg Icon-->
                    </div>
                    <!--end::Icon-->
                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="tiempomaximoenproceso"></span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">Tiempo máximo en Proceso</span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                   
                   
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-sm-6 col-xl-2 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100" style="background: linear-gradient(180deg, rgba(255,255,255,0) 10%, rgba(80,205,137,0.1) 100%);">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-column">         
                    <!--begin::Icon--> 
                    <div class="m-0">
                       <!--begin::Svg Icon | path: assets/media/icons/duotune/art/art009.svg-->
<span class="svg-icon svg-icon-primary svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <path opacity="0.3" d="M21 18.3V4H20H5C4.4 4 4 4.4 4 5V20C10.9 20 16.7 15.6 19 9.5V18.3C18.4 18.6 18 19.3 18 20C18 21.1 18.9 22 20 22C21.1 22 22 21.1 22 20C22 19.3 21.6 18.6 21 18.3Z" fill="black"/>
    <path d="M22 4C22 2.9 21.1 2 20 2C18.9 2 18 2.9 18 4C18 4.7 18.4 5.29995 18.9 5.69995C18.1 12.6 12.6 18.2 5.70001 18.9C5.30001 18.4 4.7 18 4 18C2.9 18 2 18.9 2 20C2 21.1 2.9 22 4 22C4.8 22 5.39999 21.6 5.79999 20.9C13.8 20.1 20.1 13.7 20.9 5.80005C21.6 5.40005 22 4.8 22 4Z" fill="black"/>
    </svg></span>
    <!--end::Svg Icon-->                  		
                    </div>                           
                    <!--end::Icon-->
                    <!--begin::Section--> 
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->           
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="tiempopromediototalrespuesta"></span> 
                        <!--end::Number--> 
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">Tiempo promedio Total de respuesta</span>  
                        </div>       
                        <!--end::Follower--> 
                    </div>  
                    <!--end::Section-->          
                                                
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-sm-6 col-xl-2 mb-5 mb-xl-10">
            <!--begin::Card widget 2-->
            <div class="card h-lg-100" style="background: linear-gradient(180deg, rgba(255,255,255,0) 10%, rgba(80,205,137,0.1) 100%);">
                <!--begin::Body-->
                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                    <!--begin::Icon-->
                    <div class="m-0">
                        <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen022.svg-->
<span class="svg-icon svg-icon-primary svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <path d="M11.2929 2.70711C11.6834 2.31658 12.3166 2.31658 12.7071 2.70711L15.2929 5.29289C15.6834 5.68342 15.6834 6.31658 15.2929 6.70711L12.7071 9.29289C12.3166 9.68342 11.6834 9.68342 11.2929 9.29289L8.70711 6.70711C8.31658 6.31658 8.31658 5.68342 8.70711 5.29289L11.2929 2.70711Z" fill="black"/>
    <path d="M11.2929 14.7071C11.6834 14.3166 12.3166 14.3166 12.7071 14.7071L15.2929 17.2929C15.6834 17.6834 15.6834 18.3166 15.2929 18.7071L12.7071 21.2929C12.3166 21.6834 11.6834 21.6834 11.2929 21.2929L8.70711 18.7071C8.31658 18.3166 8.31658 17.6834 8.70711 17.2929L11.2929 14.7071Z" fill="black"/>
    <path opacity="0.3" d="M5.29289 8.70711C5.68342 8.31658 6.31658 8.31658 6.70711 8.70711L9.29289 11.2929C9.68342 11.6834 9.68342 12.3166 9.29289 12.7071L6.70711 15.2929C6.31658 15.6834 5.68342 15.6834 5.29289 15.2929L2.70711 12.7071C2.31658 12.3166 2.31658 11.6834 2.70711 11.2929L5.29289 8.70711Z" fill="black"/>
    <path opacity="0.3" d="M17.2929 8.70711C17.6834 8.31658 18.3166 8.31658 18.7071 8.70711L21.2929 11.2929C21.6834 11.6834 21.6834 12.3166 21.2929 12.7071L18.7071 15.2929C18.3166 15.6834 17.6834 15.6834 17.2929 15.2929L14.7071 12.7071C14.3166 12.3166 14.3166 11.6834 14.7071 11.2929L17.2929 8.70711Z" fill="black"/>
    </svg></span>
    <!--end::Svg Icon-->
                    </div>
                    <!--end::Icon-->
                    <!--begin::Section-->
                    <div class="d-flex flex-column my-7">
                        <!--begin::Number-->
                        <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2" id="tiempomaximototalrespuesta"></span>
                        <!--end::Number-->
                        <!--begin::Follower-->
                        <div class="m-0">
                            <span class="fw-semibold fs-6 text-gray-400">Tiempo máximo Total de respuesta</span>
                        </div>
                        <!--end::Follower-->
                    </div>
                    <!--end::Section-->
                   
                </div>
                <!--end::Body-->
            </div>
            <!--end::Card widget 2-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-xl-3">
            <!--begin::Card widget 3-->
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #F1416C;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">
                <!--begin::Header-->
                <div class="card-header pt-5 mb-3 px-6">
                    <!--begin::Icon-->
                    <div class="d-flex flex-center rounded-circle h-80px w-80px" style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #F1416C">
                        <i class="bi bi-box-arrow-in-down text-white fs-2qx lh-0"></i>
                    </div>
                    <!--end::Icon-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="card-body d-flex align-items-end mb-3 px-6">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center">
                        <span class="fs-4hx text-white fw-bold me-4" id="iexpiraingresada"></span>
                        <div class="fw-bold fs-6 text-white">
                            <span class="d-block">Solicitudes estado “Ingresada”</span>
                            <span class="">Fuera de Plazo</span>
                        </div>            
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->
                <div class="card-footer px-6" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
                    <!--begin::Progress-->
                    <div class="fw-bold text-white py-2">
                        <span class="fs-1 d-block" id="iingresadas"></span>
                        <span class="opacity-50">Total de solicitudes en estado “Ingresada”</span>
                    </div>          
                    <!--end::Progress-->
                </div>
                <!--end::Card footer-->
            </div>
            <!--end::Card widget 3-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xl-3">
            <!--begin::Card widget 3-->
            <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #7239EA;background-image:url('assets/media/svg/shapes/wave-bg-purple.svg')">
                <!--begin::Header-->
                <div class="card-header pt-5 mb-3 px-6">
                    <!--begin::Icon-->
                    <div class="d-flex flex-center rounded-circle h-80px w-80px" style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #7239EA">
                        <i class="bi bi-arrow-repeat text-white fs-2qx lh-0"></i>
                    </div>
                    <!--end::Icon-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="card-body d-flex align-items-end mb-3 px-6">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center">
                        <span class="fs-4hx text-white fw-bold me-6" id="iexpiraproceso"></span>
                        <div class="fw-bold fs-6 text-white">
                            <span class="d-block">Solicitudes estado “En Proceso”</span>
                            <span class="">Fuera de Plazo</span>
                        </div>
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->
                <div class="card-footer px-6" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
                    <!--begin::Progress-->
                    <div class="fw-bold text-white py-2">
                        <span class="fs-1 d-block" id="iproceso"></span>
                        <span class="opacity-50">Total de solicitudes en estado “En Proceso”</span>
                    </div>          
                    <!--end::Progress-->
                </div>
                <!--end::Card footer-->
            </div>
            <!--end::Card widget 3-->
        </div>
        <!--end::Col-->   
        <!--begin::Col-->
        <div class="col-xl-6">
            <!--begin::Summary-->
            <div class="card card-flush h-lg-100">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Gráfico con cantidad de solicitudes en los distintos estados</h3>
                       
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                         <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                         <div class='input-group' id='kt_daterangepicker_5'>
                            <input type='text' class="form-control" id="periodo1" name="periodo1" readonly placeholder="Seleccione período" style=" width: 220px; "/>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                            </div>
                        </div>  
                            <!--end::Daterangepicker-->  
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-9 pt-5">
                    <!--begin::Chart-->
                    <div class="d-flex flex-center me-5 pt-2">
                        <div id="kt_charts_widget_18_chart" class="h-325px w-100 min-h-auto ps-4 pe-6"></div>
                    </div>
                    <!--end::Chart-->
                    
                  
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Summary-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    
    <!--begin::Row-->
    <div class="row g-5 g-xl-10  mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-lg-6">
            <!--begin::Graph-->
            <div class="card card-flush overflow-hidden h-lg-100">
                <!--begin::Card header-->
                <div class="card-header mt-6">
                    <!--begin::Card title-->
                    <div class="card-title flex-column">
                        <h3 class="fw-bolder mb-1">Gráfico con cantidades de solicitudes recibidas y terminadas por año</h3>
                        <!--begin::Labels-->
                        <div class="fs-6 d-flex text-gray-400 fs-6 fw-bold">
                           
                         
                             <!--begin::Label-->
                             <div class="d-flex align-items-center me-6">
                                <span class="menu-bullet d-flex align-items-center me-2">
                                    <span class="bullet bg-success"></span>
                                </span>Recibidas</div>
                                <!--end::Label-->
                                   <!--begin::Label-->
                            <div class="d-flex align-items-center">
                                <span class="menu-bullet d-flex align-items-center me-2">
                                    <span class="bullet bg-primary"></span>
                                </span>Terminadas</div>
                                <!--end::Label-->
                        </div>
                        <!--end::Labels-->
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Select-->
                        <select name="status" id="anio" name="anio" data-control="select2" data-hide-search="true" class="form-select form-select-solid form-select-sm fw-bolder w-100px">
                            @foreach ($anios as $anio )
                            <option @if ($loop->first) selected @endif value="{{$anio->anio}}">{{$anio->anio}}</option>
                            @endforeach
                           
                        </select>
                        <!--end::Select-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-10 pb-0 px-5">
                    <!--begin::Chart-->
                    <div id="kt_charts_widget_36" class="min-h-auto w-100 ps-4 pe-6" style="height: 300px"></div>
                    <!--end::Chart-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Graph-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-xxl-6">
            <!--begin::List widget 9-->
            <div class="card card-flush h-xl-100">
                <!--begin::Header-->
                <div class="card-header py-7">
                    <!--begin::Statistics-->
                    <div class="m-0">   
                        <h3 class="fw-bolder mb-1">Gráfico con Tipos de solicitudes más demandadas</h3>
                    </div>
                    <!--end::Statistics-->
                    <!--begin::Toolbar-->
                    <div class="card-toolbar">   
                        <div class="position-relative d-flex align-items-center">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                            <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="black"></path>
                                    <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="black"></path>
                                    <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="black"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Datepicker-->
                            <div class='input-group' id='kt_daterangepicker_6'>
                                <input type='text' class="form-control" id="periodo2" name="periodo2" readonly placeholder="Seleccione período" style=" width: 220px; "/>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                </div>
                            </div>
                            <!--end::Datepicker-->
                        </div>         
                    </div>
                    <!--end::Toolbar-->             
                </div>
                <!--end::Header-->        
                <!--begin::Body-->
                <div class="card-body card-body d-flex justify-content-between flex-column pt-3">
                    <div id="kt_charts_widget_6"></div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::List widget 9-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</div>
<!--end::Post-->
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dashboard.js?v=') }}<?php echo rand(); ?>"></script>
@endsection
