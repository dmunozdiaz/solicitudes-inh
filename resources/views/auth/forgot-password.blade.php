



                    @extends('layout.exterior')

                    @section('content')
                    
                    @if (session('status'))
                                                        <form class="forget-form2" action="javascript:;" method="post">
                                                            <div class="pb-13 pt-lg-0 pt-5">
                                                                <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Expediente de Rendición de Aporte Institucional para la Gratuidad</h3>
                                                            </div>
                                                                    
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
                                            @else
                                                <form id="frm-forgot-password" action="{{ route('password.email.custom') }}" method="POST">
                                                    @csrf
                                                    <!--begin::Title-->
                                                    <div class="pb-13 pt-lg-0 pt-5">
                                                        <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">¿Olvidó su
                                                            contraseña?</h3>
                                                        <span class="text-muted font-weight-bold font-size-h4">Introduce tu correo electrónico
                                                            para restablecer tu contraseña</span>
                                                    </div>
                                                    <!--begin::Title-->
                                                    <!--begin::Form group-->
                                                    <div id="error-catpcha" class="alert alert-danger hiden">
                                                
                                                        Debe ingresar el Catpcha.
                                                    </div>  
                                                    
                                                    <div class="form-group">
                                                        <input id="email" type="email" class="form-control " name="email" value="" required=""
                                                            autocomplete="email" autofocus="" placeholder="Email">
                                                            @error('email')
                                                            <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                    </div>
                                                    <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                                        <label class="col-md-4 control-label"></label>
                                                        <div class="col-md-12">
                                                            <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}" data-callback="enableBtn"></div>
                                                            @if ($errors->has('g-recaptcha-response'))
                                                            <span class="help-block text-danger">
                                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <!--end::Form group-->
                                                    <!--begin::Action-->
                                                    <div class="pb-lg-0 pb-5">
                                                        <button type="button"
                                                            class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3" id="btn_enviar_email" disabled="true">Enviar</button>
                                                        <a href="/"
                                                            class="btn btn-secondary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Cancelar</a>
                                                    </div>
                                                    <!--end::Action-->
                                                </form>
                                            @endif

                    @endsection
                    
                    @section('scripts')

                    <script>
       
                    function enableBtn(){
                        document.getElementById("btn_enviar_email").disabled = false;
                        }
                                
                    </script>
                    <script src="{{ asset("js/login/forgot-password.js") }}"></script>
                    @endsection