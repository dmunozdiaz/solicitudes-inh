<table>
    <thead>
    <tr>
        <th>Número solicitud</th>
        <th>Fecha solicitud</th>
        <th>Estado</th>
        <th>Solicitante</th>
        <th>RUT</th>
        <th>Email</th>
        <th>Tipo de Solicitud</th>
        <th>Procedencia</th>
        <th>Ingresada por</th>
        <th>Texto descripción</th>
        <th>Encargado Recepción</th>
        <th>Fecha de respuesta</th>
        <th>Responsable respuesta</th>
        <th>Texto Respuesta</th>

    </tr>
    </thead>
    <tbody>
     @foreach ($datos as $dato )
     <tr>
        <td>{{$dato['NUMBER']}}</td>
        <td>{{$dato['fecha_solicitud']}}</td>
        <td>{{$dato['estado']}}</td>
        <td>{{$dato['solicitate']}}</td>
        <td>{{$dato['rut']}}</td>
        <td>{{$dato['email']}}</td>
        <td>{{$dato['solicitud']}}</td>
        <td>{{$dato['procedencia']}}</td>
        <td>{{$dato['ingresada_por']}}</td>
        <td>{{$dato['descripcion']}}</td>
        <td>{{$dato['encargado_recepcion']}}</td>
        <td>{{$dato['fecha_respuesta']}}</td>
        <td>{{$dato['responsable_respuesta']}}</td>
        <td>{{$dato['respuesta']}}</td>

    </tr>
     @endforeach
    </tbody>
</table>