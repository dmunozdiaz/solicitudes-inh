{{--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4 & Angular 8
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
 --}}
 <!DOCTYPE html>
 <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{ Metronic::printAttrs('html') }}
     {{ Metronic::printClasses('html') }}>
 
 <head>
     <meta charset="utf-8" />
 
     {{-- Title Section --}}
     <title>{{ config('app.name') }} | @yield('title', $page_title ?? '')</title>
 
     {{-- Meta Data --}}
     <meta name="description" content="@yield('page_description', $page_description ?? '')" />
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
 
     {{-- Favicon --}}
     <link rel="shortcut icon" href="{{ asset('media/logos/favicon-ua.png') }}" />
 
     {{-- Fonts --}}
     {{ Metronic::getGoogleFontsInclude() }}
     <link href="{{ asset('css/pages/login/login-1.css') }}" rel="stylesheet" type="text/css" />
 
     {{-- Global Theme Styles (used by all pages) --}}
     @foreach(config('layout.resources.css') as $style)
         <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($style)) : asset($style) }}" rel="stylesheet"
               type="text/css" />
     @endforeach
 
     {{-- Layout Themes (used by all pages) --}}
     @foreach (Metronic::initThemes() as $theme)
         <link href="{{ config('layout.self.rtl') ? asset(Metronic::rtlCssPath($theme)) : asset($theme) }}" rel="stylesheet"
               type="text/css" />
     @endforeach
 
     {{-- Includable CSS --}}
     @yield('styles')
 </head>
 
 <body {{ Metronic::printAttrs('body') }} {{ Metronic::printClasses('body') }}>
 
 <!--begin::Main-->
 <div class="d-flex flex-column flex-root">
     <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
         <div class="login-aside d-flex flex-column flex-row-auto" style="background: linear-gradient(to bottom, #02c8e2 0%, #02c8e2 15%, #8a56f6 60%, #8a56f6 100%);">
             <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <a href="#" class="text-center mb-10"><img src="{{asset('media/logos/logoUAutonoma.png')}}" class="max-h-150px" alt=""></a>


                <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg" style="color: #FFF;">Universidad Autonoma de Chile</h3>
             </div>
 
             <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url({{asset('media/custom/emprendedoras.png')}}); background-size: contain;"></div>
         </div>
 
         <div
             class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
             <div class="d-flex flex-column-fluid flex-center">
                 <div class="login-form login-signin">
                    <form class="forget-form2" action="javascript:;" method="post">
                       
                        <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Confirmación</h3>
                        <span class="text-muted font-weight-bold font-size-h4">¡Atención!</span>   
                        <div class="note note-info">

                            <p>Un correo electrónico que contiene un enlace para restablecer la contraseña ha sido enviado a la dirección almacenada en su cuenta. Si usted no recibe el mensaje significa que su cuenta o dirección de correo electrónico no fue encontrada.</p>
                        </div>

                         <div class="form-actions">
                            <a href="/" id="back-btn2" class="btn btn-secondary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Volver</a>
                            
                        </div>
                        <div class="clearfix"></div>
</form>
                 </div>
             </div>
 
             <div class="d-flex justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0"></div>
         </div>
     </div>
 </div>
 
 {{-- Global Config (global config for global JS scripts) --}}
 <script>
     var KTAppSettings = {!! json_encode(config('layout.js'), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!};
 </script>
 
 <script src="{{ asset("js/login.js") }}"></script>
 
 {{-- Global Theme JS Bundle (used by all pages)  --}}
 @foreach(config('layout.resources.js') as $script)
     <script src="{{ asset($script) }}" type="text/javascript"></script>
 @endforeach
 
 {{-- Includable JS --}}
 @yield('scripts')
 
 </body>
 
 </html>
 