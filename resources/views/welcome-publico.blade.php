<!DOCTYPE html>

<html lang="es">
<!--begin::Head-->

<head>
    <title>Sobre Nosotros - Instituto Nacional de Hidráulica (INH)</title>
    <meta charset="utf-8" />
    <meta name="description" content="Sobre Nosotros - Instituto Nacional de Hidráulica (INH)" />
    <meta name="keywords" content="Instituto Nacional de Hidráulica, INH, sobre nosotros" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="es_CL" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Sobre Nosotros - Instituto Nacional de Hidráulica (INH)" />
    <meta property="og:url" content="https://inh.gob.cl/" />
    <meta property="og:site_name" content="Sobre Nosotros - Instituto Nacional de Hidráulica (INH)" />
    <link rel="canonical" href="https://inh.gob.cl/" />
    <link rel="shortcut icon" href="/assets/media/logos/gobcl-favicon.ico" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('css/cu.min.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="bg-body">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Sign-up -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
            <div class="d-flex flex-column flex-lg-row-auto w-xl-600px positon-xl-relative"
                style="background-color: #fafafa">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
                    <!--begin::Content-->
                    <div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
                        <!--begin::Logo-->
                        <a href="#" class="py-9 mb-5">
                            <img alt="Logo" src="https://inh.gob.cl/wp-content/uploads/2025/11/INH_logo_footer_final-150x150.png"
                            class="h-175px" />
                        </a>
                        <!--end::Logo-->
                        <!--begin::Title-->
                        <h1 class="fw-bolder fs-2qx pb-5 pb-md-10" style="color: rgb(00,113,206);">Instituto Nacional de Hidráulica (INH) <br /></h1>
                        <!--end::Title-->
                        <!--begin::Description-->
                        <p class="fw-bold fs-2" style="color: rgb(00,113,206);">Información y Atención Ciudadana
                            <br />
                        </p>
                        <!--end::Description-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Illustration-->
                    <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px"
                        style=""></div>
                    <!--end::Illustration-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid py-10">
                <!--begin::Content-->
                <div class="d-flex flex-center flex-column flex-column-fluid">
                    <!--begin::Wrapper-->
                    <div class="w-lg-600px p-10 p-lg-15 mx-auto">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form">
                            <!--begin::Heading-->
                            <div class="mb-10 text-center">
                                <!--begin::Title-->
                                <h1 class="text-dark mb-3">Sistema de Información y Atención Ciudadana</h1>
                                <!--end::Title-->
                                <!--begin::Link-->
                                <!-- <div class="text-gray-400 fw-bold fs-4">Municipalidad de Temuco</div> -->
                                <div class="text-gray-400 fs-4 text-start">Estimado ciudadano, utilice esta NUEVA
                                    plataforma, para ingresar sus requerimientos al Municipio.<br><br />
                                    ¿Cómo se usa?<br /><br />
                                    <ul>
                                        <li>Digite su clave única.</li>
                                        <li>Seleccione un área y servicio específico que el Municipio coloca a su
                                            disposición y que se ajuste a su necesidad.</li>
                                        <li>Ingrese los datos de vuestro requerimiento, describiéndolo con detalle,
                                            puede también agregar imágenes o archivos adjuntos y vuestro mail.</li>
                                        <li>Ud. recibirá inmediatamente un <b><u>NUMERO DE TICKET.</u></b></li>
                                        <li>Podrá realizar un seguimiento y trazabilidad por esta misma página. A la vez
                                            será informado automáticamente a su mail de los pasos que realiza su
                                            solicitud al interior del Municipio.</li>
                                    </ul>
                                </div>
                                <div class="text-gray-400 fw-bold fs-4">
                                    <a href="javascript:;" class="link-primary fw-bolder"></a>
                                </div>
                                <!--end::Link-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Action-->
                            <div class="text-center">
                                <a class="btn btn-flex flex-center btn-cu btn-l btn-color-estandar btn-lg w-100 mb-5"
                                    href="{{ url('auth/claveunica') }}"
                                    title="Este es el botón Iniciar sesión de Clave Única">
                                    <span class="cl-claveunica"></span>
                                    <span class="texto">Iniciar sesión</span>
                                </a>
                            </div>
                            <!--end::Action-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Content-->

            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-up-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "/assets/";
    </script>
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('assets/js/custom/authentication/sign-up/general.js') }}"></script>
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
