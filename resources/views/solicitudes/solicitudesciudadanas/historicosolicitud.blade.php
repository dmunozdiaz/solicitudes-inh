<form class="form">
    <div class="row mb-8">
        <div class="col-lg-12">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-chat-1 text-primary"></i>
                        </span>
                        <h3 class="card-label">Información Solicitud:</h3>
                    </div>
                    <div class="card-toolbar">
                        Estado: @if ($solicitud->estado == 1)
                            <span class="badge badge-light-danger fw-bolder fs-8 px-2 py-1 ms-2">Ingresada</span>
                        @elseif ($solicitud->estado == 3)    
                             <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">En proceso</span>
                        @else
                            <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Respondida</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Nro Solicitud:</label>
                        <div class="col-lg-6">
                            <p class="form-control-plaintext text-muted">{{ $solicitud->app_number }}</p>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Fecha y hora:</label>
                        <div class="col-lg-6">
                            <p class="form-control-plaintext text-muted">
                                {{ \Carbon\Carbon::parse($solicitud->created_at,'America/Santiago')->formatLocalized('%d-%m-%Y %H:%M') }}
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Solicitante:</label>
                        <div class="col-lg-6">
                            <p class="form-control-plaintext text-muted"> @isset(Auth::user()->name)
                                    {{ Auth::user()->name }} {{ Auth::user()->lastname }}
                                @endisset
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">RUT:</label>
                        <div class="col-lg-6">
                            <p class="form-control-plaintext text-muted">
                                @isset(Auth::user()->rut)
                                    {{ Auth::user()->rut }} - {{ Auth::user()->dv }}
                                @endisset
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Email:</label>
                        <div class="col-lg-6">
                            <p class="form-control-plaintext text-muted"> {{ $solicitud->email }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Teléfono de contacto:</label>
                        <div class="col-lg-6">
                            <p class="form-control-plaintext text-muted">{{ $solicitud->telefono }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Descripción:</label>
                        <div class="col-lg-6">
                            <p class="form-control-plaintext text-muted"> {{ $solicitud->descripcion }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Archivos Adjuntos:</label>
                        <div class="col-lg-6">

                            @if (empty($documentos) == false)
                                <div class="list-group">
                                    @foreach ($documentos as $documento)
                                        <a href="/download-file-public/{{ $solicitud->app_uid }}/{{ $documento->iddocument }}"
                                            class="list-group-item">
                                            <i class="pull-right text-muted la la-download"></i>
                                            <i class="la la-paperclip"></i>
                                            {{ $documento->filename }}
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="form-control-plaintext text-muted"> Sin adjuntos</p>
                            @endif



                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div> 
     @if($historial->isNotEmpty())
     <div class="row">
        <div class="col-lg-12">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-chat-1 text-primary"></i>
                        </span>
                        <h3 class="card-label">Cambios de estados de la solicitud:</h3>
                    </div>

                </div>
                <div class="card-body">
                    @foreach ($historial as $histo)
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label "><b> {{ strtoupper($histo->estado) }} </b> </label>
                            
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Fecha y hora:</label>
                            <div class="col-lg-6">
                                <p class="form-control-plaintext text-muted">
                                    {{ \Carbon\Carbon::parse($histo->created_at)->formatLocalized('%d-%m-%Y %H:%M') }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Comentarios:</label>
                            <div class="col-lg-6">
                                <p class="form-control-plaintext text-muted">
                                    {{ $histo->descripcion }}</p>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-3"></div>
                    @endforeach

                    
                </div>

            </div>
        </div>
    </div>
     @endif
        @if ($solicitud->estado == 2)
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon2-chat-1 text-primary"></i>
                                </span>
                                <h3 class="card-label">Respuesta a su solicitud:</h3>
                            </div>

                        </div>
                        <div class="card-body">


                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Fecha y hora respuesta:</label>
                                <div class="col-lg-6">
                                    <p class="form-control-plaintext text-muted">
                                        {{ \Carbon\Carbon::parse($solicitud->updated_at)->formatLocalized('%d-%m-%Y %H:%M') }}
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Respuesta:</label>
                                <div class="col-lg-6">
                                    <p class="form-control-plaintext text-muted">
                                        {{ $solicitud->respuesta_observacion }}</p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Archivos de respuesta:</label>
                                <div class="col-lg-6">
                                    @if (is_array($documentos_respuesta) == true)
                                        <div class="list-group">

                                            @foreach ($documentos_respuesta as $documento)
                                                <a href="/download-file-public/{{ $documento->url }}"
                                                    class="list-group-item">
                                                    <i class="pull-right text-muted la la-download"></i>
                                                    <i class="la la-paperclip"></i>
                                                    {{ $documento->desc }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="form-control-plaintext text-muted"> Sin adjuntos</p>
                                    @endif


                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Email encargado:</label>
                                <div class="col-lg-6">
                                    <p class="form-control-plaintext text-muted"> {{ $tipsoli->emailencargado }}</p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Teléfono encargado:</label>
                                <div class="col-lg-6">
                                    <p class="form-control-plaintext text-muted"> {{ $tipsoli->fonoencargado }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif

    

</form>
