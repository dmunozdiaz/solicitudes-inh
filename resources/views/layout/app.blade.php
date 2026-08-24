
<!DOCTYPE html>

<html lang="es_CL">
	<!--begin::Head-->
	<head>
		<title>Solicitudes Ciudadanas - Municipalidad de Temuco</title>
		{{-- | @yield('title', $page_title ?? '') --}}
		<meta http-equiv="Expires" content="0">
	  <meta http-equiv="Last-Modified" content="0">
	  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
	  <meta http-equiv="Pragma" content="no-cache">
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
					<div id="kt_header" class="header" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
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
												<a href="javascript:;" onclick="logout()" > 
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
									<!--begin::User Municipalidad-->
									@isset(Auth::user()->nombres)
									<div class="d-flex align-items-center ms-3 ms-lg-4" id="kt_header_user_menu_toggle">
										<!--begin::Menu- wrapper-->
										<!--begin::User icon(remove this button to use user avatar as menu toggle)-->
										<div class="btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline btn-outline-secondary w-30px h-30px w-lg-40px h-lg-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
											<!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
											<span class="svg-icon svg-icon-1">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="black" />
													<rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="black" />
												</svg>
											</span>
											<!--end::Svg Icon-->
										</div>
										<!--end::User icon-->
										<!--begin::Menu-->
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
											<!--begin::Menu item-->
											<div class="menu-item px-3">
												<div class="menu-content d-flex align-items-center px-3">
													<!--begin::Username-->
													<div class="d-flex flex-column">
														<div class="fw-bolder d-flex align-items-center fs-5">{{Auth::user()->nombres}}
														<span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2"></span></div>
														<a href="javascrip:;" class="fw-bold text-muted text-hover-primary fs-7">{{Auth::user()->email}}</a>
													</div>
													<!--end::Username-->
												</div>
											</div>
											<!--end::Menu item-->
											<!--begin::Menu separator-->
											<div class="separator my-2"></div>
											<!--end::Menu separator-->
											<!--begin::Menu item-->
										<!--	<div class="menu-item px-5">
												<a href="/micuenta" class="menu-link px-5">Mi Cuenta</a>
											</div>-->
											<!--end::Menu item-->
											<!--begin::Menu item-->
											<div class="menu-item px-5">
												<a href="javascript:;" onclick="logout()" class="menu-link px-5">Cerrar Sesión</a>
												
											</div>
											<!--end::Menu item-->
										</div>
										<!--end::Menu-->
										<!--end::Menu wrapper-->
									</div>
									@endisset
									<!--begin::User Municipalidad-->
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
						<div class="header-menu-container container-xxl d-flex flex-stack h-lg-75px" id="kt_header_nav">
							<!--begin::Menu wrapper-->
							<div class="header-menu flex-column flex-lg-row" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
								<!--begin::Menu-->
								<div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch flex-grow-1" id="#kt_header_menu" data-kt-menu="true">
									@if (Auth::user()->hasAnyRole(['supervisor']) == true)
										<div class="menu-item @if(Request::is('dashboard') || Request::is('dashboard/*')) here @endif me-lg-1">
											<a class="menu-link @if(Request::is('dashboard') || Request::is('dashboard/*')) active @endif py-3" href="/dashboard">
												<span class="svg-icon svg-icon-muted svg-icon-2hx"><!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Design/Layers.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<polygon points="0 0 24 0 24 24 0 24"></polygon>
														<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero"></path>
														<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3"></path>
													</g>
												</svg><!--end::Svg Icon--></span>
												<span class="menu-title">Dashboard</span>
												<span class="menu-arrow d-lg-none"></span>
											</a>
										</div>
									@endif

									
									<div class="menu-item @if(Request::is('mistareas') || Request::is('mistareas/*')) here @endif  me-lg-1">
										<a class="menu-link @if(Request::is('mistareas') || Request::is('mistareas/*')) active @endif py-3" href="/mistareas">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: assets/media/icons/duotune/abstract/abs027.svg-->
												<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black"/>
												<path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black"/>
												</svg></span>
												<!--end::Svg Icon-->
											</span>
											<span class="menu-title">Mis Tareas</span>
											<span class="menu-arrow d-lg-none"></span>
										</a>
									</div>

									@if (Auth::user()->hasAnyRole(['supervisor']) == true)
										<div class="menu-item @if(Request::is('supervision') || Request::is('supervision/*')) here @endif me-lg-1">
											<a class="menu-link @if(Request::is('supervision') || Request::is('supervision/*')) active @endif py-3" href="/supervision">
												<span class="menu-icon">
													<!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen004.svg-->
													<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/>
													<path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/>
													</svg></span>
													<!--end::Svg Icon-->
												</span>
												<span class="menu-title">Supervisión</span>
												<span class="menu-arrow d-lg-none"></span>
											</a>
										</div>
									@endif

									@if (Auth::user()->hasAnyRole(['supervisor']) == true)
										<div class="menu-item @if(Request::is('ingreso-solicitudes') || Request::is('ingreso-solicitudes/*')) here @endif me-lg-1">
											<a class="menu-link @if(Request::is('ingreso-solicitudes') || Request::is('ingreso-solicitudes/*')) active @endif py-3" href="/ingreso-solicitudes">
												<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:wamp64wwwkeenthemes86	hemesmetronic	hemehtmldemo1dist/../src/media/svg/iconsCommunicationWrite.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect> <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "></path>    <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path></g></svg> </span>
												<span class="menu-title">Ingreso de Solicitudes</span>
												<span class="menu-arrow d-lg-none"></span>
											</a>
										</div>
									@endif
									
									
									<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
										<span class="menu-link  @if(Request::is('reportes') || Request::is('reportes/*')) active @endif py-3">
											<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Files/Cloud-download.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<polygon points="0 0 24 0 24 24 0 24"/>
													<path d="M5.74714567,13.0425758 C4.09410362,11.9740356 3,10.1147886 3,8 C3,4.6862915 5.6862915,2 9,2 C11.7957591,2 14.1449096,3.91215918 14.8109738,6.5 L17.25,6.5 C19.3210678,6.5 21,8.17893219 21,10.25 C21,12.3210678 19.3210678,14 17.25,14 L8.25,14 C7.28817895,14 6.41093178,13.6378962 5.74714567,13.0425758 Z" fill="#000000" opacity="0.3"/>
													<path d="M11.1288761,15.7336977 L11.1288761,17.6901712 L9.12120481,17.6901712 C8.84506244,17.6901712 8.62120481,17.9140288 8.62120481,18.1901712 L8.62120481,19.2134699 C8.62120481,19.4896123 8.84506244,19.7134699 9.12120481,19.7134699 L11.1288761,19.7134699 L11.1288761,21.6699434 C11.1288761,21.9460858 11.3527337,22.1699434 11.6288761,22.1699434 C11.7471877,22.1699434 11.8616664,22.1279896 11.951961,22.0515402 L15.4576222,19.0834174 C15.6683723,18.9049825 15.6945689,18.5894857 15.5161341,18.3787356 C15.4982803,18.3576485 15.4787093,18.3380775 15.4576222,18.3202237 L11.951961,15.3521009 C11.7412109,15.173666 11.4257142,15.1998627 11.2472793,15.4106128 C11.1708299,15.5009075 11.1288761,15.6153861 11.1288761,15.7336977 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.959697, 18.661508) rotate(-270.000000) translate(-11.959697, -18.661508) "/>
												</g>
											</svg><!--end::Svg Icon--></span>
											<span class="menu-title">Reportes</span>
											<span class="menu-arrow d-lg-none"></span>
										</span>
										<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
											@if (Auth::user()->hasAnyRole(['admin']) == true)
											<div class="menu-item menu-lg-down-accordion">
												<a class="menu-link @if(Request::is('reportes/reporte-general') || Request::is('reportes/*')) active @endif  py-3" href="/reportes/reporte-general">
													<span class="menu-icon">
														<!--begin::Svg Icon | path: icons/duotune/general/gen051.svg-->
														<i class="icon-xl la la-file-excel"></i>
														<!--end::Svg Icon-->
													</span>
													<span class="menu-title">Reporte General</span>
													<span class="menu-arrow d-lg-none"></span>
												</a>
											</div>
											@endif
											
											@if (Auth::user()->hasAnyRole(['supervisor']) == true)
											
											<div class="menu-item menu-lg-down-accordion">
												<a class="menu-link @if(Request::is('reportes/reporte-especifico') || Request::is('reportes/*')) active @endif  py-3" href="/reportes/reporte-especifico">
													<span class="menu-icon">
														<!--begin::Svg Icon | path: icons/duotune/general/gen051.svg-->
														<i class="icon-xl la la-file-excel"></i>
														<!--end::Svg Icon-->
													</span>
													<span class="menu-title">Reporte específico para áreas/departamentos</span>
													<span class="menu-arrow d-lg-none"></span>
												</a>
											</div>
											@endif
										</div>
									</div>

									@if (Auth::user()->hasAnyRole(['admin']) == true)
									<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
										<span class="menu-link  @if(Request::is('administracion') || Request::is('administracion/*')) active @endif py-3">
											<span class="menu-icon">
												<!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen047.svg-->
												<span class="svg-icon svg-icon-muted svg-icon-2hx"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black"/>
												<path d="M15.8054 11.639C15.6757 11.5093 15.5184 11.4445 15.3331 11.4445H15.111V10.1111C15.111 9.25927 14.8055 8.52784 14.1944 7.91672C13.5833 7.30557 12.8519 7 12 7C11.148 7 10.4165 7.30557 9.80547 7.9167C9.19432 8.52784 8.88885 9.25924 8.88885 10.1111V11.4445H8.66665C8.48153 11.4445 8.32408 11.5093 8.19444 11.639C8.0648 11.7685 8 11.926 8 12.1112V16.1113C8 16.2964 8.06482 16.4539 8.19444 16.5835C8.32408 16.7131 8.48153 16.7779 8.66665 16.7779H15.3333C15.5185 16.7779 15.6759 16.7131 15.8056 16.5835C15.9351 16.4539 16 16.2964 16 16.1113V12.1112C16.0001 11.926 15.9351 11.7686 15.8054 11.639ZM13.7777 11.4445H10.2222V10.1111C10.2222 9.6204 10.3958 9.20138 10.7431 8.85421C11.0903 8.507 11.5093 8.33343 12 8.33343C12.4909 8.33343 12.9097 8.50697 13.257 8.85421C13.6041 9.20135 13.7777 9.6204 13.7777 10.1111V11.4445Z" fill="black"/>
												</svg></span>
												<!--end::Svg Icon-->
											</span>
											<span class="menu-title">Administración</span>
											<span class="menu-arrow d-lg-none"></span>
										</span>
										<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
											<div class="menu-item menu-lg-down-accordion">
												<a class="menu-link @if(Request::is('administracion/usuarios') || Request::is('usuarios/*')) active @endif  py-3" href="/administracion/usuarios">
													<span class="menu-icon">
														<!--begin::Svg Icon | path: icons/duotune/general/gen051.svg-->
														<span class="svg-icon icon-size-2hx">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																<path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="black" />
																<path d="M14.854 11.321C14.7568 11.2282 14.6388 11.1818 14.4998 11.1818H14.3333V10.2272C14.3333 9.61741 14.1041 9.09378 13.6458 8.65628C13.1875 8.21876 12.639 8 12 8C11.361 8 10.8124 8.21876 10.3541 8.65626C9.89574 9.09378 9.66663 9.61739 9.66663 10.2272V11.1818H9.49999C9.36115 11.1818 9.24306 11.2282 9.14583 11.321C9.0486 11.4138 9 11.5265 9 11.6591V14.5227C9 14.6553 9.04862 14.768 9.14583 14.8609C9.24306 14.9536 9.36115 15 9.49999 15H14.5C14.6389 15 14.7569 14.9536 14.8542 14.8609C14.9513 14.768 15 14.6553 15 14.5227V11.6591C15.0001 11.5265 14.9513 11.4138 14.854 11.321ZM13.3333 11.1818H10.6666V10.2272C10.6666 9.87594 10.7969 9.57597 11.0573 9.32743C11.3177 9.07886 11.6319 8.9546 12 8.9546C12.3681 8.9546 12.6823 9.07884 12.9427 9.32743C13.2031 9.57595 13.3333 9.87594 13.3333 10.2272V11.1818Z" fill="black" />
															</svg>
														</span>
														<!--end::Svg Icon-->
													</span>
													<span class="menu-title">Gestión de usuarios</span>
													<span class="menu-arrow d-lg-none"></span>
												</a>
											</div>
										</div>
									</div>
									@endif	

									
								</div>
								<!--end::Menu-->
							</div>
							<!--end::Menu wrapper-->
						</div>
						<!--end::Container-->						
					</div>
					<!--end::Header-->

					@yield('formulario')


					<!--begin::Toolbar-->
					<div class="toolbar py-5 py-lg-5" id="kt_toolbar">
						<!--begin::Toolbar Usuario Municipal-->
						<!--begin::Container-->
						@yield('subheader_2')

						
						<!--end::Container-->
						<!--end::Toolbar Usuario Municipal-->
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
					@include('layout.partials.footer')
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

		<script>
			@if (Auth::user()->userPublic())
				function logout() {
					// llamada al endpoint de logout
					window.location.href = "{{ env('CLAVEUNICA_URL_LOGOUT') }}";
	
					// redireccion al cabo de 1 segundo a un handler de logout en la aplicación integradora
					setTimeout(function() {
						window.location.href = "{{ env('APP_URL') }}/auth/claveunica/logout";
					}, 1000);
				}
			@else
				function logout() {
					// llamada al endpoint de logout
					window.location.href = "{{ env('CLAVEUNICA_URL_LOGOUT') }}";
	
					// redireccion al cabo de 1 segundo a un handler de logout en la aplicación integradora
					setTimeout(function() {
						window.location.href = "{{ env('APP_URL') }}/municipalidad/auth/claveunica/logout";
					}, 1000);
				}
			@endif
		</script>
	</body>
	<!--end::Body-->
</html>