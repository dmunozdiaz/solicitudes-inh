@extends('layout.app')

@section('content')

<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class=" container ">
            <!--begin::Profile Personal Information-->
            <div class="d-flex flex-row">
                <!--begin::Aside-->
                @include('micuenta.menu')
                <!--end::Aside-->
                <!--begin::Content-->
                <div class="flex-row-fluid ml-lg-8">
                    <!--begin::Card-->
                    <div class="card card-custom card-stretch">

                        <!--begin::Form-->
                        <form class="form">
                            <!--begin::Body-->
                            <div class="card-body">
                                <div class="row">
                                    <label class="col-xl-3"></label>
                                    <div class="col-lg-9 col-xl-6">
                                        <h5 class="font-weight-bold mb-6">Información de Usuaria(o)</h5>
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Nombre</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{$user->nombres}}" disabled="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Apellido Paterno</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{$user->apellido_paterno}}" disabled="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Apellido Materno</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{$user->apellido_materno}}" disabled="">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Rut</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{$user->rut}}" disabled="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Correo Electrónico</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <div class="input-group input-group-lg input-group-solid">
                                            
                                            <input type="text" class="form-control form-control-lg form-control-solid" value="{{$user->email}}" disabled="">
                                        </div>
                                        <!--<span class="form-text text-muted">We'll never share your email with anyone else.</span>-->
                                    </div>
                                </div>
                                
                                
                            </div>
                            <!--end::Body-->
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Profile Personal Information-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
@endsection

{{-- Scripts Section --}}
@section('scripts')


@endsection