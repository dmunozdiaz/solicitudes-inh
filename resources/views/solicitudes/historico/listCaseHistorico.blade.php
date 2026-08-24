<div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle mb-8" id="accordionExample7">
    @foreach ($historicos as $historico)
        
        <div class="card card-custom col-lg-12">


            <div class="card-header">
                <div class="card-title" data-bs-toggle="collapse" data-bs-target="#collapse{{$loop->iteration}}">


                    <span class="svg-icon svg-icon-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"></path>
                            <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>
                            </g>
                        </svg>
                    </span>


                    <!--<span class="card-icon">
                        <i class="fa fa-clock text-primary"></i>
                    </span>-->
                    <h3 class="card-label">
                        {{ html_entity_decode($historico["username"]) }}
                        <small>{{ $historico["create_date"] }}</small>
                    </h3>
                </div>
                <div class="card-toolbar">
                    <span style="font-weight: 500;width: auto; padding: 0.9rem 0.75rem;    height: 45px;font-size: 0.9rem;border-radius: 0.42rem;color: #3699FF;background-color: #E1F0FF;">{{ $historico["task_title"] }}</span>
                    
                </div>
            </div>

            <div id="collapse{{$loop->iteration}}" class="collapse  show " data-bs-parent="#accordionExample7">
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            @foreach (array_reverse($historico['datos']) as $label => $datos)
                                @if ($label != 'fechaHistorial')
                                    @if ($label != 'username')
                                        @if ($label != 'case_id')
                                            @if ($label != 'adjuntos')
                                                <tr>
                                                    @if ($label != 'uid_proyecto')
                                                        <td class="listahistorico-cell listahistorico-cell-etiqueta font-weight-bold" style="width: 280px;">{{ html_entity_decode($label )}}</td>
                                                        @if (is_array($datos))                                                     
                                                            @if ($datos['type'] == 'files')
                                                                <td>
                                                                    @if (is_array($datos['data']))
                                                                        <div class="list-group">
                                                                            @foreach ($datos['data'] as $adjunto)
                                                                                <a href="/download-file/{{ $adjunto['url'] }}" class="list-group-item" >
                                                                                    <i class="pull-right text-muted la la-download"></i>
                                                                                    <i class="la la-paperclip"></i>
                                                                                    {{ $adjunto['desc'] }}
                                                                                </a>
                                                                            @endforeach
                                                                        </div>
                                                                    @else
                                                                        Sin adjuntos                                                                  
                                                                    @endif
                                                                </td>
                                                            @elseif ($datos['type'] == 'table')
                                                                <td>
                                                                    <table class="table">
                                                                        <thead class="thead-light">
                                                                            <tr>
                                                                                @foreach ($datos['data']['head'] as $head)   
                                                                                    @foreach ($head as $adjunto2)                                                                     
                                                                                        <th>{{ $adjunto2 }}</th>
                                                                                    @endforeach
                                                                                @endforeach
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($datos['data']['body'] as $body)
                                                                                <tr>
                                                                                    @foreach ($body as $adjunto2)
                                                                                        @if ($adjunto2 != '')
                                                                                            <td style="padding: .75rem; vertical-align: top; border-top: 1px solid #ebedf2;">
                                                                                                {{ $adjunto2 }}
                                                                                            </td>
                                                                                        @else
                                                                                            <td>
                                                                                                Sin detalle
                                                                                            </td>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            @elseif ($datos['type'] == 'cert_firmados')
                                                                <td>
                                                                    @if (is_array($datos['data']))
                                                                        <div class="list-group">       
                                                                            @foreach ($datos['data'] as $adjunto)
                                                                                <a href="/index.php?eID=descargaSegura&file={{ $adjunto['code_file'] }}&desc_certificado=1" class="list-group-item" >
                                                                                    <i class="pull-right text-muted la la-download"></i>
                                                                                    <i class="la la-paperclip"></i>
                                                                                    {{ $adjunto['name_file'] }}
                                                                                </a>       
                                                                            @endforeach
                                                                        </div>
                                                                    @else
                                                                        Sin adjuntos 
                                                                    @endif
                                                                </td>
                                                            @endif
                                                        @else
                                                            <td>
                                                                @if ($datos != '')
                                                                    {{ html_entity_decode($datos) }}
                                                                @else
                                                                    @switch($label)
                                                                        @case('Referencia:')
                                                                            Sin referencia
                                                                            @break
                                                                        @case('Descripci&oacute;n:')
                                                                            Sin descripción
                                                                            @break
                                                                        @default
                                                                            Sin observaciones
                                                                    @endswitch
                                                                @endif
                                                            </td>
                                                        @endif
                                                    @endif
                                                <tr>
                                            @endif
                                        @endif
                                    @endif
                                @endif                            
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    @endforeach
    </div>

    <iframe id="iframe-prueba" width="100%" height="700" scrolling="no" frameBorder="0">