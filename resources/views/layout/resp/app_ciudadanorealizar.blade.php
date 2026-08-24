
<!DOCTYPE html>

<html lang="es_CL">
	<!--begin::Head-->
	<head>
		<title>Solicitudes Ciudadanas - Municipalidad de Temuco</title>
		{{-- | @yield('title', $page_title ?? '') --}}
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta charset="utf-8" />
		<meta name="description" content="Solicitudes Ciudadanas - Municipalidad de Temuco" />
		<meta name="keywords" content="temuco, TEMUCO, Consultas en Línea" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="es_CL" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="Solicitudes Ciudadanas - Municipalidad de Temuco" />
		<meta property="og:url" content="https://solicitudes-tco-dev.lazos.cl" />
		<meta property="og:site_name" content="Solicitudes Ciudadanas - Municipalidad de Temuco" />
		<link rel="canonical" href="https://solicitudes-tco-dev.lazos.cl" />
		<link rel="shortcut icon" href="/assets/media/logos/gobcl-favicon.ico" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->

        @yield('styles')

	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">
				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header mh-85px" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<!--begin::Container-->
						<div class="container-xxl d-flex flex-grow-1 flex-stack">
							<!--begin::Header Logo-->
							<div class="d-flex align-items-center me-5">
								<!--begin::Heaeder menu toggle-->
								<div class="d-lg-none btn btn-icon btn-active-color-primary w-30px h-30px ms-n2 me-3" id="kt_header_menu_toggle">
									<!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
									<span class="svg-icon svg-icon-1">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
											<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
										</svg>
									</span>
									<!--end::Svg Icon-->
								</div>
								<!--end::Heaeder menu toggle-->
								<a href="javascrip:;">
									<img alt="Logo" src="/assets/media/logos/Logo-mun-tco-w500stxt.png" class="h-40px h-lg-60px" />
								</a>
								<h3 class="fs-2x line-height-lg mb-5">
									<span class="fw-bold"></span>
									
								</h3>
							</div>
							<!--end::Header Logo-->
							<!--begin::Topbar-->
							<div class="d-flex align-items-center">
								<!--begin::Topbar-->
								<div class="d-flex align-items-center flex-shrink-0">
									<!--begin::User-->
									<!--begin::User Clave Única-->
									@isset(Auth::user()->name) 
									<div class="d-flex align-items-center ms-lg-5" id="kt_header_user_menu_toggle">
										<!--begin::User info-->
										<div class="btn btn-active-light d-flex align-items-center bg-hover-light py-2 px-2 px-md-3" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
											<!--begin::Name-->
											<div class="d-none d-md-flex flex-column align-items-end justify-content-center me-2">
												<span class="text-dark fs-base fw-bolder lh-1">   
													{{Auth::user()->name }}
												</span>
											</div>
											<!--end::Name-->
											<!--begin::Symbol-->
											<div class="symbol symbol-30px symbol-md-40px">
												<a href="/auth/claveunica/logout"> 
													<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Sign-out.svg-->
														<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
															<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																<rect x="0" y="0" width="24" height="24"/>
																<path d="M14.0069431,7.00607258 C13.4546584,7.00607258 13.0069431,6.55855153 13.0069431,6.00650634 C13.0069431,5.45446114 13.4546584,5.00694009 14.0069431,5.00694009 L15.0069431,5.00694009 C17.2160821,5.00694009 19.0069431,6.7970243 19.0069431,9.00520507 L19.0069431,15.001735 C19.0069431,17.2099158 17.2160821,19 15.0069431,19 L3.00694311,19 C0.797804106,19 -0.993056895,17.2099158 -0.993056895,15.001735 L-0.993056895,8.99826498 C-0.993056895,6.7900842 0.797804106,5 3.00694311,5 L4.00694793,5 C4.55923268,5 5.00694793,5.44752105 5.00694793,5.99956624 C5.00694793,6.55161144 4.55923268,6.99913249 4.00694793,6.99913249 L3.00694311,6.99913249 C1.90237361,6.99913249 1.00694311,7.89417459 1.00694311,8.99826498 L1.00694311,15.001735 C1.00694311,16.1058254 1.90237361,17.0008675 3.00694311,17.0008675 L15.0069431,17.0008675 C16.1115126,17.0008675 17.0069431,16.1058254 17.0069431,15.001735 L17.0069431,9.00520507 C17.0069431,7.90111468 16.1115126,7.00607258 15.0069431,7.00607258 L14.0069431,7.00607258 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.006943, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-9.006943, -12.000000) "/>
																<rect fill="#000000" opacity="0.3" transform="translate(14.000000, 12.000000) rotate(-270.000000) translate(-14.000000, -12.000000) " x="13" y="6" width="2" height="12" rx="1"/>
																<path d="M21.7928932,9.79289322 C22.1834175,9.40236893 22.8165825,9.40236893 23.2071068,9.79289322 C23.5976311,10.1834175 23.5976311,10.8165825 23.2071068,11.2071068 L20.2071068,14.2071068 C19.8165825,14.5976311 19.1834175,14.5976311 18.7928932,14.2071068 L15.7928932,11.2071068 C15.4023689,10.8165825 15.4023689,10.1834175 15.7928932,9.79289322 C16.1834175,9.40236893 16.8165825,9.40236893 17.2071068,9.79289322 L19.5,12.0857864 L21.7928932,9.79289322 Z" fill="#000000" fill-rule="nonzero" transform="translate(19.500000, 12.000000) rotate(-90.000000) translate(-19.500000, -12.000000) "/>
															</g>
														</svg><!--end::Svg Icon-->
													</span>
												</a>
												
											</div>
											<!--end::Symbol-->
										</div>
										<!--end::User info-->
									</div>
									@endisset 
									<!--end::User Clave Única-->
									<!--end::User -->
									<!--begin::Sidebar Toggler-->
									<!--end::Sidebar Toggler-->
								</div>
								<!--end::Topbar-->
							</div>
							<!--end::Topbar-->
						</div>
						<!--end::Container-->
						<!--begin::Separator-->
						<div class="separator"></div>
						<!--end::Separator-->
						<!--begin::Container-->

						<!--end::Container-->						
					</div>
					<!--end::Header-->

					@yield('formulario')


					<!--begin::Toolbar-->
					<div class="toolbar py-5 py-lg-5" id="kt_toolbar">
						<!--begin::Toolbar Ciudadano-->
						<!--begin::Container-->
						<div id="kt_toolbar_container" class="container-xxl py-5">
							<!--begin::Row-->
							<div class="row gy-0 gx-10">
								<div class="col-xl-8">
									<!--begin::Engage widget 2-->
									<div class="card card-xl-stretch bg-body border-0 mb-5 mb-xl-0">
										<!--begin::Body-->
										<div class="card-body d-flex flex-column flex-lg-row flex-stack p-lg-7">
											<!--begin::Info-->
											<div class="d-flex flex-column justify-content-center align-items-center align-items-lg-start me-10 text-center text-lg-start">
												<!--begin::Title-->
												<h3 class="fs-2x line-height-lg mb-5">
													<span class="fw-bold">Solicitudes Ciudadanas</span>
													<br />
													<span class="fw-bolder">Municipalidad de Temuco</span>
												</h3>
												<!--end::Title-->
												<div class="fs-4 text-muted mb-7">
													En el cuadro inferior de esta página encontrará el listado de servicios que el Municipio coloca a su disposición.  Para cada servicio se indica el Área y la Dirección al cual está asociado, para orientar mejor su elección.<br>

															Paso 1. Debe buscar el que más se ajuste a su necesidad.<br>
															Paso 2. Presionar el botón "Realizar Solicitud".<br>
															Paso 3. Completar el formulario correspondiente.<br>
												</div>
												<!--<a href='#' class="btn btn-success fw-bold px-6 py-3" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Create an Store</a>-->
											</div>
											<!--end::Info-->
											<!--begin::Illustration-->
											<!--<img src="assets/media/illustrations/sketchy-1/11.png" alt="" class="mw-200px mw-lg-350px mt-lg-n10" />-->
											<!--end::Illustration-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Engage widget 2-->
								</div>
								<div class="col-xl-4">
									<!--begin::Mixed Widget 16-->
									<div class="card card-xl-stretch bg-body border-0">
										<!--begin::Body-->
										<div class="card-body d-flex flex-grow-1 flex-column flex-center">
											<!--begin::Heading-->
											<div class="d-flex flex-stack">
												<!--begin::Title-->
												<h4 class="fw-bolder text-gray-800 m-0 mb-5">Solicitudes Realizadas</h4>
												<!--end::Title-->
											</div>
											<!--end::Heading-->
											<!--begin::Content-->
											<div class="text-center w-100">
												<!--begin::Text-->
												<p class="fw-bold fs-4 text-gray-400 mb-7 px-5">Para revisar el estado de las solicitudes realizadas, haga clic en el siguiente botón.</p>
												<!--end::Text-->
												<!--begin::Action-->
												<div class="m-0">
													<a href="{{route('solicitudes-realizadas')}}" class="btn btn-success fw-bold">Revisar Solicitudes</a>
												</div>
												<!--ed::Action-->
											</div>
											<!--end::Content-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Mixed Widget 16-->
								</div>
							</div>
							<!--end::Row-->
						</div>
						<!--end::Container-->
						<!--end::Toolbar Ciudadano-->
					</div>
					<!--end::Toolbar-->

					<!--begin::Container-->
					<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
						<!--begin::Post-->
            @yield('content')
						<!--end::Post-->
					</div>
					<!--end::Container-->

					<!--begin::Footer-->
					@include('layout.partials.footer_ciudadano')
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->

		<!--begin::Scrolltop-->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
			<span class="svg-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
					<path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
				</svg>
			</span>
			<!--end::Svg Icon-->
		</div>
		<!--end::Scrolltop-->

		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="/assets/plugins/global/plugins.bundle.js"></script>
		<script src="/assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Vendors Javascript(used by this page)-->
		<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
		<!--end::Page Vendors Javascript-->
		<!--begin::Page Custom Javascript(used by this page)-->
        @yield('scripts')
    <!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>